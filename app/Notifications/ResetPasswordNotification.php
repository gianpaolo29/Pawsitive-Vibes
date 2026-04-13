<?php

namespace App\Notifications;

use App\Channels\BrevoChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ResetPasswordNotification extends Notification
{
    public function __construct(public string $token)
    {
    }

    public function via(object $notifiable): array
    {
        // Use Brevo HTTP API on production, mail channel locally
        if (config('services.brevo.key')) {
            return [BrevoChannel::class];
        }

        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $appName = config('app.name');

        return (new MailMessage)
            ->subject('Reset Your ' . $appName . ' Password')
            ->greeting('Hello ' . ($notifiable->fname ?? 'there') . '!')
            ->line('We received a request to reset the password for your ' . $appName . ' account.')
            ->action('Reset Password', $url)
            ->line('This password reset link will expire in 60 minutes.')
            ->line('If you did not request a password reset, no further action is required.')
            ->salutation('Paws & Love, The ' . $appName . ' Team');
    }

    /**
     * Send via Brevo HTTP API (no SMTP, no extra packages).
     */
    public function toBrevo(object $notifiable): void
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $appName = config('app.name');
        $userName = $notifiable->fname ?? 'there';
        $email = $notifiable->getEmailForPasswordReset();

        $html = view('emails.reset-password-brevo', [
            'url' => $url,
            'appName' => $appName,
            'userName' => $userName,
        ])->render();

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
            'subject' => 'Reset Your ' . $appName . ' Password',
            'htmlContent' => $html,
        ]);

        if (!$response->successful()) {
            Log::error('Brevo API error: ' . $response->body());
        }
    }
}
