@extends('layouts.loginlayout')

@section('content')
<div class="login-card">
    <div>
        <img src="{{ asset('/assets/FlowDesklogo.png') }}" alt="Logo FlowDesk" class="logo-img">
        <div class="description_login">
            <p>Choisissez un nouveau mot de passe.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group">
            <label for="email">Adresse Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" required readonly style="opacity: 0.7;">
            @error('email') <div class="error-text" style="margin-top: 5px; display: block;">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="password">Nouveau mot de passe</label>
            <input type="password" id="password" name="password" required autofocus>
            @error('password') <div class="error-text" style="margin-top: 5px; display: block;">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn-login">Réinitialiser</button>
    </form>
</div>
@endsection