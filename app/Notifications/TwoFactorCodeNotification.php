<?php

namespace App\Notifications;

use App\Channels\BrevoChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TwoFactorCodeNotification extends Notification
{
    public function __construct(public string $code)
    {
    }

    public function via(object $notifiable): array
    {
        if (config('services.brevo.key')) {
            return [BrevoChannel::class];
        }

        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $appName = config('app.name');

        return (new MailMessage)
            ->subject('Your ' . $appName . ' Login Code: ' . $this->code)
            ->greeting('Hello ' . ($notifiable->fname ?? 'there') . '!')
            ->line('Your two-factor authentication code is:')
            ->line('**' . $this->code . '**')
            ->line('This code will expire in 10 minutes.')
            ->line('If you did not attempt to log in, please change your password immediately.')
            ->salutation('Stay safe, The ' . $appName . ' Team');
    }

    public function toBrevo(object $notifiable): void
    {
        $appName = config('app.name');
        $userName = $notifiable->fname ?? 'there';
        $email = $notifiable->email;

        $html = '<!DOCTYPE html><html><body style="margin:0;padding:0;background:#f8f7ff;font-family:sans-serif;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8f7ff;padding:40px 0;">
        <tr><td align="center">
        <table width="500" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:12px;border:1px solid #e0ddf5;box-shadow:0 2px 8px rgba(138,43,226,0.08);">
        <tr><td align="center" style="padding:30px 0;background:linear-gradient(135deg,#8a2be2,#6a0dad);border-radius:12px 12px 0 0;">
            <div style="font-size:28px;margin-bottom:8px;">🔐</div>
            <span style="font-size:20px;font-weight:700;color:#fff;">' . $appName . '</span>
        </td></tr>
        <tr><td style="padding:32px;">
            <h1 style="color:#8a2be2;font-size:18px;margin:0 0 16px;">Hello ' . htmlspecialchars($userName) . '!</h1>
            <p style="color:#444;font-size:15px;line-height:1.5;margin:0 0 20px;">Your two-factor authentication code is:</p>
            <div style="text-align:center;margin:20px 0;">
                <div style="display:inline-block;background:linear-gradient(135deg,#f3e8ff,#ede9fe);border:2px solid #8a2be2;border-radius:12px;padding:16px 40px;letter-spacing:8px;font-size:32px;font-weight:800;color:#8a2be2;">' . $this->code . '</div>
            </div>
            <p style="color:#444;font-size:14px;line-height:1.5;margin:0 0 12px;">This code will expire in <strong>10 minutes</strong>.</p>
            <p style="color:#888;font-size:13px;line-height:1.5;margin:0;">If you did not attempt to log in, please change your password immediately.</p>
            <p style="color:#444;font-size:14px;margin:24px 0 0;">Stay safe,<br>The ' . htmlspecialchars($appName) . ' Team</p>
        </td></tr>
        <tr><td align="center" style="padding:16px;border-top:1px solid #e0ddf5;">
            <p style="color:#999;font-size:12px;margin:0;">&copy; ' . date('Y') . ' ' . htmlspecialchars($appName) . '. All rights reserved.</p>
        </td></tr>
        </table></td></tr></table></body></html>';

        $response = Http::withHeaders([
            'api-key' => config('services.brevo.key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'name' => config('mail.from.name', $appName),
                'email' => config('mail.from.address'),
            ],
            'to' => [
                ['email' => $email, 'name' => $userName],
            ],
            'subject' => 'Your ' . $appName . ' Login Code: ' . $this->code,
            'htmlContent' => $html,
        ]);

        if (!$response->successful()) {
            Log::error('Brevo 2FA email error: ' . $response->body());
        }
    }
}
