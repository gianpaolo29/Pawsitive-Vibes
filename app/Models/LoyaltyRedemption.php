<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyRedemption extends Model
{
    protected $fillable = [
        'loyalty_card_id','transaction_id','reward_product_id',
        'stickers_spent','status','approved_by','approved_at'
    ];

    protected $casts = ['stickers_spent' => 'integer', 'approved_at' => 'datetime'];

    public function card()     { return $this->belongsTo(LoyaltyCard::class, 'loyalty_card_id'); }
    public function reward()   { return $this->belongsTo(Product::class, 'reward_product_id'); }
    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }
    public function transaction(){ return $this->belongsTo(Transaction::class); }
}
