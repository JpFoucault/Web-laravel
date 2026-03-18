@include('pages.user.partials.head')


<body>
    @include('pages.user.partials.header', ['active' => 'project'])

    <div class="content">
        <div class="page-actions">
            <h1>Liste des Projets</h1>
            <a href="{{ url('create_new_project') }}" class="btn-create">+ Nouveau Projet</a>
        </div>

        <div class="projects-grid">

            <article class="project-card">
                <div class="card-header">
                    <h2>Site E-Commerce Bio</h2>
                    <span class="client-name">Client : GreenMarket SAS</span>
                </div>

                <div class="tickets-section">
                    <h3>Tickets Récents</h3>
                    <ul class="ticket-list">
                        <li class="ticket-item">
                            <span>Bug ajout panier</span>
                            <span class="status-badge status-new">Nouveau</span>
                        </li>
                        <li class="ticket-item">
                            <span>Intégration Stripe</span>
                            <span class="status-badge status-progress">En cours</span>
                        </li>
                        <li class="ticket-item">
                            <span>Mise en prod v1.0</span>
                            <span class="status-badge status-done">Terminé</span>
                        </li>
                    </ul>
                </div>

                <div class="card-footer">
                    <div class="avatars">
                        <div class="avatar av-yellow">JD</div>
                        <div class="avatar av-pink">AL</div>
                    </div>
                    <a href="{{ url('modif_project') }}" class="btn-add-collab">+ Collaborateur</a>
                </div>
                <a href="{{ url('details_project') }}" class="btn-project-details">+ de détails</a>
            </article>

            <article class="project-card">
                <div class="card-header">
                    <h2>Intranet RH</h2>
                    <span class="client-name">Client : Groupe Dupond</span>
                </div>

                <div class="tickets-section">
                    <h3>Tickets Récents</h3>
                    <ul class="ticket-list">
                        <li class="ticket-item">
                            <span>Export PDF fiches</span>
                            <span class="status-badge status-progress">En cours</span>
                        </li>
                        <li class="ticket-item">
                            <span>Connexion LDAP</span>
                            <span class="status-badge status-done">Terminé</span>
                        </li>
                    </ul>
                </div>

                <div class="card-footer">
                    <div class="avatars">
                        <div class="avatar av-blue">MR</div>
                    </div>
                    <a href="{{ url('modif_project') }}" class="btn-add-collab">+ Collaborateur</a>
                </div>
                <a href="{{ url('details_project') }}" class="btn-project-details">+ de détails</a>
            </article>

            <article class="project-card">
                <div class="card-header">
                    <h2>App Mobile Livraison</h2>
                    <span class="client-name">Client : FastDelivery</span>
                </div>

                <div class="tickets-section">
                    <h3>Tickets Récents</h3>
                    <ul class="ticket-list">
                        <li class="ticket-item">
                            <span>Géolocalisation</span>
                            <span class="status-badge status-new">Nouveau</span>
                        </li>
                        <li class="ticket-item">
                            <span>Push Notifications</span>
                            <span class="status-badge status-new">Nouveau</span>
                        </li>
                        <li class="ticket-item">
                            <span>Design Login</span>
                            <span class="status-badge status-progress">En cours</span>
                        </li>
                    </ul>
                </div>

                <div class="card-footer">
                    <div class="avatars">
                        <div class="avatar av-yellow">JD</div>
                        <div class="avatar av-green">KT</div>
                        <div class="avatar av-purple">SS</div>
                    </div>
                    <a href="{{ url('modif_project') }}" class="btn-add-collab">+ Collaborateur</a>
                </div>
                <a href="{{ url('details_project') }}" class="btn-project-details">+ de détails</a>
            </article>

        </div>
    </div>
</body>
</html>