@extends('layouts.loginlayout')

@section('content')
    <div class="login-card">
        <div>
            <img src="{{asset('/assets/FlowDesklogo.png')}}" alt="Logo FlowDesk" class="logo-img">
            <div  class="description_forget_password">
                <p>Mots de passe oublié.</p>
                <div class="already_have_account">
                    <p>Revenir en arrière ?</p>
                    <a href="/" class="link_aha">Cliquez-ici</a>
                </div>
            </div>
        </div>

        <form id="forget_password_form" action="/confirm" method="GET">
            <div class="form-group">
                <label for="email_input">Adresse E-Mail<span class="text-required">*</span></label>
                <input id="email_input" type="email" name="username" placeholder="Entrez votre E-Mail">
                
                <div id="email_error" class="error-text titanic">Veuillez entrer un email valide.</div>
            </div>

            <button type="submit" class="btn-login">Continue</button>
        </form>

        <a href="#" class="forgot-password">Autres techniques ?</a>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/forget_password.js') }}"></script>
@endsection