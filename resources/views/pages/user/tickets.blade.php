@include('pages.user.partials.head')

<body>
    @include('pages.user.partials.header', ['active' => 'tickets'])

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
                        <button class="filter-btn btn-cancel" data-category="status" data-value="open">Nouveaux</button>
                        <button class="filter-btn btn-cancel" data-category="status" data-value="pending">En cours</button>
                        <button class="filter-btn btn-cancel" data-category="status" data-value="closed">Terminés</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="tickets-grid">
            @forelse($tickets as $ticket)
                <div class="project-card ticket-card" data-status="{{ $ticket->status }}">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="ticket-id" style="color: #818cf8; font-weight: bold; font-family: monospace;">#TICK-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</span>
                            <span class="status-badge status-{{ $ticket->status }}">
                                {{ strtoupper($ticket->status) }}
                            </span>
                        </div>
                        <h2 style="margin-top: 15px;">{{ $ticket->title }}</h2>
                        <span class="client-name">Créé le {{ $ticket->created_at->format('d M Y') }}</span>
                    </div>

                    <div class="tickets-section">
                        <h3>Détails</h3>
                        <p style="font-size: 14px; color: #cbd5e1; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $ticket->description }}
                        </p>
                    </div>

                    <div class="card-footer" style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #334155;">
                        <div class="meta-item">
                            <span class="priority-badge priority-{{ $ticket->priority }}">
                                Priorité {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>
                        <button class="btn-view" onclick="window.location.hash='popup-ticket-{{ $ticket->id }}'">Voir détails</button>
                    </div>
                </div>

                <div id="popup-ticket-{{ $ticket->id }}" class="modal-overlay">
                    <div class="modal-content">
                        <a href="#" class="close-btn">&times;</a>
                        <div class="modal-header">
                            <h2>{{ $ticket->title }}</h2>
                            <p>Ticket #{{ $ticket->id }}</p>
                        </div>
                        <div class="modal-body">
                            <div class="info-row">
                                <span class="info-label">Statut :</span>
                                <span class="status-badge status-{{ $ticket->status }}">{{ strtoupper($ticket->status) }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Priorité :</span>
                                <span class="priority-text {{ $ticket->priority }}">{{ ucfirst($ticket->priority) }}</span>
                            </div>
                            <p class="info-label" style="margin-top: 20px;">Description détaillée :</p>
                            <div class="description-box">
                                {{ $ticket->description }}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn-modal-action">Fermer</a>
                        </div>
                    </div>
                </div>

            @empty
                <div class="no-tickets" style="grid-column: 1 / -1; text-align: center; padding: 60px; background: #1e293b; border-radius: 12px; border: 1px dashed #334155;">
                    <div style="font-size: 60px; margin-bottom: 20px;">🎫</div>
                    <h2 style="color: #f8fafc;">Aucun ticket pour le moment</h2>
                    <p style="color: #94a3b8; margin-bottom: 25px;">Vous n'avez aucune demande d'assistance en cours.</p>
                    <a href="{{ route('tickets.create') }}" class="btn-create">Ouvrir un ticket</a>
                </div>
            @endforelse
        </div>
    </div>
    <script src="{{ asset('js/filter_tickets.js') }}"></script>
</body>
</html>