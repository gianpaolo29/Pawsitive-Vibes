<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyCard extends Model
{
    protected $fillable = ['user_id', 'stickers_balance'];

    public function user()             { return $this->belongsTo(User::class); }
    public function events()           { return $this->hasMany(LoyaltyStickerEvent::class); }
    public function redemptions()      { return $this->hasMany(LoyaltyRedemption::class); }
}
