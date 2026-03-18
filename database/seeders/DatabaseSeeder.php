<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a couple of predictable users so the list is not empty.
        User::firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
        ]);

        // Add a few more fake users for demo purposes.
        User::factory(4)->create();
    }
}
