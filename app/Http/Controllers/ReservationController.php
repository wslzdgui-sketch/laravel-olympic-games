<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Reservation;
use App\Models\Spectator;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Discipline::query();

        if ($request->filled('prix_min')) {
            $query->where('prix', '>=', $request->prix_min);
        }

        if ($request->filled('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }

        $disciplines = $query->get();

        return view('billetterie', compact('disciplines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'competitions' => 'required|array',
            'competitions.*.id' => 'required|exists:disciplines,id',
            'competitions.*.quantity' => 'required|integer|min:1',
            'people' => 'required|array',
            'people.*' => 'required|string|max:255',
        ]);

        $totalPrice = 0;
        $competitions = [];

        foreach ($request->competitions as $comp) {
            $discipline = Discipline::find($comp['id']);
            $competitions[] = [
                'id' => $comp['id'],
                'quantity' => $comp['quantity'],
                'price' => $discipline->prix,
            ];
            $totalPrice += $discipline->prix * $comp['quantity'];
        }

        $reservation = Reservation::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'competitions' => $competitions,
            'people' => $request->people,
            'total_price' => $totalPrice,
        ]);

        // Create spectators for each person
        foreach ($request->people as $personName) {
            Spectator::create([
                'first_name' => explode(' ', trim($personName))[0],
                'last_name' => count(explode(' ', trim($personName))) > 1 ? implode(' ', array_slice(explode(' ', trim($personName)), 1)) : 'N/A',
                'email' => $request->email,
                'phone' => $request->phone,
                'reservation_id' => $reservation->id,
            ]);
        }

        return redirect()->route('reservation.confirmation', $reservation->id);
    }

    public function confirmation($id)
    {
        $reservation = Reservation::findOrFail($id);

        return view('confirmation', compact('reservation'));
    }
}
