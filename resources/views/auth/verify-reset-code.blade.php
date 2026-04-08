@extends('layouts.loginlayout')

@section('content')
<div class="login-card">
    <div>
        <img src="{{ asset('/assets/FlowDesklogo.png') }}" alt="Logo FlowDesk" class="logo-img">
        <div class="description_forget_password" style="margin-bottom: 25px;">
            <p style="font-size: 14px; line-height: 1.5;">
                Un code de vérification a été généré. Entrez-le ci-dessous pour continuer.
            </p>
            <p style="font-size: 13px; color: #94a3b8;">
                Code de démonstration : <strong style="color: #e2e8f0;">2222</strong>
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('password.submit-code') }}">
        @csrf

        <div class="form-group">
            <label for="code">Code de vérification</label>
            <input type="text" id="code" name="code" placeholder="Entrez le code" required autofocus maxlength="10">
            @error('code')
                <div class="error-text" style="margin-top: 5px; display: block;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-login">Vérifier le code</button>
    </form>

    <a href="{{ route('password.request') }}" class="forgot-password">Retour</a>
</div>
@endsection
