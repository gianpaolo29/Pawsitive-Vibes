<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $guarded = [];

    public function items(): Donation|\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DonationItem::class);
    }
}
