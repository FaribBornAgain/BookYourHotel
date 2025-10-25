<?php
// File: database/seeders/AdminSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@hotelhebat.com',
            'password' => Hash::make('admin123'),
            'user_type' => 'guest',
            'is_admin' => true,
            'email_verified_at' => now()
        ]);

        // Create Test Business User
        User::create([
            'name' => 'Business Owner',
            'email' => 'business@example.com',
            'password' => Hash::make('business123'),
            'user_type' => 'business',
            'is_admin' => false,
            'email_verified_at' => now()
        ]);

        // Create Test Guest User
        User::create([
            'name' => 'John Doe',
            'email' => 'guest@example.com',
            'password' => Hash::make('guest123'),
            'user_type' => 'guest',
            'is_admin' => false,
            'email_verified_at' => now()
        ]);
    }
}