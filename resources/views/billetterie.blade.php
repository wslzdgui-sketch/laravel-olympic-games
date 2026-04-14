<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JO d'Hiver | Billetterie</title>
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
          <a class="nav-link position-relative text-dark fw-bold active" href="{{ route('billetterie') }}">
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

  @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- Filtre prix --}}
  <div class="card shadow border-0 mb-4">
    <div class="card-body">
      <h5 class="mb-3">🔍 Filtrer par prix</h5>
      <form method="GET" action="{{ route('billetterie') }}" class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Prix minimum (€)</label>
          <input type="number" step="0.01" name="prix_min" class="form-control" value="{{ request('prix_min') }}" placeholder="0">
        </div>
        <div class="col-md-4">
          <label class="form-label">Prix maximum (€)</label>
          <input type="number" step="0.01" name="prix_max" class="form-control" value="{{ request('prix_max') }}" placeholder="200">
        </div>
        <div class="col-md-4 d-flex align-items-end gap-2">
          <button type="submit" class="btn btn-primary">Filtrer</button>
          <a href="{{ route('billetterie') }}" class="btn btn-outline-secondary">Réinitialiser</a>
        </div>
      </form>
    </div>
  </div>

  <div class="row">
    {{-- Liste des tours disponibles --}}
    <div class="col-lg-8">
      <div class="card shadow border-0">
        <div class="card-body">
          <h4 class="mb-4">🏅 Compétitions disponibles</h4>

          @if($tours->count() > 0)
            @foreach($tours->groupBy(fn($t) => $t->sport->nom) as $sportNom => $toursSport)
              <h6 class="text-primary fw-bold mt-3 mb-2 border-bottom pb-1">{{ $sportNom }}</h6>
              @foreach($toursSport as $tour)
                @php $dispo = $placesDisponibles[$tour->id] ?? 0; @endphp
                <div class="card mb-2 {{ $dispo == 0 ? 'border-danger opacity-75' : 'border-light' }}" id="tour-card-{{ $tour->id }}">
                  <div class="card-body py-2">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                      <div>
                        <span class="fw-bold">{{ $tour->titre }}</span>
                        <span class="text-muted small ms-2">
                          {{ \Carbon\Carbon::parse($tour->jour)->format('d/m/Y') }}
                          {{ \Carbon\Carbon::parse($tour->heure_debut)->format('H:i') }} – {{ \Carbon\Carbon::parse($tour->heure_fin)->format('H:i') }}
                        </span>
                        <br>
                        <span class="text-muted small">📍 {{ $tour->venue->name }}</span>
                        @if($dispo > 0)
                          <span class="badge bg-light text-muted small ms-2">{{ $dispo }} place(s) restante(s)</span>
                        @else
                          <span class="badge bg-danger ms-2">COMPLET</span>
                        @endif
                      </div>
                      <div class="d-flex align-items-center gap-2">
                        <span class="text-primary fw-bold">{{ number_format($tour->prix, 2) }} €</span>
                        @if($dispo > 0)
                          <div class="form-check mb-0">
                            <input class="form-check-input tour-checkbox"
                                   type="checkbox"
                                   id="tour_{{ $tour->id }}"
                                   data-tour-id="{{ $tour->id }}"
                                   data-prix="{{ $tour->prix }}"
                                   data-nom="{{ $tour->sport->nom }} – {{ $tour->titre }}">
                            <label class="form-check-label" for="tour_{{ $tour->id }}">Sélectionner</label>
                          </div>
                          <input type="number"
                                 class="form-control form-control-sm qty-input"
                                 id="qty_{{ $tour->id }}"
                                 style="width:70px;display:none"
                                 min="1"
                                 max="{{ $dispo }}"
                                 value="1"
                                 data-tour-id="{{ $tour->id }}">
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            @endforeach
          @else
            <div class="alert alert-secondary">Aucune compétition disponible pour ces critères.</div>
          @endif
        </div>
      </div>
    </div>

    {{-- Panier + formulaire --}}
    <div class="col-lg-4 mt-4 mt-lg-0">

      {{-- Panier --}}
      <div class="card shadow border-0 mb-4" id="panier-card" style="display:none!important">
        <div class="card-body">
          <h5>🛒 Panier</h5>
          <div id="panier-items"></div>
          <hr>
          <div class="d-flex justify-content-between fw-bold">
            <span>Total :</span>
            <span id="panier-total">0,00 €</span>
          </div>
        </div>
      </div>

      {{-- Formulaire de réservation --}}
      <div class="card shadow border-0" id="form-card" style="display:none!important">
        <div class="card-body">
          <h5 class="mb-3">📋 Vos informations</h5>
          <form id="reservationForm" method="POST" action="{{ route('reservation.store') }}">
            @csrf

            <div class="mb-2">
              <label class="form-label">Prénom <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
            </div>
            <div class="mb-2">
              <label class="form-label">Nom <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
            </div>
            <div class="mb-2">
              <label class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Téléphone <span class="text-danger">*</span></label>
              <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}" required>
            </div>

            {{-- Noms des spectateurs (injectés via JS) --}}
            <div id="spectators-section" style="display:none">
              <h6 class="mt-3 mb-2">👥 Noms des spectateurs</h6>
              <div id="spectators-inputs"></div>
            </div>

            {{-- Champs cachés competitions injectés via JS --}}
            <div id="competitions-inputs"></div>

            <button type="submit" class="btn btn-success w-100 mt-3" id="submit-btn">
              ✅ Confirmer la réservation
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<footer class="bg-dark text-center text-white py-3 mt-5">
  <div class="container">
    <small>© 2026 JO d'Hiver | Projet étudiant | Contact : contact@jo-hiver.fr</small>
  </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
