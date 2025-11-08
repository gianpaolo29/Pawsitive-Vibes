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
        Schema::create('transaction_items', function (Blueprint $t) {
                $t->id();
                $t->foreignId('transaction_id')->constrained('transactions')->cascadeOnDelete();
                $t->foreignId('product_id')->constrained()->restrictOnDelete();
                $t->string('product_name', 255);
                $t->string('unit', 50);
                $t->decimal('unit_price', 10, 2);
                $t->integer('quantity');
                $t->decimal('line_total', 10, 2);
                $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
