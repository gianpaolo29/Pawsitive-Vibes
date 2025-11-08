<?php

namespace App\Services;

use App\Models\{LoyaltyCard, LoyaltyStickerEvent, LoyaltyRedemption, User, Transaction, Product};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class LoyaltyService
{
    const MIN_PURCHASE = 300; 
    const STICKERS_TO_REDEEM = 9;

    public function ensureCard(int $userId): LoyaltyCard
    {
        return LoyaltyCard::firstOrCreate(['user_id' => $userId], ['stickers_balance' => 0]);
    }

    public function earnFromTransaction(Transaction $tx, int $createdBy = null): ?LoyaltyStickerEvent
    {
        if ((float)$tx->amount < self::MIN_PURCHASE) return null;

        $card = $this->ensureCard($tx->user_id);

        return DB::transaction(function () use ($card, $tx, $createdBy) {
            $already = $card->events()
                ->where('transaction_id', $tx->id)
                ->where('type', 'earn')->exists();
            if ($already) return null;

            $card->increment('stickers_balance', 1);

            return LoyaltyStickerEvent::create([
                'loyalty_card_id' => $card->id,
                'transaction_id'  => $tx->id,
                'type'            => 'earn',
                'stickers'        => 1,
                'created_by'      => $createdBy,
            ]);
        });
    }

    public function adjust(int $cardId, int $stickers, ?int $adminId): LoyaltyStickerEvent
    {
        if ($stickers === 0) throw ValidationException::withMessages(['stickers' => 'Non-zero value required.']);
        $card = LoyaltyCard::lockForUpdate()->findOrFail($cardId);

        return DB::transaction(function () use ($card, $stickers, $adminId) {
            $new = $card->stickers_balance + $stickers;
            if ($new < 0) throw ValidationException::withMessages(['stickers' => 'Insufficient balance.']);

            $card->update(['stickers_balance' => $new]);

            return LoyaltyStickerEvent::create([
                'loyalty_card_id' => $card->id,
                'type'            => 'adjust',
                'stickers'        => $stickers, 
                'created_by'      => $adminId,
            ]);
        });
    }

    public function requestRedemption(int $cardId, int $rewardProductId, ?int $txId, int $createdBy = null): LoyaltyRedemption
    {
        $card = LoyaltyCard::lockForUpdate()->findOrFail($cardId);

        if ($card->stickers_balance < self::STICKERS_TO_REDEEM) {
            throw ValidationException::withMessages(['stickers' => 'Not enough stickers to redeem.']);
        }

        return DB::transaction(function () use ($card, $rewardProductId, $txId, $createdBy) {
            $card->decrement('stickers_balance', self::STICKERS_TO_REDEEM);

            LoyaltyStickerEvent::create([
                'loyalty_card_id' => $card->id,
                'transaction_id'  => $txId,
                'type'            => 'redeem',
                'stickers'        => -self::STICKERS_TO_REDEEM,
                'created_by'      => $createdBy,
            ]);

            return LoyaltyRedemption::create([
                'loyalty_card_id'  => $card->id,
                'transaction_id'   => $txId,
                'reward_product_id'=> $rewardProductId,
                'stickers_spent'   => self::STICKERS_TO_REDEEM,
                'status'           => 'pending',
            ]);
        });
    }

    public function approve(LoyaltyRedemption $redemption, int $adminId): LoyaltyRedemption
    {
        if ($redemption->status !== 'pending') return $redemption;

        $redemption->update([
            'status'      => 'approved',
            'approved_by' => $adminId,
            'approved_at' => Carbon::now(),
        ]);

        return $redemption;
    }

    public function reject(LoyaltyRedemption $redemption, int $adminId): LoyaltyRedemption
    {
        if ($redemption->status !== 'pending') return $redemption;

        return DB::transaction(function () use ($redemption, $adminId) {
            $card = $redemption->card()->lockForUpdate()->first();

            $card->increment('stickers_balance', $redemption->stickers_spent);

            LoyaltyStickerEvent::create([
                'loyalty_card_id' => $card->id,
                'type'            => 'adjust',
                'stickers'        => +$redemption->stickers_spent,
                'created_by'      => $adminId,
            ]);

            $redemption->update([
                'status'      => 'rejected',
                'approved_by' => $adminId,
                'approved_at' => Carbon::now(),
            ]);

            return $redemption;
        });
    }
}
