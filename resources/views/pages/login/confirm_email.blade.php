@extends('layouts.loginlayout')

@section('content')
    <div class="login-card">
        <div>
            <img src="{{asset('/assets/FlowDesklogo.png')}}" alt="Logo FlowDesk" class="logo-img">
            <div  class="description_forget_password">
                <p>Mots de passe oublié.</p>
            </div>
        </div>

        <form action="/dashboard" method="GET">
            <div class="form-group">
                <label id="code">Code recu par email</label>
                <input type="number" name="code" placeholder="Entrez le code recu par email" required>
            </div>

            <button type="submit" class="btn-login">Continue</button>
        </form>

        <a href="#" class="forgot-password">Autres techniques ?</a>
    </div>
@endsection