// ── Panier en mémoire ──────────────────────────────────────────────────────────
const panier = {}; // { tourId: { nom, prix, qty } }

function updatePanier() {
    const panierCard = document.getElementById('panier-card');
    const formCard   = document.getElementById('form-card');
    const panierItems = document.getElementById('panier-items');
    const panierTotal = document.getElementById('panier-total');
    const specSection = document.getElementById('spectators-section');
    const specInputs  = document.getElementById('spectators-inputs');
    const compInputs  = document.getElementById('competitions-inputs');

    const items = Object.values(panier);

    if (items.length === 0) {
        panierCard.style.setProperty('display', 'none', 'important');
        formCard.style.setProperty('display', 'none', 'important');
        return;
    }

    // Afficher panier et formulaire
    panierCard.style.removeProperty('display');
    formCard.style.removeProperty('display');

    // Total quantité de billets
    const totalQty = items.reduce((s, i) => s + i.qty, 0);

    // Rendre les items du panier
    panierItems.innerHTML = items.map(item => `
        <div class="d-flex justify-content-between align-items-center mb-1 small">
            <span>${item.nom}</span>
            <span class="text-muted">${item.qty} × ${parseFloat(item.prix).toFixed(2)} €</span>
        </div>
    `).join('');

    // Total
    const total = items.reduce((s, i) => s + i.prix * i.qty, 0);
    panierTotal.textContent = total.toFixed(2).replace('.', ',') + ' €';

    // Champs cachés competitions[]
    compInputs.innerHTML = '';
    let idx = 0;
    Object.entries(panier).forEach(([tourId, item]) => {
        compInputs.innerHTML += `
            <input type="hidden" name="competitions[${idx}][tour_id]" value="${tourId}">
            <input type="hidden" name="competitions[${idx}][quantity]" value="${item.qty}">
        `;
        idx++;
    });

    // Champs spectateurs
    specSection.style.display = 'block';
    const currentInputs = specInputs.querySelectorAll('.spectator-row');
    const currentCount  = currentInputs.length;

    if (totalQty > currentCount) {
        for (let i = currentCount; i < totalQty; i++) {
            const div = document.createElement('div');
            div.className = 'row g-1 mb-2 spectator-row';
            div.innerHTML = `
                <div class="col-6">
                    <input type="text" class="form-control form-control-sm"
                           name="spectators[${i}][first_name]"
                           placeholder="Prénom ${i+1}" required>
                </div>
                <div class="col-6">
                    <input type="text" class="form-control form-control-sm"
                           name="spectators[${i}][last_name]"
                           placeholder="Nom ${i+1}" required>
                </div>
            `;
            specInputs.appendChild(div);
        }
    } else if (totalQty < currentCount) {
        for (let i = currentCount - 1; i >= totalQty; i--) {
            currentInputs[i].remove();
        }
    }

    // Re-indexer les noms des champs spectateurs après suppression
    specInputs.querySelectorAll('.spectator-row').forEach((row, i) => {
        row.querySelectorAll('input').forEach(inp => {
            inp.name = inp.name.replace(/spectators\[\d+\]/, `spectators[${i}]`);
            inp.placeholder = inp.placeholder.replace(/\d+$/, i + 1);
        });
    });
}

// ── Événements checkboxes ──────────────────────────────────────────────────────
document.querySelectorAll('.tour-checkbox').forEach(cb => {
    cb.addEventListener('change', function () {
        const tourId = this.dataset.tourId;
        const qtyEl  = document.getElementById(`qty_${tourId}`);

        if (this.checked) {
            qtyEl.style.display = 'inline-block';
            panier[tourId] = {
                nom:  this.dataset.nom,
                prix: parseFloat(this.dataset.prix),
                qty:  parseInt(qtyEl.value) || 1,
            };
        } else {
            qtyEl.style.display = 'none';
            delete panier[tourId];
        }
        updatePanier();
    });
});

// ── Événements quantités ───────────────────────────────────────────────────────
document.querySelectorAll('.qty-input').forEach(inp => {
    inp.addEventListener('input', function () {
        const tourId = this.dataset.tourId;
        if (panier[tourId]) {
            panier[tourId].qty = Math.max(1, parseInt(this.value) || 1);
            updatePanier();
        }
    });
});
</script>
</body>
</html>
