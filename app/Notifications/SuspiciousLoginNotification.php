<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SuspiciousLoginNotification extends Notification
{
    use Queueable;

    public function __construct(
        public User $suspiciousUser,
        public int $ipCount,
        public array $ips,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $name = $this->suspiciousUser->fname . ' ' . $this->suspiciousUser->lname;

        return [
            'title'   => 'Suspicious Login Detected',
            'message' => "{$name} ({$this->suspiciousUser->email}) logged in from {$this->ipCount} different IP addresses in the last 24 hours. Account has been auto-blocked.",
            'type'    => 'suspicious_login',
            'user_id' => $this->suspiciousUser->id,
            'ips'     => $this->ips,
        ];
    }
}
