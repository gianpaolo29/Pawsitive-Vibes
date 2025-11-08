<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'description', 'price',
        'unit', 'stock', 'image_url', 'is_active',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getThumbUrlAttribute(): ?string
    {
        if (!$this->image_url) return null;
        return str_starts_with($this->image_url, 'http')
            ? $this->image_url
            : asset('storage/'.$this->image_url);
    }

    public function getStockStatusAttribute(): array
    {
        if ($this->stock <= 0) {
            return ['key' => 'out', 'label' => 'Out of Stock', 'color' => 'rose'];
        }
        if ($this->stock < 10) {
            return ['key' => 'low', 'label' => 'Low Stock', 'color' => 'amber'];
        }
        return ['key' => 'ok', 'label' => 'Normal', 'color' => 'emerald'];
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
