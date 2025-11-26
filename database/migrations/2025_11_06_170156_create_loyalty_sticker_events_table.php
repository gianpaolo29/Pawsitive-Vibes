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
        Schema::create('loyalty_sticker_events', function (Blueprint $t) {
                $t->id();
                $t->foreignId('loyalty_card_id')->constrained('loyalty_cards')->cascadeOnDelete();
                $t->foreignId('transaction_id')->nullable()->constrained('transactions')->nullOnDelete();
                $t->enum('type', ['earn','redeem','adjust']);
                $t->integer('stickers'); 
                $t->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $t->timestamps();


            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_sticker_events');
    }
};
