<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $t) {
                $t->id();
                $t->foreignId('user_id')->constrained()->cascadeOnDelete();
                $t->foreignId('cart_id')->nullable()->constrained()->nullOnDelete();
                $t->string('order_number', 50)->unique();
                $t->decimal('subtotal', 10, 2);
                $t->decimal('grand_total', 10, 2);
                $t->enum('status', ['pending','paid','cancelled','refunded'])->default('pending');
                $t->enum('payment_status', ['unpaid','paid','refunded'])->default('unpaid');
                $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
