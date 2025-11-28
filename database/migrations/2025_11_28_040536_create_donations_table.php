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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();

            // 'products' or 'cash'
            $table->enum('type', ['products', 'cash']);

            // Donor info
            $table->string('name');
            $table->string('email');
            $table->string('phone', 50);

            // Cash-specific amount (nullable for product donations)
            $table->decimal('amount', 10, 2)->nullable();

            // Total monetary value (for both products and cash)
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->text('receipt_url')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
