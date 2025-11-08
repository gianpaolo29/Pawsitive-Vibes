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
        Schema::create('payments', function (Blueprint $t) {
                    $t->id();
                    $t->foreignId('transaction_id')->constrained('transactions')->cascadeOnDelete();
                    $t->enum('method', ['cash','gcash']);
                    $t->decimal('amount', 10, 2);
                    $t->enum('status', ['pending','accepted','rejected','voided'])->default('pending');
                    $t->string('receipt_image_url', 255)->nullable();
                    $t->string('provider_ref', 100)->nullable();
                    $t->timestamps();
                    $t->unique('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
