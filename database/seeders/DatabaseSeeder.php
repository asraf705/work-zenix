<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 1,
        ]);

        User::factory()->create([
            'name' => 'Manager',
            'email' => 'Manager@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 2,
        ]);

        User::factory()->create([
            'name' => 'Devloper',
            'email' => 'Devloper@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 3,
        ]);

    }
}
