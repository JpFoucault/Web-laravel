@extends('layouts.loginlayout')

@section('content')
<div class="create_account_card">
    <div>
        <img src="{{ asset('/assets/FlowDesklogo.png') }}" alt="Logo FlowDesk" class="logo-img">
        <div class="description_login">
            <p>Créez votre compte.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name">Nom complet</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Entrez votre nom" required autofocus>
            @error('name') <div class="error-text" style="margin-top: 5px; display: block;">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="email">Adresse Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Entrez votre email" required>
            @error('email') <div class="error-text" style="margin-top: 5px; display: block;">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
            @error('password') <div class="error-text" style="margin-top: 5px; display: block;">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-login">S'inscrire</button>
    </form>

    <div class="already_have_account">
        <a href="{{ route('login') }}" class="link_aha">Déjà enregistré ? Se connecter</a>
    </div>
</div>
@endsection