<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create an admin user for local testing if not exists
        $email = 'admin@example.com';

        if (!User::where('email', $email)->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }
    }
}
