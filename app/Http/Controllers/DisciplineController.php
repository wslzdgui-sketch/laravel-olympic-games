<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use Illuminate\Http\Request;

class DisciplineController extends Controller
{
    public function index(Request $request)
    {
        return view('welcome');
    }

    public function calendrier(Request $request)
    {
        $allCompetitions = Discipline::all();
        $sports = $allCompetitions->pluck('nom')->unique();
        $lieux = $allCompetitions->pluck('lieu')->unique();

        $query = Discipline::orderBy('jour')->orderBy('heure_debut');

        if ($request->filled('sport') && $request->sport !== 'all') {
            $query->where('nom', $request->sport);
        }

        if ($request->filled('lieu') && $request->lieu !== 'all') {
            $query->where('lieu', $request->lieu);
        }

        $competitions = $query->get();

        return view('calendrier', compact('competitions', 'sports', 'lieux'));
    }
}