<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JO d'Hiver | Confirmation de réservation</title>
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
          <a class="nav-link position-relative text-dark fw-bold" href="{{ route('calendrier') }}">
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

<div class="container mt-5">
  <div class="card shadow border-0">
    <div class="card-body">

      <div class="text-center mb-4">
        <div style="font-size:3rem">✅</div>
        <h2 class="text-success">Réservation confirmée !</h2>
        <p class="text-muted">Référence : <strong>#{{ $reservation->id }}</strong></p>
      </div>

      <div class="row">
        {{-- Informations acheteur --}}
        <div class="col-md-6 mb-4">
          <div class="card border-0 bg-light">
            <div class="card-body">
              <h5 class="card-title">👤 Informations acheteur</h5>
              <table class="table table-sm table-borderless mb-0">
                <tr><th>Nom</th><td>{{ $reservation->first_name }} {{ $reservation->last_name }}</td></tr>
                <tr><th>Email</th><td>{{ $reservation->email }}</td></tr>
                <tr><th>Téléphone</th><td>{{ $reservation->phone }}</td></tr>
                <tr><th>Date de réservation</th><td>{{ $reservation->created_at->format('d/m/Y à H:i') }}</td></tr>
              </table>
            </div>
          </div>
        </div>

        {{-- Compétitions réservées --}}
        <div class="col-md-6 mb-4">
          <div class="card border-0 bg-light">
            <div class="card-body">
              <h5 class="card-title">🏅 Compétitions</h5>
              @foreach($toursData as $item)
                <div class="mb-2 pb-2 border-bottom">
                  <div class="fw-bold">{{ $item['tour']->sport->nom }} – {{ $item['tour']->titre }}</div>
                  <div class="text-muted small">
                    📅 {{ \Carbon\Carbon::parse($item['tour']->jour)->format('d/m/Y') }}
                    {{ \Carbon\Carbon::parse($item['tour']->heure_debut)->format('H:i') }}
                    – {{ \Carbon\Carbon::parse($item['tour']->heure_fin)->format('H:i') }}<br>
                    📍 {{ $item['tour']->venue->name }}
                  </div>
                  <div class="small">
                    {{ $item['quantity'] }} billet(s) × {{ number_format($item['price'], 2) }} €
                    = <strong>{{ number_format($item['price'] * $item['quantity'], 2) }} €</strong>
                  </div>
                </div>
              @endforeach
              <div class="text-end mt-2">
                <span class="fs-5 fw-bold text-success">Total : {{ number_format($reservation->total_price, 2) }} €</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Spectateurs --}}
      <div class="card border-0 bg-light mb-4">
        <div class="card-body">
          <h5 class="card-title">👥 Spectateurs</h5>
          <div class="row">
            @foreach($reservation->spectators as $i => $spec)
              <div class="col-md-3 col-sm-6 mb-2">
                <div class="badge bg-primary w-100 text-start py-2 px-3">
                  {{ $spec->first_name }} {{ $spec->last_name }}
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="d-flex gap-3 justify-content-center">
        <a href="{{ url('/') }}" class="btn btn-primary">🏠 Retour à l'accueil</a>
        <a href="{{ route('billetterie') }}" class="btn btn-outline-secondary">🎫 Nouvelle réservation</a>
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
