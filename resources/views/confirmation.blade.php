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
    <div class="bg-white rounded-circle d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
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
            <span class="bg-circle position-absolute"></span>
            Accueil
          </a>
        </li>
        <li class="nav-item position-relative">
          <a class="nav-link position-relative text-dark fw-bold" href="{{ url('/calendrier') }}">
            <span class="bg-circle position-absolute"></span>
            Calendrier
          </a>
        </li>
        <li class="nav-item position-relative">
          <a class="nav-link position-relative text-dark fw-bold" href="{{ url('/billetterie') }}">
            <span class="bg-circle position-absolute"></span>
            Billetterie
          </a>
        </li>
        <li class="nav-item position-relative">
          <a class="nav-link position-relative text-dark fw-bold" href="{{ route('organizer.login') }}">
            <span class="bg-circle position-absolute"></span>
            Organisateurs
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <div class="card shadow border-0">
    <div class="card-body">
      <h2 class="mb-4 text-success">✅ Confirmation de réservation</h2>

      <div class="alert alert-success">
        <h4 class="alert-heading">Réservation confirmée !</h4>
        <p>Votre réservation a été enregistrée avec succès. Un email de confirmation vous sera envoyé sous peu.</p>
      </div>

      <h4>Récapitulatif</h4>
      <div class="row">
        <div class="col-md-6">
          <h5>Informations personnelles</h5>
          <p><strong>Nom :</strong> {{ $reservation->first_name }} {{ $reservation->last_name }}</p>
          <p><strong>Email :</strong> {{ $reservation->email }}</p>
          <p><strong>Téléphone :</strong> {{ $reservation->phone }}</p>
        </div>
        <div class="col-md-6">
          <h5>Compétitions réservées</h5>
          @foreach($reservation->competitions as $comp)
            @php
              $discipline = \App\Models\Discipline::find($comp['id']);
            @endphp
            <p>{{ $discipline->nom }} - {{ $discipline->titre }} ({{ $comp['quantity'] }} billet(s) - {{ $comp['price'] }} € chacun)</p>
          @endforeach
          <h5>Personnes</h5>
          <ul>
            @foreach($reservation->people as $person)
              <li>{{ $person }}</li>
            @endforeach
          </ul>
          <p class="text-primary fw-bold">Prix total : {{ $reservation->total_price }} €</p>
        </div>
      </div>

      <div class="mt-4">
        <a href="{{ url('/') }}" class="btn btn-primary">Retour à l'accueil</a>
        <a href="{{ url('/billetterie') }}" class="btn btn-secondary">Nouvelle réservation</a>
      </div>
    </div>
  </div>
</div>

<footer class="bg-dark text-center text-white py-3 mt-5">
    <div class="container">
        <small>
            © 2026 JO d'Hiver | Projet étudiant | Contact : contact@jo-hiver.fr
        </small>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>