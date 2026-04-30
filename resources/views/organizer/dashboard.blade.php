<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JO d'Hiver | Dashboard Organisateurs</title>
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
      <span class="ms-2">Dashboard Organisateurs</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.reservations') }}">Réservations</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Site public</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="{{ route('organizer.logout') }}">Déconnexion</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid mt-4">

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <h1 class="mb-4">📊 Tableau de bord</h1>

  {{-- Statistiques globales --}}
  <div class="row mb-4">
    <div class="col-6 col-md-3 mb-3">
      <div class="card text-center shadow-sm h-100">
        <div class="card-body">
          <h3 class="text-primary">{{ $tours->count() }}</h3>
          <p class="text-muted mb-0 small">Tours programmés</p>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
      <div class="card text-center shadow-sm h-100">
        <div class="card-body">
          <h3 class="text-info">{{ $sports->count() }}</h3>
          <p class="text-muted mb-0 small">Sports</p>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
      <div class="card text-center shadow-sm h-100">
        <div class="card-body">
          <h3 class="text-success">{{ $reservations->count() }}</h3>
          <p class="text-muted mb-0 small">Réservations</p>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
      <a href="{{ route('admin.tours.create') }}" class="card text-center shadow-sm h-100 text-decoration-none btn btn-primary d-flex align-items-center justify-content-center">
        <div>
          <div style="font-size:1.5rem">➕</div>
          <p class="mb-0 small fw-bold">Ajouter un tour</p>
        </div>
      </a>
    </div>
  </div>

  {{-- Tableau des tours --}}
  <h2 class="mt-4 mb-3">📅 Gestion des compétitions</h2>

  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
      <thead class="table-dark">
        <tr>
          <th>Sport</th>
          <th>Tour</th>
          <th>Lieu</th>
          <th>Date</th>
          <th>Horaires</th>
          <th>Prix</th>
          <th>Capacité</th>
          <th>Spectateurs</th>
          <th>Places dispo.</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($statistics as $stat)
          <tr>
            <td><strong>{{ $stat['tour']->sport->nom }}</strong></td>
            <td><span class="badge bg-secondary">{{ $stat['tour']->titre }}</span></td>
            <td>{{ $stat['tour']->venue->name }}</td>
            <td>{{ \Carbon\Carbon::parse($stat['tour']->jour)->format('d/m/Y') }}</td>
            <td class="small">
              {{ \Carbon\Carbon::parse($stat['tour']->heure_debut)->format('H:i') }} –
              {{ \Carbon\Carbon::parse($stat['tour']->heure_fin)->format('H:i') }}
            </td>
            <td>{{ number_format($stat['tour']->prix, 2) }} €</td>
            <td>{{ number_format($stat['capacity']) }}</td>
            <td><span class="badge bg-success">{{ $stat['spectators'] }}</span></td>
            <td>
              @if($stat['available'] > 0)
                <span class="badge bg-info text-dark">{{ $stat['available'] }}</span>
              @elseif($stat['available'] == 0)
                <span class="badge bg-danger">COMPLET</span>
              @else
                <span class="badge bg-danger">SURBOOKÉ</span>
              @endif
            </td>
            <td>
              <a href="{{ route('admin.tours.edit', $stat['tour']) }}" class="btn btn-sm btn-warning me-1">✏️</a>
              <form method="POST" action="{{ route('admin.tours.delete', $stat['tour']) }}" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"
                  onclick="return confirm('Supprimer ce tour ? Les réservations associées resteront en base.')">🗑️</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="10" class="text-center text-muted">Aucun tour programmé</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>

<footer class="bg-dark text-center text-white py-3 mt-5">
  <div class="container">
    <small>© 2026 JO d'Hiver | Dashboard Organisateurs</small>
  </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
