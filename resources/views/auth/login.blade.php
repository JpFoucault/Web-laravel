@extends('layouts.loginlayout')

@section('content')
<div class="login-card">
    <div>
        <img src="{{ asset('/assets/FlowDesklogo.png') }}" alt="Logo FlowDesk" class="logo-img">
        <div class="description_login">
            <p>Connectez-vous à votre espace.</p>
            <a href="{{ route('register') }}" class="create_account">Ou créez-en un</a>
        </div>
    </div>

    @if (session('status'))
        <div style="color: #4ade80; font-size: 14px; margin-bottom: 15px;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">Adresse Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Entrez votre email" required autofocus>
            @error('email') 
                <div class="error-text" style="margin-top: 5px; display: block;">{{ $message }}</div> 
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
            @error('password') 
                <div class="error-text" style="margin-top: 5px; display: block;">{{ $message }}</div> 
            @enderror
        </div>

        <div style="text-align: left; margin-bottom: 15px;">
            <label style="color: #94a3b8; font-size: 13px; cursor: pointer;">
                <input type="checkbox" name="remember" style="width: auto; margin-right: 5px;"> Se souvenir de moi
            </label>
        </div>

        <button type="submit" class="btn-login">Se connecter</button>
    </form>

    @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="forgot-password">Mot de passe oublié ?</a>
    @endif
</div>
@endsection