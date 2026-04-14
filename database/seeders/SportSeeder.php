<?php

namespace Database\Seeders;

use App\Models\Sport;
use App\Models\Tour;
use App\Models\Venue;
use Illuminate\Database\Seeder;

class SportSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer les venues par nom pour les associer
        $assago  = Venue::where('name', 'Forum di Assago')->first();
        $stelvio = Venue::where('name', 'Piste Stelvio')->first();
        $aurora  = Venue::where('name', 'Palais Aurora')->first();
        $sanSiro = Venue::where('name', 'San Siro Arena')->first();
        $civica  = Venue::where('name', 'Arena Civica')->first();

        $sports = [
            [
                'nom' => 'Ski alpin',
                'tours' => [
                    ['titre' => 'Qualifications', 'venue_id' => $assago->id,  'jour' => '2026-02-01', 'heure_debut' => '09:00', 'heure_fin' => '12:00', 'prix' => 45.00],
                    ['titre' => 'Demi-finale',    'venue_id' => $assago->id,  'jour' => '2026-02-02', 'heure_debut' => '10:00', 'heure_fin' => '13:00', 'prix' => 65.00],
                    ['titre' => 'Finale',         'venue_id' => $assago->id,  'jour' => '2026-02-03', 'heure_debut' => '15:00', 'heure_fin' => '18:00', 'prix' => 85.00],
                ],
            ],
            [
                'nom' => 'Patinage artistique',
                'tours' => [
                    ['titre' => 'Qualifications', 'venue_id' => $stelvio->id, 'jour' => '2026-02-02', 'heure_debut' => '14:00', 'heure_fin' => '16:30', 'prix' => 50.00],
                    ['titre' => 'Finale',         'venue_id' => $stelvio->id, 'jour' => '2026-02-04', 'heure_debut' => '18:00', 'heure_fin' => '21:00', 'prix' => 120.00],
                ],
            ],
            [
                'nom' => 'Snowboard',
                'tours' => [
                    ['titre' => 'Qualifications', 'venue_id' => $aurora->id,  'jour' => '2026-02-03', 'heure_debut' => '09:30', 'heure_fin' => '11:30', 'prix' => 40.00],
                    ['titre' => 'Finale',         'venue_id' => $aurora->id,  'jour' => '2026-02-05', 'heure_debut' => '15:00', 'heure_fin' => '17:30', 'prix' => 75.00],
                ],
            ],
            [
                'nom' => 'Hockey sur glace',
                'tours' => [
                    ['titre' => 'Qualifications', 'venue_id' => $sanSiro->id, 'jour' => '2026-02-04', 'heure_debut' => '20:00', 'heure_fin' => '22:30', 'prix' => 60.00],
                    ['titre' => 'Demi-finale',    'venue_id' => $sanSiro->id, 'jour' => '2026-02-08', 'heure_debut' => '19:00', 'heure_fin' => '21:30', 'prix' => 90.00],
                    ['titre' => 'Finale',         'venue_id' => $sanSiro->id, 'jour' => '2026-02-10', 'heure_debut' => '20:00', 'heure_fin' => '23:00', 'prix' => 150.00],
                ],
            ],
            [
                'nom' => 'Biathlon',
                'tours' => [
                    ['titre' => 'Qualifications', 'venue_id' => $civica->id,  'jour' => '2026-02-05', 'heure_debut' => '10:00', 'heure_fin' => '12:30', 'prix' => 35.00],
                    ['titre' => 'Finale',         'venue_id' => $civica->id,  'jour' => '2026-02-07', 'heure_debut' => '14:00', 'heure_fin' => '17:00', 'prix' => 70.00],
                ],
            ],
        ];

        foreach ($sports as $sportData) {
            $sport = Sport::create(['nom' => $sportData['nom']]);
            foreach ($sportData['tours'] as $tourData) {
                Tour::create([
                    'sport_id'    => $sport->id,
                    'venue_id'    => $tourData['venue_id'],
                    'titre'       => $tourData['titre'],
                    'jour'        => $tourData['jour'],
                    'heure_debut' => $tourData['heure_debut'],
                    'heure_fin'   => $tourData['heure_fin'],
                    'prix'        => $tourData['prix'],
                ]);
            }
        }
    }
}
