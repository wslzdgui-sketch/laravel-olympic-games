<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JO d'Hiver | Accueil</title>

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
          <a class="nav-link position-relative text-dark fw-bold active" data-bs-toggle="tab" href="#calendrier">
            <span class="bg-circle position-absolute"></span>
            Calendrier
          </a>
        </li>
        <li class="nav-item position-relative">
          <a class="nav-link position-relative text-dark fw-bold" data-bs-toggle="tab" href="#billetterie">
            <span class="bg-circle position-absolute"></span>
            Billetterie
          </a>
        </li>
        <li class="nav-item position-relative">
          <a class="nav-link position-relative text-dark fw-bold" data-bs-toggle="tab" href="#organisateurs">
            <span class="bg-circle position-absolute"></span>
            Organisateurs
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5 flex-grow-1">
  <div class="tab-content">

    <div class="tab-pane fade show active" id="calendrier">
      <div class="card shadow border-0">
        <div class="card-body">
          
          <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
              <h2 class="mb-0">📅 Calendrier</h2>
              
              <form method="GET" action="{{ url('/') }}" class="d-flex gap-2 flex-wrap align-items-center">
                  
                  <select name="sport" class="form-select border-primary shadow-sm w-auto">
                      <option value="all">Toutes les disciplines</option>
                      @if(isset($sports))
                          @foreach($sports as $sport)
                              <option value="{{ $sport }}" {{ request('sport') == $sport ? 'selected' : '' }}>
                                  {{ $sport }}
                              </option>
                          @endforeach
                      @endif
                  </select>

                  <select name="lieu" class="form-select border-primary shadow-sm w-auto">
                      <option value="all">Tous les lieux</option>
                      @if(isset($lieux))
                          @foreach($lieux as $lieu)
                              <option value="{{ $lieu }}" {{ request('lieu') == $lieu ? 'selected' : '' }}>
                                  {{ $lieu }}
                              </option>
                          @endforeach
                      @endif
                  </select>

                  <button type="submit" class="btn btn-primary shadow-sm">Filtrer</button>
                  
                  @if((request('sport') && request('sport') !== 'all') || (request('lieu') && request('lieu') !== 'all'))
                      <a href="{{ url('/') }}" class="btn btn-outline-danger shadow-sm" title="Réinitialiser les filtres">X</a>
                  @endif
              </form>
          </div>

          <div class="list-group">
            @if(isset($competitions) && $competitions->count() > 0)
                @foreach($competitions as $comp)
                <div class="list-group-item">
                  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h6 class="mb-0 text-primary fw-bold">
                            {{ \Carbon\Carbon::parse($comp->jour)->translatedFormat('d M Y') }} - 
                            {{ \Carbon\Carbon::parse($comp->heure_debut)->format('H:i') }}
                        </h6>
                        <span class="fs-5">{{ $comp->nom }} - {{ $comp->titre }}</span>
                    </div>
                    <span class="badge bg-primary rounded-pill fs-6">{{ $comp->lieu }}</span>
                  </div>
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

    <div class="tab-pane fade" id="billetterie">
      <div class="card shadow border-0">
        <div class="card-body">
          <h2>🎫 Billetterie</h2>
          <div class="alert alert-info mt-3">En construction</div>
        </div>
      </div>
    </div>

    <div class="tab-pane fade" id="organisateurs">
      <div class="card shadow border-0">
        <div class="card-body">
          <h2>⚙️ Organisateurs</h2>
          <div class="alert alert-warning mt-3">Accès restreint</div>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="container mt-5">
  <div class="row g-4 justify-content-center">

    <div class="col-auto">
      <div class="card h-100 shadow-sm" style="width: 180px;">
        <img src="https://images.unsplash.com/photo-1533743048612-bf990dafe257?q=80&w=1160&auto=format&fit=crop" 
             class="card-img-top" style="height: 100px; object-fit: cover;" alt="Image 1">
        <div class="card-body text-center">
          <h5 class="card-title fs-6 fw-bold">Des voyages remplis de libertés</h5>
          <p class="card-text small text-muted">Découvrez des lieux uniques et vivez des expériences inoubliables au cœur des Jeux Olympiques 2026</p>
        </div>
      </div>
    </div>

    <div class="col-auto">
      <div class="card h-100 shadow-sm" style="width: 180px;">
        <img src="https://images.unsplash.com/photo-1549896869-ca27eeffe4fb?q=80&w=774&auto=format&fit=crop" 
             class="card-img-top" style="height: 100px; object-fit: cover;" alt="Image 2">
        <div class="card-body text-center">
          <h5 class="card-title fs-6 fw-bold">De nouveaux terrains à découvrir</h5>
          <p class="card-text small text-muted">Découvrez des endroits que seuls les courageux osent fouler, où chaque descente devient un souvenir gravé à jamais.</p>
        </div>
      </div>
    </div>

    <div class="col-auto">
      <div class="card h-100 shadow-sm" style="width: 180px;">
        <img src="https://images.unsplash.com/photo-1639843091936-bb5fca7b5684?q=80&w=1160&auto=format&fit=crop" 
             class="card-img-top" style="height: 100px; object-fit: cover;" alt="Image 3">
        <div class="card-body text-center">
          <h5 class="card-title fs-6 fw-bold">Dépassez vos limites</h5>
          <p class="card-text small text-muted">Sentez votre cœur s’emballer, vos muscles vibrer, et chaque action vous rapprocher de repousser vos limites</p>
        </div>
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

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>