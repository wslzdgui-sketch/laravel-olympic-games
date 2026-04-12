<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Reservation;
use App\Models\Venue;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $disciplines = Discipline::with('venue')->get();
        $reservations = Reservation::with('spectators')->get();
        $venues = Venue::all();

        $statistics = [];
        foreach ($disciplines as $discipline) {
            $spectatorCount = 0;
            foreach ($reservations as $reservation) {
                $competitions = $reservation->competitions;
                foreach ($competitions as $comp) {
                    if ($comp['id'] == $discipline->id) {
                        $spectatorCount += $comp['quantity'];
                    }
                }
            }

            $availableSpots = $discipline->venue ? ($discipline->venue->capacity - $spectatorCount) : 0;

            $statistics[] = [
                'discipline' => $discipline,
                'spectators' => $spectatorCount,
                'available' => $availableSpots,
            ];
        }

        return view('organizer.dashboard', compact('disciplines', 'reservations', 'venues', 'statistics'));
    }

    public function createDiscipline()
    {
        $venues = Venue::all();
        return view('organizer.create-discipline', compact('venues'));
    }

    public function storeDiscipline(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'titre' => 'required|string',
            'lieu' => 'required|string',
            'jour' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i',
            'prix' => 'required|numeric',
            'venue_id' => 'required|exists:venues,id',
        ]);

        Discipline::create($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Compétition créée avec succès');
    }

    public function editDiscipline(Discipline $discipline)
    {
        $venues = Venue::all();
        return view('organizer.edit-discipline', compact('discipline', 'venues'));
    }

    public function updateDiscipline(Request $request, Discipline $discipline)
    {
        $request->validate([
            'nom' => 'required|string',
            'titre' => 'required|string',
            'lieu' => 'required|string',
            'jour' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i',
            'prix' => 'required|numeric',
            'venue_id' => 'required|exists:venues,id',
        ]);

        $discipline->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Compétition modifiée avec succès');
    }

    public function deleteDiscipline(Discipline $discipline)
    {
        $discipline->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Compétition supprimée avec succès');
    }

    public function viewReservations()
    {
        $reservations = Reservation::with('spectators')->paginate(15);
        return view('organizer.reservations', compact('reservations'));
    }
}
