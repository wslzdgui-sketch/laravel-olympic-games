<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discipline;

class DisciplineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $competitions = [
            [
                'nom' => 'Ski alpin',
                'titre' => 'Qualifications',
                'lieu' => 'Forum di Assago',
                'jour' => '2026-02-01',
                'heure_debut' => '09:00:00',
                'heure_fin' => '12:00:00',
                'prix' => 45.00,
            ],
            [
                'nom' => 'Ski alpin',
                'titre' => 'Finale',
                'lieu' => 'Forum di Assago',
                'jour' => '2026-02-02',
                'heure_debut' => '10:00:00',
                'heure_fin' => '13:00:00',
                'prix' => 85.00,
            ],

            [
                'nom' => 'Patinage',
                'titre' => 'Qualifications',
                'lieu' => 'Piste Stelvio',
                'jour' => '2026-02-02',
                'heure_debut' => '14:00:00',
                'heure_fin' => '16:30:00',
                'prix' => 50.00,
            ],
            [
                'nom' => 'Patinage',
                'titre' => 'Finale',
                'lieu' => 'Piste Stelvio',
                'jour' => '2026-02-03',
                'heure_debut' => '18:00:00',
                'heure_fin' => '21:00:00',
                'prix' => 120.00,
            ],

            [
                'nom' => 'Snowboard',
                'titre' => 'Qualifications',
                'lieu' => 'Aurora',
                'jour' => '2026-02-03',
                'heure_debut' => '09:30:00',
                'heure_fin' => '11:30:00',
                'prix' => 40.00,
            ],
            [
                'nom' => 'Snowboard',
                'titre' => 'Finale',
                'lieu' => 'Aurora',
                'jour' => '2026-02-05',
                'heure_debut' => '15:00:00',
                'heure_fin' => '17:30:00',
                'prix' => 75.00,
            ],

            [
                'nom' => 'Hockey sur glace',
                'titre' => 'Qualifications',
                'lieu' => 'San Siro',
                'jour' => '2026-02-04',
                'heure_debut' => '20:00:00',
                'heure_fin' => '22:30:00',
                'prix' => 60.00,
            ],
            [
                'nom' => 'Hockey sur glace',
                'titre' => 'Finale',
                'lieu' => 'San Siro',
                'jour' => '2026-02-10',
                'heure_debut' => '20:00:00',
                'heure_fin' => '23:00:00',
                'prix' => 150.00,
            ]
        ];

        foreach ($competitions as $comp) {
            Discipline::create($comp);
        }
    }
}