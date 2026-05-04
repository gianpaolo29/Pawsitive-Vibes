<?php

namespace App\Notifications;

use App\Models\ChatMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewChatMessageNotification extends Notification
{
    use Queueable;

    public function __construct(public ChatMessage $chatMessage, public string $senderName)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $isGuest = is_null($this->chatMessage->user_id);
        $preview = str()->limit($this->chatMessage->message, 80);

        $url = $isGuest
            ? route('admin.chat.show', 'guest') . '?type=guest&session=' . $this->chatMessage->session_id
            : route('admin.chat.show', $this->chatMessage->user_id) . '?type=user';

        return [
            'title' => 'New Chat Message',
            'message' => "{$this->senderName}" . ($isGuest ? ' (Guest)' : '') . ": {$preview}",
            'type' => 'new_chat',
            'url' => $url,
            'chat_message_id' => $this->chatMessage->id,
        ];
    }
}
