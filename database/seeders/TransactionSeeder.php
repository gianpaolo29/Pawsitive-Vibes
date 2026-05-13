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
        // Create 10 dummy customer accounts
        $customers = [
            ['fname' => 'Maria', 'lname' => 'Santos', 'username' => 'maria.santos', 'email' => 'maria.santos@example.com'],
            ['fname' => 'Juan', 'lname' => 'Dela Cruz', 'username' => 'juan.delacruz', 'email' => 'juan.delacruz@example.com'],
            ['fname' => 'Ana', 'lname' => 'Reyes', 'username' => 'ana.reyes', 'email' => 'ana.reyes@example.com'],
            ['fname' => 'Carlos', 'lname' => 'Garcia', 'username' => 'carlos.garcia', 'email' => 'carlos.garcia@example.com'],
            ['fname' => 'Sofia', 'lname' => 'Lopez', 'username' => 'sofia.lopez', 'email' => 'sofia.lopez@example.com'],
            ['fname' => 'Miguel', 'lname' => 'Ramos', 'username' => 'miguel.ramos', 'email' => 'miguel.ramos@example.com'],
            ['fname' => 'Isabella', 'lname' => 'Torres', 'username' => 'isabella.torres', 'email' => 'isabella.torres@example.com'],
            ['fname' => 'Rafael', 'lname' => 'Mendoza', 'username' => 'rafael.mendoza', 'email' => 'rafael.mendoza@example.com'],
            ['fname' => 'Camille', 'lname' => 'Villanueva', 'username' => 'camille.villanueva', 'email' => 'camille.villanueva@example.com'],
            ['fname' => 'Diego', 'lname' => 'Aquino', 'username' => 'diego.aquino', 'email' => 'diego.aquino@example.com'],
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
        // Start order numbers after any existing ones
        $lastOrder = Transaction::orderByDesc('id')->first();
        $orderNumber = $lastOrder ? ((int) str_replace('ORD-', '', $lastOrder->order_number)) + 1 : 1;

        foreach ($userModels as $user) {
            // Each customer gets exactly 5 transactions
            $transactionCount = 5;

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
