@include('pages.user.partials.head')

<body>
    @include('pages.user.partials.header', ['active' => 'project'])

    <div class="content">
        <div class="page-actions">
            <div>
                <a href="{{ route('projets.index') }}" class="back-link" style="color:#94a3b8; text-decoration:none;">← Retour aux projets</a>
                <h1>{{ $projet->nom_projet }}</h1>
            </div>
            @if(Auth::id() === $projet->createur_id)
                <a href="{{ route('projets.edit', $projet->id) }}" class="btn-add-collab">Modifier le projet</a>
            @endif
        </div>

        <div class="detail-card">
            <div class="info-grid">
                <div class="info-item">
                    <label>Statut</label>
                    <span class="status-badge status-progress">
                        {{ ucfirst(str_replace('_', ' ', $projet->statut ?? 'En cours')) }}
                    </span>
                </div>
                <div class="info-item">
                    <label>Budget</label>
                    <span style="color: #4ade80;">
                        {{ number_format($projet->budget ?? 0, 2, ',', ' ') }} €
                    </span>
                </div>
                <div class="info-item">
                    <label>Budget consommé</label>
                    @php $budget_consomme = $total_heures * 15; @endphp
                    <span style="color: {{ $budget_consomme > ($projet->budget ?? 0) && $projet->budget ? '#f87171' : '#fb923c' }};">
                        {{ number_format($budget_consomme, 2, ',', ' ') }} €
                    </span>
                </div>
                <div class="info-item">
                    <label>Client</label>
                    <span>{{ $projet->client_name ?? 'Non défini' }}</span>
                </div>
            </div>
        </div>

        <div class="detail-card" style="margin-top: 20px;">
            <h3 style="margin-top:0; font-size:16px; color:#f8fafc;">👥 Équipe du projet</h3>
            <div style="margin-top:10px; display:flex; flex-wrap:wrap; gap:8px;">
                @forelse($projet->collaborateurs ?? [] as $membre)
                    <span class="assigne-tag">
                        👤 {{ $membre->name }}
                    </span>
                @empty
                    <span style="color:#94a3b8;">Aucun membre assigné à ce projet.</span>
                @endforelse
            </div>
        </div>

        <div class="form-card card-spacing" style="margin-top: 20px;">

            <h2 class="section-header h2" style="color:#f8fafc; margin-bottom:20px;">Statistiques</h2>
            <div class="stats-grid" style="margin-bottom:25px;">
                <div class="contact-item stat-box">
                    <span class="ci-label">Total tickets</span>
                    <div id="stat-total" class="stat-number primary">{{ $projet->tickets->count() }}</div>
                </div>
                <div class="contact-item stat-box">
                    <span class="ci-label">En cours</span>
                    <div class="stat-number warning">
                        {{ $projet->tickets->where('statut', 'En cours')->count() }}
                    </div>
                </div>
                <div class="contact-item stat-box">
                    <span class="ci-label">Terminés</span>
                    <div class="stat-number success">
                        {{ $projet->tickets->where('statut', 'Terminé')->count() }}
                    </div>
                </div>
                <div class="contact-item stat-box">
                    <span class="ci-label">Temps passé</span>
                    <div class="stat-number primary">{{ $total_heures }}h</div>
                </div>
            </div>

            <div class="section-header" style="margin-bottom:15px;">
                <h2 style="color:#f8fafc; margin:0;">Tickets du projet</h2>
                <div id="btn-lier-wrapper">
                    @if($free_tickets->count() > 0)
                        <a href="#modal-link-ticket" class="btn-create">Lier un ticket</a>
                    @else
                        <span style="color:#64748b; font-size:13px;">Aucun ticket disponible à lier</span>
                    @endif
                </div>
            </div>

            <div class="table-card">
                <table class="ticket-table">
                    <thead>
                        <tr>
                            <th>Ticket</th>
                            <th>Priorité</th>
                            <th>Statut</th>
                            <th>Créé par</th>
                            <th>Délai</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tickets-tbody">
                        @forelse($projet->tickets as $ticket)
                            <tr>
                                <td>
                                    <div class="ticket-info">
                                        <span class="ticket-title">{{ $ticket->titre }}</span>
                                        <span class="ticket-project" style="font-size:12px; color:#94a3b8;">
                                            #TICK-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <span class="priority-badge priority-{{ $ticket->priorite }}">
                                        {{ ucfirst($ticket->priorite) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($ticket->statut) {
                                            'Nouveau'  => 'status-new',
                                            'En cours' => 'status-progress',
                                            'Terminé'  => 'status-done',
                                            default    => 'status-new',
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ $ticket->statut }}
                                    </span>
                                </td>
                                <td>{{ $ticket->createur?->name ?? '—' }}</td>
                                <td>
                                    {{ $ticket->delai
                                        ? \Carbon\Carbon::parse($ticket->delai)->format('d/m/Y')
                                        : '—' }}
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('tickets.show', $ticket) }}" class="btn-details">
                                        Voir détails
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr id="empty-row">
                                <td colspan="6" style="text-align:center; color:#94a3b8; padding:30px;">
                                    Aucun ticket lié à ce projet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ========== MODAL LIER UN TICKET ========== --}}
    <div id="modal-link-ticket" class="modal-overlay">
        <div class="modal-content">
            <a href="#" class="close-btn">&times;</a>

            <div class="modal-header">
                <h2>Lier un ticket au projet</h2>
                <p style="color:#94a3b8; font-size:13px; margin-top:5px;">
                    Sélectionnez un ticket existant sans projet assigné.
                </p>
            </div>

            <div class="form-group" style="margin-top:15px;">
                <label for="ticket_id">Ticket disponible</label>
                <select id="ticket_id" class="form-control">
                    <option value="" disabled selected>-- Sélectionner un ticket --</option>
                    @foreach($free_tickets as $ft)
                        <option value="{{ $ft->id }}">
                            #{{ str_pad($ft->id, 4, '0', STR_PAD_LEFT) }} — {{ $ft->titre }}
                            ({{ ucfirst($ft->priorite) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <p id="link-error" style="color:#f87171; font-size:13px; margin-top:8px; display:none;"></p>

            <div class="form-actions">
                <a href="#" class="btn-cancel">Annuler</a>
                <button id="btn-link-ticket" class="btn-submit">Lier au projet</button>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('btn-link-ticket').addEventListener('click', function () {
        const select = document.getElementById('ticket_id');
        const errorEl = document.getElementById('link-error');
        const ticketId = select.value;

        errorEl.style.display = 'none';
        errorEl.textContent = '';

        if (!ticketId) {
            errorEl.textContent = 'Veuillez sélectionner un ticket.';
            errorEl.style.display = 'block';
            return;
        }

        this.disabled = true;

        fetch('{{ route('projets.link_ticket', $projet->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ticket_id: ticketId })
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (!data.success) {
                errorEl.textContent = data.error ?? 'Une erreur est survenue.';
                errorEl.style.display = 'block';
                document.getElementById('btn-link-ticket').disabled = false;
                return;
            }

            const t = data.ticket;

            // Supprime la ligne "vide" si présente
            const emptyRow = document.getElementById('empty-row');
            if (emptyRow) emptyRow.remove();

            // Détermine la classe CSS du statut
            const statusClasses = { 'Nouveau': 'status-new', 'En cours': 'status-progress', 'Terminé': 'status-done' };
            const statusClass = statusClasses[t.statut] ?? 'status-new';

            // Construit et insère la nouvelle ligne
            const tbody = document.getElementById('tickets-tbody');
            const tr = document.createElement('tr');
            tr.innerHTML =
                '<td>' +
                    '<div class="ticket-info">' +
                        '<span class="ticket-title">' + t.titre + '</span>' +
                        '<span class="ticket-project" style="font-size:12px; color:#94a3b8;">' +
                            '#TICK-' + String(t.id).padStart(4, '0') +
                        '</span>' +
                    '</div>' +
                '</td>' +
                '<td><span class="priority-badge priority-' + t.priorite + '">' + t.priorite.charAt(0).toUpperCase() + t.priorite.slice(1) + '</span></td>' +
                '<td><span class="status-badge ' + statusClass + '">' + t.statut + '</span></td>' +
                '<td>' + t.createur + '</td>' +
                '<td>' + (t.delai ?? '—') + '</td>' +
                '<td class="text-right"><a href="' + t.url + '" class="btn-details">Voir détails</a></td>';
            tbody.appendChild(tr);

            // Incrémente le compteur total
            const statTotal = document.getElementById('stat-total');
            statTotal.textContent = parseInt(statTotal.textContent) + 1;

            // Supprime l'option du select
            select.querySelector('option[value="' + ticketId + '"]').remove();

            // Si plus aucun ticket libre, retire le bouton "Lier un ticket"
            if (select.querySelectorAll('option[value]').length === 0) {
                const wrapper = document.getElementById('btn-lier-wrapper');
                wrapper.innerHTML = '<span style="color:#64748b; font-size:13px;">Aucun ticket disponible à lier</span>';
            }

            // Ferme le modal
            window.location.hash = '';
            document.getElementById('btn-link-ticket').disabled = false;
        })
        .catch(function () {
            errorEl.textContent = 'Erreur réseau, veuillez réessayer.';
            errorEl.style.display = 'block';
            document.getElementById('btn-link-ticket').disabled = false;
        });
    });
    </script>

    <style>
        .detail-card {
            background: #1e293b;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #334155;
            margin-top: 15px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .info-item label {
            display: block;
            color: #94a3b8;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .info-item span {
            color: #f8fafc;
            font-weight: 600;
            font-size: 15px;
        }
        .assigne-tag {
            display: inline-flex;
            align-items: center;
            background: #334155;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            color: #f1f5f9;
        }
    </style>
</body>
</html>