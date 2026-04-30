<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Sport;
use App\Models\Tour;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $tours        = Tour::with(['sport', 'venue'])->orderBy('jour')->orderBy('heure_debut')->get();
        $reservations = Reservation::with('spectators')->get();
        $venues       = Venue::orderBy('name')->get();
        $sports       = Sport::orderBy('nom')->get();

        // Compter les spectateurs par tour via la table pivot (1 seule requête SQL agrégée)
        $spectatorsByTour = DB::table('reservation_tour')
            ->select('tour_id', DB::raw('SUM(quantity) as total'))
            ->groupBy('tour_id')
            ->pluck('total', 'tour_id');

        $statistics = [];
        foreach ($tours as $tour) {
            $spectatorCount = $spectatorsByTour[$tour->id] ?? 0;
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
        // Empêche la suppression si des réservations existent (intégrité référentielle)
        if ($tour->reservations()->exists()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Impossible de supprimer ce tour : des réservations y sont associées.');
        }

        $tour->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Compétition supprimée avec succès.');
    }

    // ── Toutes les réservations ───────────────────────────────────────────────
    public function viewReservations()
    {
        $reservations = Reservation::with(['spectators', 'tours.sport', 'tours.venue'])
            ->latest()
            ->paginate(15);

        return view('organizer.reservations', compact('reservations'));
    }
}
