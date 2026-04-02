@extends('template')

@section('content')

<div class="alert alert-success">
    <h4>Récapitulatif</h4>

    <p>
        Vous avez indiqué comme adresse de livraison :
    </p>

    <ul>
        <li><strong>Prénom :</strong> {{ $prenom }}</li>
        <li><strong>Nom :</strong> {{ $nom }}</li>
        <li><strong>Téléphone :</strong> {{ $telephone }}</li>
    </ul>
</div>

@endsection