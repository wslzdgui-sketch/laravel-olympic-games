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
    <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/admin/dashboard') }}">
        <div class="bg-white rounded-circle d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
            <img src="{{ asset('picture/logojo.png') }}" alt="Logo JO" width="30" height="30">
        </div>
        <span class="ms-2">Dashboard Organisateurs</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.reservations') }}">Réservations</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/') }}">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/calendrier') }}">Calendrier</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/billetterie') }}">Billetterie</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="{{ route('organizer.logout') }}">Déconnexion</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid mt-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <h1 class="mb-4">📊 Tableau de Bord</h1>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h3 class="text-primary">{{ $disciplines->count() }}</h3>
                    <p class="text-muted">Compétitions programmées</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h3 class="text-success">{{ $reservations->count() }}</h3>
                    <p class="text-muted">Réservations totales</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h3 class="text-info">-- spectateurs</h3>
                    <p class="text-muted">Spectateurs totaux</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <a href="{{ route('admin.competitions.create') }}" class="btn btn-primary w-100 h-100 d-flex align-items-center justify-content-center">
                <span>➕ Ajouter une compétition</span>
            </a>
        </div>
    </div>

    <h2 class="mt-5 mb-4">📅 Gestion des Compétitions</h2>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Sport</th>
                    <th>Tour</th>
                    <th>Lieu</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Prix</th>
                    <th>Spectateurs</th>
                    <th>Places disponibles</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($statistics as $stat)
                <tr>
                    <td><strong>{{ $stat['discipline']->nom }}</strong></td>
                    <td>{{ $stat['discipline']->titre }}</td>
                    <td>
                        @if($stat['discipline']->venue)
                            {{ $stat['discipline']->venue->name }}
                        @else
                            {{ $stat['discipline']->lieu }}
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($stat['discipline']->jour)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($stat['discipline']->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($stat['discipline']->heure_fin)->format('H:i') }}</td>
                    <td>{{ $stat['discipline']->prix }} €</td>
                    <td><span class="badge bg-success">{{ $stat['spectators'] }}</span></td>
                    <td>
                        @if($stat['available'] >= 0)
                            <span class="badge bg-info">{{ $stat['available'] }}</span>
                        @else
                            <span class="badge bg-danger">COMPLET</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.competitions.edit', $stat['discipline']) }}" class="btn btn-sm btn-warning">✏️</a>
                        <form method="POST" action="{{ route('admin.competitions.delete', $stat['discipline']) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr?')">🗑️</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted">Aucune compétition programmée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<footer class="bg-dark text-center text-white py-3 mt-5">
    <div class="container">
        <small>
            © 2026 JO d'Hiver | Dashboard Organisateurs
        </small>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>