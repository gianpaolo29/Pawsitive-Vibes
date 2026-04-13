<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    public function __construct(public Transaction $order)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $method = ucfirst($this->order->payment_method ?? 'N/A');
        $customer = $this->order->user?->fname ?? 'A customer';

        return [
            'title'        => 'New Order Placed',
            'message'      => "{$customer} placed order #{$this->order->order_number} ({$method}) — ₱" . number_format($this->order->grand_total, 2),
            'order_id'     => $this->order->id,
            'order_number' => $this->order->order_number,
            'amount'       => $this->order->grand_total,
            'method'       => $this->order->payment_method,
            'status'       => $this->order->status,
        ];
    }
}
