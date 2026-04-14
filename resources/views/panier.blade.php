{{-- Vue panier simple — le panier est géré en JS côté billetterie. --}}
{{-- Cette route existe pour une éventuelle extension future. --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JO d'Hiver | Panier</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/acceuil.css') }}">
</head>
<body>
<div class="container mt-5">
  <div class="alert alert-info text-center">
    Le panier est intégré directement dans la page
    <a href="{{ route('billetterie') }}" class="alert-link">Billetterie</a>.
    Sélectionnez vos compétitions pour voir le panier apparaître.
  </div>
</div>
</body>
</html>
