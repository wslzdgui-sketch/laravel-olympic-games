<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JO d'Hiver | Connexion Organisateurs</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/acceuil.css') }}">
    <link rel="icon" href="{{ asset('picture/logojo.png') }}" type="image/png">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-box">
        <div class="text-center mb-4">
            <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center mx-auto" style="width: 80px; height: 80px;">
                <img src="{{ asset('picture/logojo.png') }}" alt="Logo JO" width="50" height="50">
            </div>
            <h2 class="mt-3">JO d'Hiver</h2>
            <p class="text-muted">Espace Organisateurs</p>
        </div>

        <form method="POST" action="{{ route('organizer.login.post') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Connexion</button>
        </form>

        <div class="alert alert-info mt-3 small">
            <strong>Identifiants de test:</strong><br>
            Email: admin@jeux-olympiques.fr<br>
            Mot de passe: password123
        </div>

        <hr>
        <p class="text-center text-muted small">
            <a href="{{ url('/') }}" class="text-decoration-none">Retour à l'accueil</a>
        </p>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>