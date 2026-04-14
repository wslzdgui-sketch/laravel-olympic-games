<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use App\Models\Tour;
use App\Models\Venue;
use App\Models\Reservation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $tours        = Tour::with(['sport', 'venue'])->orderBy('jour')->orderBy('heure_debut')->get();
        $reservations = Reservation::with('spectators')->get();
        $venues       = Venue::orderBy('name')->get();
        $sports       = Sport::orderBy('nom')->get();

        // Calcul spectateurs et places disponibles par tour
        $statistics = [];
        foreach ($tours as $tour) {
            $spectatorCount = 0;
            foreach ($reservations as $reservation) {
                foreach ($reservation->competitions as $comp) {
                    if ($comp['tour_id'] == $tour->id) {
                        $spectatorCount += $comp['quantity'];
                    }
                }
            }
            $capacity       = $tour->venue ? $tour->venue->capacity : 0;
            $available      = $capacity - $spectatorCount;

            $statistics[] = [
                'tour'       => $tour,
                'spectators' => $spectatorCount,
                'capacity'   => $capacity,
                'available'  => $available,
            ];
        }

        $totalSpectateurs = array_sum(array_column($statistics, 'spectators'));

        return view('organizer.dashboard', compact(
            'tours', 'reservations', 'venues', 'sports', 'statistics', 'totalSpectateurs'
        ));
    }

    // ── Créer un tour de compétition ──────────────────────────────────────────
    public function createTour()
    {
        $sports = Sport::orderBy('nom')->get();
        $venues = Venue::orderBy('name')->get();
        return view('organizer.create-tour', compact('sports', 'venues'));
    }

    public function storeTour(Request $request)
    {
        $request->validate([
            'sport_id'    => 'required|exists:sports,id',
            'venue_id'    => 'required|exists:venues,id',
            'titre'       => 'required|string|max:100',
            'jour'        => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin'   => 'required|date_format:H:i|after:heure_debut',
            'prix'        => 'required|numeric|min:0',
        ]);

        Tour::create($request->only([
            'sport_id', 'venue_id', 'titre', 'jour', 'heure_debut', 'heure_fin', 'prix',
        ]));

        return redirect()->route('admin.dashboard')
            ->with('success', 'Compétition créée avec succès.');
    }

    // ── Modifier un tour ──────────────────────────────────────────────────────
    public function editTour(Tour $tour)
    {
        $sports = Sport::orderBy('nom')->get();
        $venues = Venue::orderBy('name')->get();
        return view('organizer.edit-tour', compact('tour', 'sports', 'venues'));
    }

    public function updateTour(Request $request, Tour $tour)
    {
        $request->validate([
            'sport_id'    => 'required|exists:sports,id',
            'venue_id'    => 'required|exists:venues,id',
            'titre'       => 'required|string|max:100',
            'jour'        => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin'   => 'required|date_format:H:i|after:heure_debut',
            'prix'        => 'required|numeric|min:0',
        ]);

        $tour->update($request->only([
            'sport_id', 'venue_id', 'titre', 'jour', 'heure_debut', 'heure_fin', 'prix',
        ]));

        return redirect()->route('admin.dashboard')
            ->with('success', 'Compétition modifiée avec succès.');
    }

    // ── Supprimer un tour ─────────────────────────────────────────────────────
    public function deleteTour(Tour $tour)
    {
        $tour->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Compétition supprimée avec succès.');
    }

    // ── Toutes les réservations ───────────────────────────────────────────────
    public function viewReservations()
    {
        $reservations = Reservation::with('spectators')->latest()->paginate(15);

        // Charger les tours pour chaque réservation
        $toursMap = Tour::with(['sport', 'venue'])->get()->keyBy('id');

        return view('organizer.reservations', compact('reservations', 'toursMap'));
    }
}
