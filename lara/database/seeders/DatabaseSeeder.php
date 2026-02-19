<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

         User::create([
            'name' => 'Jury User',
            'email' => 'jury@example.com',
            'password' => Hash::make('password'),
            'role' => 'jury',
        ]);

        User::create([
            'name' => 'Participant User',
            'email' => 'participant@example.com',
            'password' => Hash::make('password'),
            'role' => 'participant',
        ]);
    }
}
