<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummyTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'CUSTOMER')->first();

        if (! $user) {
            $this->command->error('No CUSTOMER user found. Create one first.');
            return;
        }

        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->error('No products found. Run ProductSeeder first.');
            return;
        }

        $statuses = ['pending', 'paid', 'cancelled'];
        $methods = ['cash', 'gcash'];

        $lastOrder = Transaction::orderByDesc('id')->first();
        $orderNumber = $lastOrder ? ((int) str_replace('ORD-', '', $lastOrder->order_number)) + 1 : 1;

        for ($i = 0; $i < 10; $i++) {
            $status = $statuses[array_rand($statuses)];
            $paymentStatus = $status === 'paid' ? 'paid' : 'unpaid';

            $selectedProducts = $products->random(rand(1, 4));
            $subtotal = 0;
            $items = [];

            foreach ($selectedProducts as $product) {
                $qty = rand(1, 3);
                $lineTotal = round($product->price * $qty, 2);
                $subtotal += $lineTotal;

                $items[] = [
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'unit'         => $product->unit,
                    'unit_price'   => $product->price,
                    'quantity'     => $qty,
                    'line_total'   => $lineTotal,
                ];
            }

            $transaction = Transaction::create([
                'user_id'        => $user->id,
                'order_number'   => 'ORD-' . str_pad($orderNumber++, 6, '0', STR_PAD_LEFT),
                'subtotal'       => $subtotal,
                'grand_total'    => $subtotal,
                'status'         => $status,
                'payment_status' => $paymentStatus,
            ]);

            foreach ($items as $item) {
                TransactionItem::create(array_merge($item, [
                    'transaction_id' => $transaction->id,
                ]));
            }

            if ($status === 'paid') {
                Payment::create([
                    'transaction_id' => $transaction->id,
                    'method'         => $methods[array_rand($methods)],
                    'amount'         => $subtotal,
                    'status'         => 'accepted',
                ]);
            }
        }

        $this->command->info("Seeded 10 transactions for {$user->fname} {$user->lname} ({$user->email})");
    }
}
