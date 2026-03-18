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
@endsection
