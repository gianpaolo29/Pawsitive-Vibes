<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Create dummy customer accounts
        $customers = [
            ['fname' => 'Maria', 'lname' => 'Santos', 'username' => 'maria.santos', 'email' => 'maria.santos@example.com'],
            ['fname' => 'Juan', 'lname' => 'Dela Cruz', 'username' => 'juan.delacruz', 'email' => 'juan.delacruz@example.com'],
            ['fname' => 'Ana', 'lname' => 'Reyes', 'username' => 'ana.reyes', 'email' => 'ana.reyes@example.com'],
            ['fname' => 'Carlos', 'lname' => 'Garcia', 'username' => 'carlos.garcia', 'email' => 'carlos.garcia@example.com'],
            ['fname' => 'Sofia', 'lname' => 'Lopez', 'username' => 'sofia.lopez', 'email' => 'sofia.lopez@example.com'],
        ];

        $userModels = [];
        foreach ($customers as $customer) {
            $userModels[] = User::firstOrCreate(
                ['email' => $customer['email']],
                [
                    'fname'    => $customer['fname'],
                    'lname'    => $customer['lname'],
                    'username' => $customer['username'],
                    'password' => Hash::make('password'),
                    'role'     => 'CUSTOMER',
                ]
            );
        }

        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->warn('No products found. Run ProductSeeder first.');
            return;
        }

        $statuses = ['pending', 'paid', 'cancelled'];
        $methods = ['cash', 'gcash'];
        $orderNumber = 1;

        foreach ($userModels as $user) {
            // Each customer gets 2-4 transactions
            $transactionCount = rand(2, 4);

            for ($i = 0; $i < $transactionCount; $i++) {
                $status = $statuses[array_rand($statuses)];
                $paymentStatus = $status === 'paid' ? 'paid' : ($status === 'cancelled' ? 'unpaid' : 'unpaid');

                // Pick 1-4 random products for this transaction
                $itemCount = rand(1, 4);
                $selectedProducts = $products->random($itemCount);

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

                $grandTotal = $subtotal;

                $transaction = Transaction::create([
                    'user_id'        => $user->id,
                    'order_number'   => 'ORD-' . str_pad($orderNumber++, 6, '0', STR_PAD_LEFT),
                    'subtotal'       => $subtotal,
                    'grand_total'    => $grandTotal,
                    'status'         => $status,
                    'payment_status' => $paymentStatus,
                ]);

                foreach ($items as $item) {
                    TransactionItem::create(array_merge($item, [
                        'transaction_id' => $transaction->id,
                    ]));
                }

                // Create payment for paid transactions
                if ($status === 'paid') {
                    Payment::create([
                        'transaction_id'  => $transaction->id,
                        'method'          => $methods[array_rand($methods)],
                        'amount'          => $grandTotal,
                        'status'          => 'accepted',
                    ]);
                }
            }
        }

        $this->command->info('Seeded ' . count($userModels) . ' customers and their transactions successfully!');
    }
}
