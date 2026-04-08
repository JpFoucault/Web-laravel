@include('pages.user.partials.head')

<body>
    @include('pages.user.partials.header', ['active' => 'dashboard'])

    <div class="content">
        <h1>Bienvenue, {{ auth()->user()->name }}</h1>
        <br>

        <div class="Stat">
            <div class="Info">
                <ul>
                    <li class="box">
                        <h1>Projets</h1>
                        <h2>{{ $projetsCount }}</h2>
                    </li>
                    <li class="box">
                        <h1>Tickets</h1>
                        <h2>{{ $ticketsCount }}</h2>
                    </li>
                    <li class="box">
                        <h1>Heures log</h1>
                        <h2>{{ $heuresTotal }}h</h2>
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-card" style="margin-bottom: 30px;">
            <div class="card-header-padding" style="display: flex; justify-content: space-between; align-items: center;">
                <h2>Tickets récents</h2>
                <a href="{{ route('tickets.index') }}" class="btn-add-collab">Voir tous</a>
            </div>
            <table class="ticket-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ticket & Projet</th>
                        <th>Priorité</th>
                        <th>État</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ticketsRecents as $ticket)
                        @php
                            $statusClass = match($ticket->statut) {
                                'En cours' => 'status-progress',
                                'Terminé'  => 'status-done',
                                'En revue' => 'status-progress',
                                default    => 'status-new',
                            };
                            $priorityClass = match($ticket->priorite) {
                                'high'     => 'priority-high',
                                'critical' => 'priority-high',
                                'medium'   => 'priority-medium',
                                default    => 'priority-low',
                            };
                        @endphp
                        <tr>
                            <td style="color: #818cf8; font-weight: bold; font-family: monospace;">
                                #TICK-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>
                                <div class="ticket-info">
                                    <span class="ticket-title">{{ $ticket->titre }}</span>
                                    <span class="ticket-project">{{ $ticket->project?->nom_projet ?? 'Aucun projet' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="priority-badge {{ $priorityClass }}">{{ ucfirst($ticket->priorite) }}</span>
                            </td>
                            <td>
                                <span class="status-badge {{ $statusClass }}">{{ strtoupper($ticket->statut) }}</span>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('tickets.show', $ticket) }}" class="btn-details">Voir</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 30px; color: #94a3b8;">
                                Aucun ticket pour le moment.
                                <a href="{{ route('tickets.create') }}" style="color: #818cf8; margin-left: 8px;">Créer un ticket →</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-card">
            <div class="card-header-padding" style="display: flex; justify-content: space-between; align-items: center;">
                <h2>Projets récents</h2>
                <a href="{{ route('projets.index') }}" class="btn-add-collab">Voir tous</a>
            </div>
            <table class="ticket-table">
                <thead>
                    <tr>
                        <th>Projet</th>
                        <th>Client</th>
                        <th>Budget</th>
                        <th>État</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projetsRecents as $projet)
                        @php
                            $pStatusClass = match($projet->statut) {
                                'en cours'  => 'status-progress',
                                'terminé'   => 'status-done',
                                'en pause'  => 'status-new',
                                default     => 'status-new',
                            };
                        @endphp
                        <tr>
                            <td>
                                <div class="ticket-info">
                                    <span class="ticket-title">{{ $projet->nom_projet }}</span>
                                    <span class="ticket-project">Créé le {{ $projet->created_at->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td>{{ $projet->client_name ?? '—' }}</td>
                            <td>{{ $projet->budget ? number_format($projet->budget, 0, ',', ' ') . ' €' : '—' }}</td>
                            <td>
                                <span class="status-badge {{ $pStatusClass }}">{{ strtoupper($projet->statut) }}</span>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('projets.show', $projet->id) }}" class="btn-details">Voir</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 30px; color: #94a3b8;">
                                Aucun projet pour le moment.
                                <a href="{{ route('projets.create') }}" style="color: #818cf8; margin-left: 8px;">Créer un projet →</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>
