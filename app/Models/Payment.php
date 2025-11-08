<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }


    public function accept(): void
    {
        $this->update(['status' => 'accepted']);
        $this->transaction->update(['status' => 'paid', 'payment_status' => 'paid']);
    }

    public function reject(): void
    {
        $this->update(['status' => 'rejected']);
        $this->transaction->update(['status' => 'pending', 'payment_status' => 'unpaid']);
    }
}
