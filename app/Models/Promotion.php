<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'name',
        'code',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'starts_at',
        'ends_at',
        'is_active',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
    ];

    public function getIsCurrentlyValidAttribute(): bool
    {
        $now = now();
        if (!$this->is_active) return false;
        if ($this->starts_at && $this->starts_at->isFuture()) return false;
        if ($this->ends_at && $this->ends_at->isPast()) return false;

        return true;
    }
}
