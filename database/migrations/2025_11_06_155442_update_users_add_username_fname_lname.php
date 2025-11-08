<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::table('users', function (Blueprint $table) {
            $table->string('fname', 100)->nullable()->after('id');
            $table->string('lname', 100)->nullable()->after('fname');
            $table->string('username', 100)->nullable()->after('lname');
        });

        $users = DB::table('users')->select('id', 'name', 'email')->get();

        foreach ($users as $u) {
            $full = trim((string) $u->name);
            if ($full === '') {
                $fname = 'User';
                $lname = (string) $u->id;
            } else {
     
                $parts = preg_split('/\s+/', $full, 2);
                $fname = $parts[0] ?? 'User';
                $lname = $parts[1] ?? '';
            }

        
            if (!empty($u->email) && str_contains($u->email, '@')) {
                $base = explode('@', $u->email)[0];
            } else {
                // fallback from name/id
                $base = strtolower(preg_replace('/[^a-z0-9]+/i', '', $fname . $lname));
                if ($base === '') $base = 'user' . $u->id;
            }

        
            $candidate = $base;
            $suffix = 1;
            while (
                DB::table('users')
                    ->where('username', $candidate)
                    ->where('id', '!=', $u->id)
                    ->exists()
            ) {
                $candidate = $base . $suffix;
                $suffix++;
            }

            DB::table('users')
                ->where('id', $u->id)
                ->update([
                    'fname'    => mb_substr($fname, 0, 100),
                    'lname'    => mb_substr($lname, 0, 100),
                    'username' => mb_substr($candidate, 0, 100),
                ]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->unique('username');
        });

        DB::statement('ALTER TABLE users MODIFY fname VARCHAR(100) NOT NULL');
        DB::statement('ALTER TABLE users MODIFY lname VARCHAR(100) NOT NULL');
        DB::statement('ALTER TABLE users MODIFY username VARCHAR(100) NOT NULL');


        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name');
            }
        });
    }

    public function down(): void
    {
   
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
        });


        $users = DB::table('users')->select('id', 'fname', 'lname')->get();
        foreach ($users as $u) {
            $full = trim(($u->fname ?? '') . ' ' . ($u->lname ?? ''));
            DB::table('users')->where('id', $u->id)->update(['name' => trim($full) ?: null]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn(['fname', 'lname', 'username']);
        });
    }
};
