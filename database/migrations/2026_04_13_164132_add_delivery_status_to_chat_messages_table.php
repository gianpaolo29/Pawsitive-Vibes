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
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->boolean('is_delivered')->default(false)->after('is_read');
            $table->timestamp('delivered_at')->nullable()->after('is_delivered');
            $table->timestamp('read_at')->nullable()->after('delivered_at');
        });

        // Create typing indicators table
        Schema::create('chat_typing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable();
            $table->enum('typer_type', ['customer', 'admin']);
            $table->timestamp('last_typed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropColumn(['is_delivered', 'delivered_at', 'read_at']);
        });

        Schema::dropIfExists('chat_typing');
    }
};
