<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoChannel
{
    public function send(object $notifiable, Notification $notification): void
    {
        $notification->toBrevo($notifiable);
    }
}
