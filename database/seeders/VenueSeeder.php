<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        $venues = [
            ['name' => 'Forum di Assago',  'capacity' => 5000],
            ['name' => 'Piste Stelvio',    'capacity' => 8000],
            ['name' => 'Palais Aurora',    'capacity' => 3000],
            ['name' => 'San Siro Arena',   'capacity' => 12000],
            ['name' => 'Arena Civica',     'capacity' => 4500],
        ];

        foreach ($venues as $v) {
            Venue::create($v);
        }
    }
}
