@extends('layouts.loginlayout')


@section('content')
<div class="login-card">
    <div>
        <img src="{{ asset('/assets/FlowDesklogo.png') }}" alt="Logo FlowDesk" class="logo-img">
        <div class="description_login">
            <p>Connectez-vous à votre espace.</p>
            <a href="/create" class="create_account"> Ou Crée en un</a>
        </div>
    </div>

    <form id="login_form" action="/dashboard" method="GET">
        <div class="form-group">
            <label for="username">Identifiant</label>
            <input type="email" id="username" placeholder="Entrez votre identifiant">
            <div id="username_error" class="error-text titanic">Veuillez entrer un identifiant valide.</div>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" placeholder="••••••••">
            <div id="password_error" class="error-text titanic">Veuillez entrer votre mot de passe.</div>
        </div>

        <button type="submit" class="btn-login">Se connecter</button>
    </form>

    <a href="/forget" class="forgot-password">Mot de passe oublié ?</a>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/login.js') }}"></script>
@endsection