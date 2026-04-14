<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JO d'Hiver | Réservations</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/acceuil.css') }}">
    <link rel="icon" href="{{ asset('picture/logojo.png') }}" type="image/png">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('admin.dashboard') }}">
      <div class="bg-white rounded-circle d-flex justify-content-center align-items-center" style="width:50px;height:50px;">
        <img src="{{ asset('picture/logojo.png') }}" alt="Logo JO" width="30" height="30">
      </div>
      <span class="ms-2">JO d'Hiver – Organisateurs</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link active" href="{{ route('admin.reservations') }}">Réservations</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Site public</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="{{ route('organizer.logout') }}">Déconnexion</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid mt-4">
  <h1 class="mb-4">📋 Toutes les réservations</h1>

  <div class="card shadow border-0">
    <div class="card-body">
      @if($reservations->count() > 0)
        <div class="table-responsive">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Client</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Compétitions réservées</th>
                <th>Spectateurs</th>
                <th>Total</th>
                <th>Date réservation</th>
              </tr>
            </thead>
            <tbody>
              @foreach($reservations as $reservation)
                <tr>
                  <td><strong>#{{ $reservation->id }}</strong></td>
                  <td>{{ $reservation->first_name }} {{ $reservation->last_name }}</td>
                  <td class="small">{{ $reservation->email }}</td>
                  <td class="small">{{ $reservation->phone }}</td>
                  <td>
                    @foreach($reservation->competitions as $comp)
                      @php $tour = $toursMap->get($comp['tour_id']); @endphp
                      @if($tour)
                        <div class="small">
                          <span class="badge bg-primary">{{ $tour->sport->nom }}</span>
                          <span class="badge bg-secondary">{{ $tour->titre }}</span>
                          × {{ $comp['quantity'] }}
                          <span class="text-muted">({{ \Carbon\Carbon::parse($tour->jour)->format('d/m/Y') }})</span>
                        </div>
                      @else
                        <span class="badge bg-warning text-dark">Tour #{{ $comp['tour_id'] }} supprimé</span>
                      @endif
                    @endforeach
                  </td>
                  <td>
                    <button class="btn btn-sm btn-outline-secondary" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#spec-{{ $reservation->id }}">
                      {{ $reservation->spectators->count() }} personne(s)
                    </button>
                    <div class="collapse mt-1" id="spec-{{ $reservation->id }}">
                      <ul class="list-unstyled small mb-0">
                        @foreach($reservation->spectators as $spec)
                          <li>👤 {{ $spec->first_name }} {{ $spec->last_name }}</li>
                        @endforeach
                      </ul>
                    </div>
                  </td>
                  <td><span class="badge bg-success">{{ number_format($reservation->total_price, 2) }} €</span></td>
                  <td class="small">{{ $reservation->created_at->format('d/m/Y H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
          {{ $reservations->links() }}
        </div>
      @else
        <div class="alert alert-secondary text-center">Aucune réservation enregistrée.</div>
      @endif
    </div>
  </div>
</div>

<footer class="bg-dark text-center text-white py-3 mt-5">
  <div class="container"><small>© 2026 JO d'Hiver | Dashboard Organisateurs</small></div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
