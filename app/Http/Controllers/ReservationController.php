<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Spectator;
use App\Models\Sport;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Calcul des places vendues par tour (1 seule requête SQL via la table pivot)
        $vendusByTour = DB::table('reservation_tour')
            ->select('tour_id', DB::raw('SUM(quantity) as total'))
            ->groupBy('tour_id')
            ->pluck('total', 'tour_id');

        $placesDisponibles = [];
        foreach ($tours as $tour) {
            $vendus = $vendusByTour[$tour->id] ?? 0;
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
        $totalPrice = 0;
        $attachData = [];

        foreach ($request->competitions as $comp) {
            $tour = Tour::with('venue', 'sport')->findOrFail($comp['tour_id']);
            $qty  = (int) $comp['quantity'];

            // Vérifier places disponibles via la table pivot
            $vendus = DB::table('reservation_tour')
                ->where('tour_id', $tour->id)
                ->sum('quantity');
            $disponibles = $tour->venue->capacity - $vendus;

            if ($qty > $disponibles) {
                return back()
                    ->withInput()
                    ->withErrors(['competitions' => "Il ne reste que {$disponibles} place(s) pour {$tour->sport->nom} – {$tour->titre}."]);
            }

            $attachData[$tour->id] = [
                'quantity' => $qty,
                'price'    => (float) $tour->prix,
            ];
            $totalPrice += $tour->prix * $qty;
        }

        // Transaction pour atomicité : tout réussit, ou rien n'est créé
        $reservation = DB::transaction(function () use ($request, $totalPrice, $attachData) {
            // Créer la réservation
            $reservation = Reservation::create([
                'first_name'  => $request->first_name,
                'last_name'   => $request->last_name,
                'email'       => $request->email,
                'phone'       => $request->phone,
                'total_price' => $totalPrice,
            ]);

            // Attacher les tours via la table pivot
            $reservation->tours()->attach($attachData);

            // Créer les spectateurs (email/phone identiques à l'acheteur, comme demandé)
            foreach ($request->spectators as $spec) {
                Spectator::create([
                    'reservation_id' => $reservation->id,
                    'first_name'     => $spec['first_name'],
                    'last_name'      => $spec['last_name'],
                    'email'          => $request->email,
                    'phone'          => $request->phone,
                ]);
            }

            return $reservation;
        });

        return redirect()->route('reservation.confirmation', $reservation->id);
    }

    public function confirmation($id)
    {
        $reservation = Reservation::with(['spectators', 'tours.sport', 'tours.venue'])
            ->findOrFail($id);

        return view('confirmation', compact('reservation'));
    }

    public function cart()
    {
        return view('panier');
    }
}
