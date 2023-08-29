<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User 1',
            'email' => 'testuser1@example.com',
            'password' => Hash::make('1234'),
        ]);

        User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'testuser2@example.com',
            'password' => Hash::make('1234'),
        ]);
    }
}
