<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    use Queueable;

    public Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'        => 'low_stock',
            'product_id'  => $this->product->id,
            'name'        => $this->product->name,
            'stock'       => $this->product->stock,
            'threshold'   => 5,
            'created_at'  => now()->toDateTimeString(),
        ];
    }
}
