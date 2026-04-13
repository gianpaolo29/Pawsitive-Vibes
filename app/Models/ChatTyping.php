<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatTyping extends Model
{
    protected $table = 'chat_typing';

    protected $fillable = [
        'user_id',
        'session_id',
        'typer_type',
        'last_typed_at',
    ];

    protected $casts = [
        'last_typed_at' => 'datetime',
    ];
}
