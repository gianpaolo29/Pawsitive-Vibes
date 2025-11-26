<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GcashPaymentPendingNotification extends Notification
{
    use Queueable;

    public Transaction $order;

    public function __construct(Transaction $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'         => 'gcash_pending',
            'order_id'     => $this->order->id,
            'order_number' => $this->order->order_number,
            'grand_total'  => $this->order->grand_total,
            'status'       => $this->order->status,
            'created_at'   => $this->order->created_at?->toDateTimeString(),
        ];
    }
}
