<?php

namespace Database\Seeders;

use App\Models\Organizer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organizer::create([
            'name' => 'Administrateur',
            'email' => 'admin@jeux-olympiques.fr',
            'password' => Hash::make('password123'),
        ]);
    }
}
