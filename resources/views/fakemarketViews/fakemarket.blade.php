@extends('template')

@section('content')

<div class="p-5 mb-4 bg-primary text-white rounded">
    <h1 class="text-center">FakeMarché</h1>
</div>

<div class="card p-4">
    <h4>Coordonnées pour la livraison :</h4>

    <form method="POST" action="/recap">
        @csrf

        <div class="mb-3">
            <label>Prénom</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Téléphone</label>
            <input type="text" name="telephone" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Valider</button>
    </form>
</div>

@endsection