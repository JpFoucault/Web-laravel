@include('pages.user.partials.head')

<body>
    @include('pages.user.partials.header', ['active' => 'project'])

    @if(session('success'))
        <div style="width: 50%; background:#22c55e20; border:1px solid #22c55e; color:#22c55e; padding:12px 20px; border-radius:8px; margin:auto; margin-top: 20px; text-align:center">
            {{ session('success') }}
        </div>
    @endif

    <div class="content">
        <div class="page-actions">
            <h1>Liste des Projets</h1>
            {{-- Utilisation de route() pour être raccord avec tes tickets --}}
            <a href="{{ route('projets.create') }}" class="btn-create">+ Nouveau Projet</a>
        </div>

        <div class="projects-grid">
            @if ($projets->count() > 0)
                @foreach ($projets as $projet)
                    <article class="project-card">
                        <div class="card-header">
                            <h2>{{ $projet->nom_projet }}</h2>
                            <span class="client-name">Client : {{ $projet->client_name ?? 'Non défini' }}</span>
                        </div>

                        <div class="tickets-section">
                            <h3>Détails</h3>
                            <ul class="ticket-list">
                                <li class="ticket-item">
                                    <span>Statut</span>
                                    @php
                                        $badgeClass = 'status-new';
                                        if($projet->statut == 'en_cours') $badgeClass = 'status-progress';
                                        if($projet->statut == 'termine') $badgeClass = 'status-done';
                                    @endphp
                                    <span class="status-badge {{ $badgeClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $projet->statut)) }}
                                    </span>
                                </li>
                                <li class="ticket-item">
                                    <span>Budget</span>
                                    <span style="color: #4ade80; font-weight: bold;">
                                        {{ number_format($projet->budget, 2, ',', ' ') }} €
                                    </span>
                                </li>
                            </ul>
                        </div>

                        <div class="card-footer">
                            <div class="avatars">
                                <div class="avatar av-blue">P</div>
                            </div>
                            <a href="{{ route('projets.edit', $projet->id) }}" class="btn-add-collab">Modifier</a>
                        </div>
                        <a href="{{ route('projets.show', $projet->id) }}" class="btn-project-details">+ de détails</a>
                    </article>
                @endforeach
            @else
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px; background: #1e293b; border-radius: 12px; border: 1px dashed #334155;">
                    <div style="font-size: 60px; margin-bottom: 20px;">📁</div>
                    <h2 style="color: #f8fafc;">Aucun projet pour le moment</h2>
                    <p style="color: #94a3b8; margin-bottom: 25px;">Vous n'avez aucun projet en cours.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>