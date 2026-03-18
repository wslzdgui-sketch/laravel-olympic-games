@extends('template')

@section('content')
    <h1>Liste des utilisateurs</h1>

    <div class="mb-3">
        <a href="/" class="btn btn-secondary">Accueil</a>
    </div>

    @if($users->isEmpty())
        <div class="alert alert-info">Aucun utilisateur trouvé.</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Créé le</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <hr class="my-5">

    <h2>Formulaire de contact</h2>

    <form method="POST" action="/recap" class="needs-validation">
        @csrf
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" required>
        </div>

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>

        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input type="tel" class="form-control" id="telephone" name="telephone" required>
        </div>

        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
@endsection
