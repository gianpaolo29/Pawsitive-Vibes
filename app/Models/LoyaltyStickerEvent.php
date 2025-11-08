<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyStickerEvent extends Model
{
    protected $fillable = [
        'loyalty_card_id','transaction_id','type','stickers','created_by'
    ];

    protected $casts = ['stickers' => 'integer'];

    public function card()        { return $this->belongsTo(LoyaltyCard::class, 'loyalty_card_id'); }
    public function transaction() { return $this->belongsTo(Transaction::class); }
    public function creator()     { return $this->belongsTo(User::class, 'created_by'); }
}
