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
    Schema::create('expenses', function (Blueprint $table) {
        $table->id();
        $table->string('category');            // e.g. Inventory, Rent, Salary, Marketing, Utilities
        $table->string('description')->nullable();
        $table->decimal('amount', 10, 2);
        $table->date('date');                 // date of expense
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('expenses');
}

};
