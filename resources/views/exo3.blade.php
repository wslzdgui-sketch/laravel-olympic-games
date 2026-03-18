@extends('template')

@section('content')
<h1>Liste des contacts sur la table users</h1>

@if($users->isEmpty())
    <div class="alert alert-info">Aucun utilisateur trouvé.</div>
@else
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $ligne)
                <tr>
                    <td>{{ $ligne->id }}</td>
                    <td>{{ $ligne->name }}</td>
                    <td>{{ $ligne->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<a href="/" class="btn btn-secondary mt-3">Accueil</a>

@endsection
