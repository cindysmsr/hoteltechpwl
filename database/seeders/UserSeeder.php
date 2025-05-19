<?php

namespace Database\Seeders;

use App\Models\Guest;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create guest
        $user = User::create([
            'name' => 'Guest',
            'email' => 'guest@example.com',
            'password' => Hash::make('password'),
            'role' => 'guest',
        ]);

        Guest::create([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'id_card_type' => 'ID Card',
            'id_card_number' => fake()->unique()->regexify('[A-Z0-9]{10}'),
        ]);
    }
}
