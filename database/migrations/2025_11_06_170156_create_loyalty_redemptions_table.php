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
        Schema::create('loyalty_redemptions', function (Blueprint $t) {
                $t->id();
                $t->foreignId('loyalty_card_id')->constrained('loyalty_cards')->cascadeOnDelete();
                $t->foreignId('transaction_id')->nullable()->constrained('transactions')->nullOnDelete();
                $t->foreignId('reward_product_id')->constrained('products')->restrictOnDelete();
                $t->integer('stickers_spent')->default(9);
                $t->enum('status', ['pending','approved','rejected','cancelled'])->default('pending');
                $t->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
                $t->timestamp('approved_at')->nullable();
                $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_redemptions');
    }
};
