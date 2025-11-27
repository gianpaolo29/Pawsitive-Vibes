<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
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
