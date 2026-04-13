<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GcashPaymentPending extends Notification
{
    use Queueable;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    // We’ll store in database only
    public function via($notifiable)
    {
        return ['database'];
    }

    // Data stored in notifications table
    public function toDatabase($notifiable)
    {
        $customer = $this->order->user?->fname ?? 'A customer';

        return [
            'title'         => 'GCash Payment Pending',
            'message'       => "{$customer} submitted a GCash payment of ₱" . number_format($this->order->grand_total, 2) . " for order #{$this->order->order_number}. Awaiting validation.",
            'order_id'      => $this->order->id,
            'order_number'  => $this->order->order_number,
            'amount'        => $this->order->grand_total,
            'created_by'    => $this->order->user?->username ?? 'Customer',
        ];
    }
}
