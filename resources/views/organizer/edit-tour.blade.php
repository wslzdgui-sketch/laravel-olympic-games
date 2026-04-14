<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JO d'Hiver | Modifier un tour</title>
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
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.reservations') }}">Réservations</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="{{ route('organizer.logout') }}">Déconnexion</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <div class="card shadow border-0">
    <div class="card-body">
      <h2 class="mb-4">✏️ Modifier un tour de compétition</h2>

      <form method="POST" action="{{ route('admin.tours.update', $tour) }}">
        @csrf
        @method('PUT')

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Sport <span class="text-danger">*</span></label>
            <select name="sport_id" class="form-select @error('sport_id') is-invalid @enderror" required>
              @foreach($sports as $sport)
                <option value="{{ $sport->id }}" {{ (old('sport_id', $tour->sport_id) == $sport->id) ? 'selected' : '' }}>
                  {{ $sport->nom }}
                </option>
              @endforeach
            </select>
            @error('sport_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">Tour <span class="text-danger">*</span></label>
            <input type="text" name="titre"
                   class="form-control @error('titre') is-invalid @enderror"
                   value="{{ old('titre', $tour->titre) }}"
                   list="titres-list" required>
            <datalist id="titres-list">
              <option value="Qualifications">
              <option value="Demi-finale">
              <option value="Finale">
            </datalist>
            @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Lieu <span class="text-danger">*</span></label>
          <select name="venue_id" class="form-select @error('venue_id') is-invalid @enderror" required>
            @foreach($venues as $venue)
              <option value="{{ $venue->id }}" {{ (old('venue_id', $tour->venue_id) == $venue->id) ? 'selected' : '' }}>
                {{ $venue->name }} (capacité : {{ number_format($venue->capacity) }} places)
              </option>
            @endforeach
          </select>
          @error('venue_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
          <div class="col-md-4 mb-3">
            <label class="form-label">Date <span class="text-danger">*</span></label>
            <input type="date" name="jour"
                   class="form-control @error('jour') is-invalid @enderror"
                   value="{{ old('jour', $tour->jour) }}" required>
            @error('jour')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label">Heure de début <span class="text-danger">*</span></label>
            <input type="time" name="heure_debut"
                   class="form-control @error('heure_debut') is-invalid @enderror"
                   value="{{ old('heure_debut', $tour->heure_debut) }}" required>
            @error('heure_debut')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label">Heure de fin <span class="text-danger">*</span></label>
            <input type="time" name="heure_fin"
                   class="form-control @error('heure_fin') is-invalid @enderror"
                   value="{{ old('heure_fin', $tour->heure_fin) }}" required>
            @error('heure_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label">Prix du billet (€) <span class="text-danger">*</span></label>
          <input type="number" step="0.01" min="0" name="prix"
                 class="form-control @error('prix') is-invalid @enderror"
                 value="{{ old('prix', $tour->prix) }}" required>
          @error('prix')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
          <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Annuler</a>
        </div>
      </form>
    </div>
  </div>
</div>

<footer class="bg-dark text-center text-white py-3 mt-5">
  <div class="container"><small>© 2026 JO d'Hiver | Dashboard Organisateurs</small></div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
