<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Sport;
use App\Models\Reservation;
use App\Models\Spectator;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $sports = Sport::with('tours')->orderBy('nom')->get();

        // Filtre prix sur les tours
        $query = Tour::with(['sport', 'venue'])->orderBy('jour')->orderBy('heure_debut');

        if ($request->filled('prix_min')) {
            $query->where('prix', '>=', $request->prix_min);
        }

        if ($request->filled('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }

        $tours = $query->get();

        // Calcul des places disponibles par tour
        $placesDisponibles = [];
        $reservations = Reservation::all();
        foreach ($tours as $tour) {
            $vendus = 0;
            foreach ($reservations as $res) {
                foreach ($res->competitions as $comp) {
                    if ($comp['tour_id'] == $tour->id) {
                        $vendus += $comp['quantity'];
                    }
                }
            }
            $placesDisponibles[$tour->id] = max(0, $tour->venue->capacity - $vendus);
        }

        return view('billetterie', compact('tours', 'sports', 'placesDisponibles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'                    => 'required|string|max:255',
            'last_name'                     => 'required|string|max:255',
            'email'                         => 'required|email|max:255',
            'phone'                         => 'required|string|max:20',
            'competitions'                  => 'required|array|min:1',
            'competitions.*.tour_id'        => 'required|exists:tours,id',
            'competitions.*.quantity'       => 'required|integer|min:1',
            'spectators'                    => 'required|array|min:1',
            'spectators.*.first_name'       => 'required|string|max:255',
            'spectators.*.last_name'        => 'required|string|max:255',
        ]);

        // Calcul du prix total et vérification des places disponibles
        $totalPrice  = 0;
        $competitions = [];
        $allReservations = Reservation::all();

        foreach ($request->competitions as $comp) {
            $tour = Tour::with('venue')->findOrFail($comp['tour_id']);
            $qty  = (int) $comp['quantity'];

            // Vérifier places disponibles
            $vendus = 0;
            foreach ($allReservations as $res) {
                foreach ($res->competitions as $c) {
                    if ($c['tour_id'] == $tour->id) {
                        $vendus += $c['quantity'];
                    }
                }
            }
            $disponibles = $tour->venue->capacity - $vendus;

            if ($qty > $disponibles) {
                return back()
                    ->withInput()
                    ->withErrors(['competitions' => "Il ne reste que {$disponibles} place(s) pour {$tour->sport->nom} – {$tour->titre}."]);
            }

            $competitions[] = [
                'tour_id'  => $tour->id,
                'quantity' => $qty,
                'price'    => (float) $tour->prix,
            ];
            $totalPrice += $tour->prix * $qty;
        }

        // Créer la réservation
        $reservation = Reservation::create([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'competitions' => $competitions,
            'total_price'  => $totalPrice,
        ]);

        // Créer les spectateurs (email/phone identiques pour la même réservation, comme demandé)
        foreach ($request->spectators as $spec) {
            Spectator::create([
                'reservation_id' => $reservation->id,
                'first_name'     => $spec['first_name'],
                'last_name'      => $spec['last_name'],
                'email'          => $request->email,
                'phone'          => $request->phone,
            ]);
        }

        return redirect()->route('reservation.confirmation', $reservation->id);
    }

    public function confirmation($id)
    {
        $reservation = Reservation::with('spectators')->findOrFail($id);

        // Charger les tours associés pour l'affichage
        $toursData = [];
        foreach ($reservation->competitions as $comp) {
            $tour = Tour::with(['sport', 'venue'])->find($comp['tour_id']);
            if ($tour) {
                $toursData[] = [
                    'tour'     => $tour,
                    'quantity' => $comp['quantity'],
                    'price'    => $comp['price'],
                ];
            }
        }

        return view('confirmation', compact('reservation', 'toursData'));
    }

    public function cart()
    {
        return view('panier');
    }
}
