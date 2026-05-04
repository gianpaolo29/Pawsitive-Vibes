<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = [
        'ticket_number',
        'user_id',
        'email',
        'name',
        'subject',
        'message',
        'status',
        'admin_remarks',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateTicketNumber(): string
    {
        $prefix = 'TKT-';
        $date = now()->format('Ymd');
        $lastTicket = static::where('ticket_number', 'like', $prefix . $date . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastTicket) {
            $lastNumber = (int) substr($lastTicket->ticket_number, -4);
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return $prefix . $date . '-' . $nextNumber;
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'open' => ['color' => 'bg-blue-100 text-blue-700', 'label' => 'Open'],
            'in_progress' => ['color' => 'bg-yellow-100 text-yellow-700', 'label' => 'In Progress'],
            'resolved' => ['color' => 'bg-green-100 text-green-700', 'label' => 'Resolved'],
            'rejected' => ['color' => 'bg-red-100 text-red-700', 'label' => 'Rejected'],
            default => ['color' => 'bg-gray-100 text-gray-700', 'label' => ucfirst($this->status)],
        };
    }
}
