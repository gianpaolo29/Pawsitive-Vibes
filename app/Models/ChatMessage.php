<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'guest_name',
        'guest_email',
        'message',
        'sender_type',
        'is_read',
        'is_delivered',
        'delivered_at',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_delivered' => 'boolean',
        'delivered_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSenderNameAttribute()
    {
        if ($this->user_id && $this->user) {
            return $this->user->fname . ' ' . $this->user->lname;
        }

        return $this->guest_name ?? 'Guest';
    }
}
