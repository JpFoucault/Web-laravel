<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mon Projet Laravel</title>
</head>
<body style="font-family: sans-serif; text-align: center; margin-top: 50px;">
    <h1>Bienvenue sur mon projet !</h1>

    @if (Route::has('login'))
        <div>
            @auth
                <a href="{{ url('/dashboard') }}">Aller au Dashboard</a>
            @else
                <a href="{{ route('login') }}">Se connecter</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" style="margin-left: 15px;">S'inscrire</a>
                @endif
            @endauth
        </div>
    @endif
</body>
</html>