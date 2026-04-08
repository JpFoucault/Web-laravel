@include('pages.user.partials.head')

<body>
    @include('pages.user.partials.header', ['active' => 'tickets'])

    @if(session('success'))
        <div style="width: 50%; background:#22c55e20; border:1px solid #22c55e; color:#22c55e; padding:12px 20px; border-radius:8px; margin:auto; text-align:center">
            {{ session('success') }}
        </div>
    @endif
    <div class="content">
        <div class="filter-section" style="margin-bottom: 30px;">
            <div class="page-actions">
                <h1>Mes Demandes de Support</h1>
                <a href="{{ route('tickets.create') }}" class="btn-create">+ Nouveau Ticket</a>
            </div>
            
            <div style="display: flex; gap: 20px; flex-wrap: wrap; background: #1e293b; padding: 20px; border-radius: 12px; border: 1px solid #334155;">
                <div>
                    <p style="font-size: 13px; color: #94a3b8; margin-bottom: 8px;">État :</p>
                    <div style="display: flex; gap: 10px;">
                        <button class="filter-btn btn-cancel active" data-category="all">Tous</button>
                        <button class="filter-btn btn-cancel" data-category="status" data-value="Nouveau">Nouveaux</button>
                        <button class="filter-btn btn-cancel" data-category="status" data-value="En cours">En cours</button>
                        <button class="filter-btn btn-cancel" data-category="status" data-value="Terminé">Terminés</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="projects-grid">  {{-- réutilise la grille des projets --}}
            @forelse($tickets as $ticket)
                @php
                    $statusClass = match($ticket->statut) {
                        'En cours'  => 'status-progress',
                        'Terminé'   => 'status-done',
                        'En revue'  => 'status-progress',
                        default     => 'status-new',   // Nouveau
                    };
                    $priorityClass = match($ticket->priorite) {
                        'high'     => 'priority-high',
                        'critical' => 'priority-high',
                        'medium'   => 'priority-medium',
                        default    => 'priority-low',
                    };
                @endphp
                <div class="project-card ticket-card" data-status="{{ $ticket->statut }}">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: #818cf8; font-weight: bold; font-family: monospace;">
                                #TICK-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                            <span class="status-badge {{ $statusClass }}">
                                {{ strtoupper($ticket->statut) }}
                            </span>
                        </div>
                        <h2 style="margin-top: 15px;">{{ $ticket->titre }}</h2>
                        <span class="client-name">Créé le {{ $ticket->created_at->format('d M Y') }}</span>
                    </div>

                    <div class="tickets-section" style="margin-top: 15px;">
                        <h3>Projet : {{ $ticket->projet?->nom_projet ?? 'Aucun' }}</h3>
                        <a href="{{ route('tickets.show', $ticket) }}" class="btn-view">Voir détails</a>
                    </div>

                    <div class="card-footer" style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #334155;">
                        <span class="priority-badge {{ $priorityClass }}">
                            Priorité {{ ucfirst($ticket->priorite) }}
                        </span>
                        @if($ticket->createur_id === auth()->id())
                            <a href="{{ route('tickets.edit', $ticket) }}" class="btn-add-collab">Modifier</a>
                        @endif
                    </div>
                </div>

            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px; background: #1e293b; border-radius: 12px; border: 1px dashed #334155;">
                    <div style="font-size: 60px; margin-bottom: 20px;">🎫</div>
                    <h2 style="color: #f8fafc;">Aucun ticket pour le moment</h2>
                    <p style="color: #94a3b8; margin-bottom: 25px;">Vous n'avez aucune demande d'assistance en cours.</p>
                </div>
            @endforelse
        </div>
    </div>
    <script src="{{ asset('js/filter_tickets.js') }}"></script>
</body>
</html>