@extends('layouts.loginlayout')

@section('content')
    <div class="create_account_card">
        <div>
            <img src="{{asset('/assets/FlowDesklogo.png')}}" alt="Logo FlowDesk" class="logo-img">
            <div  class="description_login">
                <p>Création d'un compte FlowDesk.</p>
                <div class="already_have_account">
                    <p>Vous posédez déjà un compte ?</p>
                    <a href="/" class="link_aha">Cliquez-ici</a>
                </div>
            </div>
        </div>

        <form id="create_account_form" action="/dashboard" method="post">

            <div class="form-group">
                <label>Prénom<span class="text-required">*</span></label>
                <input id="account_first_name" type="text" name="prenom">
                <div id="client_first_name_error" class="error-text titanic">Veuillez entrer un prénom valide.</div>
            </div>

            <div class="form-group">
                <label>Nom<span class="text-required">*</span></label>
                <input id="account_family_name" type="text" name="nom">
                <div id="client_family_name_error" class="error-text titanic">Veuillez entrer un nom valide.</div>
            </div>

            <div class="form-group">
                <label>Email professionnel<span class="text-required">*</span></label>
                <input id="account_email" type="email" name="email">
                <div id="client_email_error" class="error-text titanic">Veuillez entrer un email valide.</div>
            </div>

            <div class="form-group">
                <label>Mot de passe provisoire<span class="text-required">*</span></label>
                <input id="account_password" type="password" name="password">             
                <div id="password_error" class="error-text titanic">Veuillez entrer un mot de passe valide.</div>
                <span class="required_password">Requis: 1 Majuscules, 1 Chiffre, Min 7 charactères</span>
            </div>

            <div class="form-group">
                <label>Rôle dans l'application<span class="text-required">*</span></label>
                <select name="role">
                    <option>Collaborateur (Interne)</option>
                    <option>Client (Externe)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Entreprise rattachée<span class="text-required">*</span></label>
                <select id="account_firm" name="firm_id">
                    <option disabled selected>-- Choisir une entreprise --</option>
                    <option>Entreprise A</option>
                    <option>Entreprise B</option>
                </select>
                <div id="firm_error" class="error-text titanic">Sélectionner une entreprise rattaché.</div>
            </div>

            <button type="submit" class="btn-login">Créer l'utilisateur</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/create_account.js') }}"></script>
@endsection
