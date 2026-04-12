<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JO d'Hiver | Modifier une Compétition</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/acceuil.css') }}">
    <link rel="icon" href="{{ asset('picture/logojo.png') }}" type="image/png">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('admin.dashboard') }}">
        <div class="bg-white rounded-circle d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
            <img src="{{ asset('picture/logojo.png') }}" alt="Logo JO" width="30" height="30">
        </div>
        <span class="ms-2">JO d'Hiver - Organisateurs</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
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

<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-body">
            <h2 class="mb-4">✏️ Modifier une Compétition</h2>

            <form method="POST" action="{{ route('admin.competitions.update', $discipline) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nom" class="form-label">Sport</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ $discipline->nom }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="titre" class="form-label">Tour</label>
                        <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ $discipline->titre }}" required>
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="lieu" class="form-label">Lieu (Nom)</label>
                        <input type="text" class="form-control @error('lieu') is-invalid @enderror" id="lieu" name="lieu" value="{{ $discipline->lieu }}" required>
                        @error('lieu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="venue_id" class="form-label">Sélectionner Venue</label>
                        <select class="form-select @error('venue_id') is-invalid @enderror" id="venue_id" name="venue_id" required>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->id }}" {{ $discipline->venue_id == $venue->id ? 'selected' : '' }}>
                                    {{ $venue->name }} (Capacité: {{ $venue->capacity }})
                                </option>
                            @endforeach
                        </select>
                        @error('venue_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="jour" class="form-label">Date</label>
                        <input type="date" class="form-control @error('jour') is-invalid @enderror" id="jour" name="jour" value="{{ $discipline->jour }}" required>
                        @error('jour')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="heure_debut" class="form-label">Heure de début</label>
                        <input type="time" class="form-control @error('heure_debut') is-invalid @enderror" id="heure_debut" name="heure_debut" value="{{ $discipline->heure_debut }}" required>
                        @error('heure_debut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="heure_fin" class="form-label">Heure de fin</label>
                        <input type="time" class="form-control @error('heure_fin') is-invalid @enderror" id="heure_fin" name="heure_fin" value="{{ $discipline->heure_fin }}" required>
                        @error('heure_fin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="prix" class="form-label">Prix (€)</label>
                    <input type="number" step="0.01" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix" value="{{ $discipline->prix }}" required>
                    @error('prix')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
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