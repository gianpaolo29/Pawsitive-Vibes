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
        Schema::table('users', function (Blueprint $table) {
            // Drop old custom columns if they exist
            $columns = Schema::getColumnListing('users');

            if (in_array('two_factor_enabled', $columns)) {
                $table->dropColumn('two_factor_enabled');
            }
            if (in_array('two_factor_code', $columns)) {
                $table->dropColumn('two_factor_code');
            }
            if (in_array('two_factor_expires_at', $columns)) {
                $table->dropColumn('two_factor_expires_at');
            }
        });

        // Ensure Fortify columns exist (text type, encrypted)
        Schema::table('users', function (Blueprint $table) {
            $columns = Schema::getColumnListing('users');

            if (!in_array('two_factor_secret', $columns)) {
                $table->text('two_factor_secret')->nullable()->after('password');
            }
            if (!in_array('two_factor_recovery_codes', $columns)) {
                $table->text('two_factor_recovery_codes')->nullable()->after('two_factor_secret');
            }
            if (!in_array('two_factor_confirmed_at', $columns)) {
                $table->timestamp('two_factor_confirmed_at')->nullable()->after('two_factor_recovery_codes');
            }
        });
    }

    public function down(): void
    {
        // No rollback needed
    }
};
