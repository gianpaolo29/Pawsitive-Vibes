<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
                'fname' => 'Pawsitive',
                'lname' => 'Admin',
                'username' => "admin",
                'password' => Hash::make('password123'),
                'role' => 'admin', 
                'email_verified_at' => now(),
            ]
        );
    }
}
