@include('pages.user.partials.head')


<body>

    @include('pages.user.partials.header', ['active' => 'settings'])

    <div class="content_create">

        <div class="form-card">

            <div class="profile-header-section">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <h1 style="margin: 0; font-size: 22px; color: #f8fafc;">{{ auth()->user()->name }}</h1>
                <p style="color: #94a3b8; margin: 5px 0; font-size: 14px;">{{ auth()->user()->email }}</p>
            </div>

            <form action="#">

                <span class="section-title">Informations Personnelles</span>

                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                </div>

                <div class="form-group">
                    <label>Adresse Email</label>
                    <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                </div>

                <span class="section-title">Préférences</span>

                <div class="toggle-row">
                    <span class="toggle-label">Notifications email</span>
                    <label class="switch">
                        <input type="checkbox" checked> <span class="slider"></span>
                    </label>
                </div>

                <div class="toggle-row" style="border-bottom: none;">
                    <span class="toggle-label">Rapport hebdomadaire</span>
                    <label class="switch">
                        <input type="checkbox"> <span class="slider"></span>
                    </label>
                </div>

                <span class="section-title">Gestion du profil</span>

                <div class="form-group">
                    <a href="{{ route('profile.edit') }}" class="btn-password" style="display: block; text-decoration: none;">
                        Modifier mes informations (Nom, Email, Mot de passe)
                    </a>
                </div>

            </form>

            <span class="section-title">Déconnexion</span>

            <div class="form-group">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout" style="width: 100%;">Se déconnecter</button>
                </form>
            </div>

        </div>
    </div>
</body>
</html>
