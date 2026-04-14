<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use App\Models\Tour;
use Illuminate\Http\Request;

class DisciplineController extends Controller
{
    public function index(Request $request)
    {
        return view('welcome');
    }

    public function calendrier(Request $request)
    {
        $sports = Sport::orderBy('nom')->get();
        $venues = \App\Models\Venue::orderBy('name')->get();

        $query = Tour::with(['sport', 'venue'])->orderBy('jour')->orderBy('heure_debut');

        if ($request->filled('sport_id') && $request->sport_id !== 'all') {
            $query->where('sport_id', $request->sport_id);
        }

        if ($request->filled('venue_id') && $request->venue_id !== 'all') {
            $query->where('venue_id', $request->venue_id);
        }

        $tours = $query->get();

        return view('calendrier', compact('tours', 'sports', 'venues'));
    }
}
