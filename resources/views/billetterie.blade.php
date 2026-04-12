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
          <a class="nav-link position-relative text-dark fw-bold active" href="{{ url('/billetterie') }}">
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
      <h2 class="mb-4">🎫 Billetterie</h2>

      <form method="GET" action="{{ url('/billetterie') }}" class="mb-4">
        <div class="row g-3">
          <div class="col-md-4">
            <label for="prix_min" class="form-label">Prix minimum</label>
            <input type="number" step="0.01" name="prix_min" id="prix_min" class="form-control" value="{{ request('prix_min') }}">
          </div>
          <div class="col-md-4">
            <label for="prix_max" class="form-label">Prix maximum</label>
            <input type="number" step="0.01" name="prix_max" id="prix_max" class="form-control" value="{{ request('prix_max') }}">
          </div>
          <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Filtrer</button>
            <a href="{{ url('/billetterie') }}" class="btn btn-outline-secondary">Réinitialiser</a>
          </div>
        </div>
      </form>

      <form id="reservationForm" method="POST" action="{{ url('/reservation') }}">
        @csrf
        <div class="row">
          <div class="col-md-8">
            <h4>Disciplines disponibles</h4>
            @foreach($disciplines as $discipline)
            <div class="card mb-3">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h5 class="card-title">{{ $discipline->nom }} - {{ $discipline->titre }}</h5>
                    <p class="card-text">{{ $discipline->lieu }} - {{ \Carbon\Carbon::parse($discipline->jour)->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($discipline->heure_debut)->format('H:i') }}</p>
                    <p class="text-primary fw-bold">{{ $discipline->prix }} €</p>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input competition-checkbox" type="checkbox" name="competitions[{{ $discipline->id }}][selected]" value="1" id="comp_{{ $discipline->id }}">
                    <label class="form-check-label" for="comp_{{ $discipline->id }}">
                      Sélectionner
                    </label>
                  </div>
                </div>
                <div class="quantity-input mt-2" style="display: none;">
                  <label>Quantité:</label>
                  <input type="number" name="competitions[{{ $discipline->id }}][quantity]" min="1" value="1" class="form-control d-inline-block w-auto">
                  <input type="hidden" name="competitions[{{ $discipline->id }}][id]" value="{{ $discipline->id }}">
                </div>
              </div>
            </div>
            @endforeach
          </div>

          <div class="col-md-4">
            <h4>Informations de réservation</h4>
            <div class="mb-3">
              <label for="first_name" class="form-label">Prénom</label>
              <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="mb-3">
              <label for="last_name" class="form-label">Nom</label>
              <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label">Téléphone</label>
              <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>

            <div id="peopleSection" style="display: none;">
              <h5>Noms des personnes</h5>
              <div id="peopleInputs">
                <div class="mb-2">
                  <input type="text" class="form-control" name="people[]" placeholder="Nom de la personne 1" required>
                </div>
              </div>
              <button type="button" id="addPerson" class="btn btn-sm btn-outline-primary">Ajouter une personne</button>
            </div>

            <button type="submit" class="btn btn-success w-100 mt-3" id="submitBtn" style="display: none;">Réserver</button>
          </div>
        </div>
      </form>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.competition-checkbox');
    const submitBtn = document.getElementById('submitBtn');
    const peopleSection = document.getElementById('peopleSection');
    const addPersonBtn = document.getElementById('addPerson');
    const peopleInputs = document.getElementById('peopleInputs');
    const reservationForm = document.getElementById('reservationForm');

    function updateForm() {
        const checkedBoxes = document.querySelectorAll('.competition-checkbox:checked');
        const isAnyChecked = checkedBoxes.length > 0;

        submitBtn.style.display = isAnyChecked ? 'block' : 'none';
        peopleSection.style.display = isAnyChecked ? 'block' : 'none';

        // Update people inputs count based on total quantity
        let totalQuantity = 0;
        checkedBoxes.forEach(cb => {
            const quantityInput = cb.closest('.card-body').querySelector('input[name*="[quantity]"]');
            if (quantityInput) {
                totalQuantity += parseInt(quantityInput.value) || 0;
            }
        });

        // Adjust people inputs
        const currentInputs = peopleInputs.querySelectorAll('input[name="people[]"]');
        if (totalQuantity > currentInputs.length) {
            for (let i = currentInputs.length; i < totalQuantity; i++) {
                const div = document.createElement('div');
                div.className = 'mb-2';
                div.innerHTML = '<input type="text" class="form-control" name="people[]" placeholder="Nom de la personne ' + (i + 1) + '" required>';
                peopleInputs.appendChild(div);
            }
        } else if (totalQuantity < currentInputs.length) {
            for (let i = currentInputs.length - 1; i >= totalQuantity; i--) {
                currentInputs[i].parentElement.remove();
            }
        }
    }

    // Handle form submission to clean up data structure
    reservationForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Build clean competitions array
        const competitionsData = [];
        const checkedBoxes = document.querySelectorAll('.competition-checkbox:checked');
        
        checkedBoxes.forEach(cb => {
            const disciplineId = cb.id.replace('comp_', '');
            const quantityInput = cb.closest('.card-body').querySelector('input[name*="[quantity]"]');
            const quantity = parseInt(quantityInput.value) || 1;

            competitionsData.push({
                id: disciplineId,
                quantity: quantity
            });
        });

        // Validate
        if (competitionsData.length === 0) {
            alert('Veuillez sélectionner au moins une compétition');
            return;
        }

        // Create FormData
        const formData = new FormData();
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        formData.append('first_name', document.getElementById('first_name').value);
        formData.append('last_name', document.getElementById('last_name').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('phone', document.getElementById('phone').value);

        // Add competitions
        competitionsData.forEach((comp, index) => {
            formData.append(`competitions[${index}][id]`, comp.id);
            formData.append(`competitions[${index}][quantity]`, comp.quantity);
        });

        // Add people
        const peopleInputs = document.querySelectorAll('input[name="people[]"]');
        peopleInputs.forEach((input, index) => {
            formData.append(`people[${index}]`, input.value);
        });

        // Submit
        fetch('{{ url('/reservation') }}', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                return response.text();
            }
            throw new Error('Erreur lors de la réservation');
        })
        .then(html => {
            document.body.innerHTML = html;
        })
        .catch(error => {
            alert('Erreur: ' + error.message);
        });
    });

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            const quantityDiv = this.closest('.card-body').querySelector('.quantity-input');
            if (this.checked) {
                quantityDiv.style.display = 'block';
            } else {
                quantityDiv.style.display = 'none';
            }
            updateForm();
        });

        const quantityInput = cb.closest('.card-body').querySelector('input[name*="[quantity]"]');
        if (quantityInput) {
            quantityInput.addEventListener('input', updateForm);
        }
    });

    addPersonBtn.addEventListener('click', function() {
        const inputs = peopleInputs.querySelectorAll('input[name="people[]"]');
        const div = document.createElement('div');
        div.className = 'mb-2';
        div.innerHTML = '<input type="text" class="form-control" name="people[]" placeholder="Nom de la personne ' + (inputs.length + 1) + '" required>';
        peopleInputs.appendChild(div);
    });
});
</script>

</body>
</html>