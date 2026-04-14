<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JO d'Hiver | Calendrier</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/acceuil.css') }}">
    <link rel="icon" href="{{ asset('picture/logojo.png') }}" type="image/png">
</head>
<body>

<div class="bg-slider">
    <div class="bg-slide"></div>
    <div class="bg-slide"></div>
    <div class="bg-slide"></div>
</div>

<div class="overlay">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/') }}">
      <div class="bg-white rounded-circle d-flex justify-content-center align-items-center" style="width:50px;height:50px;">
        <img src="{{ asset('picture/logojo.png') }}" alt="Logo JO" width="30" height="30">
      </div>
      <span class="ms-2 text-white">JO d'Hiver</span>
    </a>
    <div class="text-white header-values d-none d-lg-block">
      <span>📍 Milan</span>
      <span>📅 1 - 15 Février</span>
      <span>🎫 Ouvert</span>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item position-relative">
          <a class="nav-link position-relative text-dark fw-bold" href="{{ url('/') }}">
            <span class="bg-circle position-absolute"></span>Accueil
          </a>
        </li>
        <li class="nav-item position-relative">
          <a class="nav-link position-relative text-dark fw-bold active" href="{{ route('calendrier') }}">
            <span class="bg-circle position-absolute"></span>Calendrier
          </a>
        </li>
        <li class="nav-item position-relative">
          <a class="nav-link position-relative text-dark fw-bold" href="{{ route('billetterie') }}">
            <span class="bg-circle position-absolute"></span>Billetterie
          </a>
        </li>
        <li class="nav-item position-relative">
          <a class="nav-link position-relative text-dark fw-bold" href="{{ route('organizer.login') }}">
            <span class="bg-circle position-absolute"></span>Organisateurs
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5 flex-grow-1">
  <div class="card shadow border-0">
    <div class="card-body">

      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h2 class="mb-0">📅 Calendrier</h2>

        <form method="GET" action="{{ route('calendrier') }}" class="d-flex gap-2 flex-wrap align-items-center">

          <select name="sport_id" class="form-select border-primary shadow-sm w-auto">
            <option value="all">Toutes les disciplines</option>
            @foreach($sports as $sport)
              <option value="{{ $sport->id }}" {{ request('sport_id') == $sport->id ? 'selected' : '' }}>
                {{ $sport->nom }}
              </option>
            @endforeach
          </select>

          <select name="venue_id" class="form-select border-primary shadow-sm w-auto">
            <option value="all">Tous les lieux</option>
            @foreach($venues as $venue)
              <option value="{{ $venue->id }}" {{ request('venue_id') == $venue->id ? 'selected' : '' }}>
                {{ $venue->name }}
              </option>
            @endforeach
          </select>

          <button type="submit" class="btn btn-primary shadow-sm">Filtrer</button>

          @if((request('sport_id') && request('sport_id') !== 'all') || (request('venue_id') && request('venue_id') !== 'all'))
            <a href="{{ route('calendrier') }}" class="btn btn-outline-danger shadow-sm" title="Réinitialiser">✕</a>
          @endif
        </form>
      </div>

      <div class="list-group">
        @if($tours->count() > 0)
          @php $grouped = $tours->groupBy('jour'); @endphp
          @foreach($grouped as $jour => $toursJour)
            <div class="list-group-item mb-2 border rounded">
              <h5 class="text-primary fw-bold mb-3">
                {{ \Carbon\Carbon::parse($jour)->translatedFormat('l d M Y') }}
              </h5>
              @foreach($toursJour as $tour)
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2 ps-2 border-start border-primary">
                  <div>
                    <span class="fw-bold">{{ $tour->sport->nom }}</span>
                    <span class="badge bg-secondary ms-1">{{ $tour->titre }}</span>
                    <span class="text-muted small ms-2">
                      {{ \Carbon\Carbon::parse($tour->heure_debut)->format('H:i') }} – {{ \Carbon\Carbon::parse($tour->heure_fin)->format('H:i') }}
                    </span>
                  </div>
                  <div class="d-flex gap-2 align-items-center">
                    <span class="badge bg-primary rounded-pill">{{ $tour->venue->name }}</span>
                    <span class="badge bg-success">{{ number_format($tour->prix, 2) }} €</span>
                    <a href="{{ route('billetterie') }}" class="btn btn-sm btn-outline-primary">🎫 Réserver</a>
                  </div>
                </div>
              @endforeach
            </div>
          @endforeach
        @else
          <div class="alert alert-secondary text-center mt-3 mb-0">
            Aucune compétition ne correspond à ces critères ou n'est encore programmée.
          </div>
        @endif
      </div>

    </div>
  </div>
</div>

<footer class="bg-dark text-center text-white py-3 mt-5">
  <div class="container">
    <small>© 2026 JO d'Hiver | Projet étudiant | Contact : contact@jo-hiver.fr</small>
  </div>
</footer>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
