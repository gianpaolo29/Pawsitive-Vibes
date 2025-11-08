<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

   
    protected $guarded = ['id'];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function scopeSearch($query, ?string $term)
    {
        if (!$term) return $query;
        return $query->where('order_number', 'like', "%{$term}%")
            ->orWhereHas('user', fn($q) => $q->where('username', 'like', "%{$term}%"));
    }

    public function scopeStatus($query, ?string $status)
    {
        if (!$status) return $query;
        return $query->where('status', $status);
    }

    public function scopePaymentStatus($query, ?string $ps)
    {
        if (!$ps) return $query;
        return $query->where('payment_status', $ps);
    }

    public function markPaidCash(): void
    {
        $this->update(['status' => 'paid', 'payment_status' => 'paid']);
        $this->payment()->updateOrCreate([], [
            'method' => 'cash',
            'amount' => $this->grand_total,
            'status' => 'accepted',
        ]);
    }
}
