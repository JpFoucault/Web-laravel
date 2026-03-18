@extends('layouts.loginlayout')

@section('content')
<div class="login-card">
    <div>
        <img src="{{ asset('/assets/FlowDesklogo.png') }}" alt="Logo FlowDesk" class="logo-img">
        <div class="description_forget_password" style="margin-bottom: 25px;">
            <p style="font-size: 14px; line-height: 1.5;">Mot de passe oublié ? Indiquez votre adresse email et nous vous enverrons un lien pour en choisir un nouveau.</p>
        </div>
    </div>

    @if (session('status'))
        <div style="color: #4ade80; font-size: 14px; margin-bottom: 15px; text-align: center;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label for="email">Adresse Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email') <div class="error-text" style="margin-top: 5px; display: block;">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn-login">Envoyer le lien</button>
    </form>

    <a href="{{ route('login') }}" class="forgot-password">Retour à la connexion</a>
</div>
@endsection