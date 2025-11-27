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
        return [
            'order_id'      => $this->order->id,
            'order_number'  => $this->order->order_number,
            'amount'        => $this->order->grand_total,
            'message'       => 'New GCash payment awaiting validation.',
            'created_by'    => $this->order->user?->username ?? 'Customer',
        ];
    }
}
