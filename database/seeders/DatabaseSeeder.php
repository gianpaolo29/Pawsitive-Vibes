<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->firstOrCreate(
            ['email' => 'admin@pawsitive.com'],
            [
                'fname' => 'Gian Paolo',
                'lname' => 'Mulingbayan',
                'username' => "Admin",
                'password' => Hash::make('Computer_29'),
                'role' => 'admin', 
                'email_verified_at' => now(),
            ]
        );

    }
}
