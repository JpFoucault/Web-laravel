@include('pages.user.partials.head')

<body>
    @include('pages.user.partials.header', ['active' => 'tickets'])

    <div class="content">

        <div class="page-actions">
            <div>
                <a href="{{ route('tickets.index') }}" style="color:#94a3b8; text-decoration:none;">
                    ← Retour aux tickets
                </a>
                <h1>{{ $ticket->titre }}</h1>
            </div>

            @if($ticket->peutModifier(auth()->user()))
                <a href="{{ route('tickets.edit', $ticket) }}" class="btn-create">Modifier le ticket</a>
            @endif
        </div>

        <div class="detail-card">

            <div class="info-grid">
                <div class="info-item">
                    <label>Type de demande</label>
                    <span>
                        @php
                            $types = ['bug' => 'Correction de Bug', 'feature' => 'Nouvelle Fonctionnalité', 'support' => 'Support Technique'];
                        @endphp
                        {{ $types[$ticket->type] ?? $ticket->type }}
                    </span>
                </div>

                <div class="info-item">
                    <label>Projet</label>
                    {{-- ← WAS $ticket->project, NOW $ticket->projet --}}
                    <span>{{ $ticket->project?->nom_projet ?? 'Aucun projet' }}</span>
                </div>

                <div class="info-item">
                    <label>Priorité</label>
                    <span class="priority-badge priority-{{ $ticket->priorite }}">
                        {{ ucfirst($ticket->priorite) }}
                    </span>
                </div>

                <div class="info-item">
                    <label>Statut actuel</label>
                    @php
                        $statusClass = match($ticket->statut) {
                            'En cours'  => 'status-progress',
                            'Terminé'   => 'status-done',
                            'En revue'  => 'status-progress',
                            default     => 'status-new',
                        };
                    @endphp
                    <span class="status-badge {{ $statusClass }}">
                        {{ $ticket->statut }}
                    </span>
                </div>

                <div class="info-item">
                    <label>Échéance</label>
                    <span>
                        {{ $ticket->delai ? \Carbon\Carbon::parse($ticket->delai)->format('d/m/Y') : 'Non définie' }}
                    </span>
                </div>

                <div class="info-item">
                    <label>Temps passé</label>
                    <span>{{ $ticket->temps_passe ?? 0 }} heures</span>
                </div>
            </div>

            <div style="margin-bottom: 30px;">
                <label style="color:#94a3b8; font-size:12px; text-transform:uppercase;">Description</label>
                <div class="description-box" style="margin-top:10px;">
                    {!! nl2br(e($ticket->description)) !!}
                </div>
            </div>

            <div class="detail-card" style="margin-bottom: 20px;">
                <h3 style="margin-top:0; font-size:16px; color:#f8fafc;">⏱ Suivi du temps</h3>

                @if(session('time_added'))
                    <p style="color:#22c55e; font-size:13px; margin-bottom:10px;">
                        ✅ Temps mis à jour avec succès !
                    </p>
                @endif

                <form action="{{ route('tickets.addTime', $ticket) }}" method="POST"
                    style="display:flex; gap:15px; align-items:flex-end;">
                    @csrf
                    <div class="form-group" style="margin-bottom:0; flex:1;">
                        <label for="heures" style="font-size:11px;">Ajouter des heures travaillées</label>
                        <input type="number" name="heures" id="heures" class="form-control"
                            placeholder="Nombre d'heures" min="1" required>
                    </div>
                    <button type="submit" class="btn-submit" style="padding:12px 25px;">
                        Ajouter
                    </button>
                </form>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <label>Créé par</label>
                    <span>{{ $ticket->createur?->name ?? 'Inconnu' }}</span>
                </div>

                <div class="info-item">
                    <label>Assigné à</label>
                    <span>{{ $ticket->assigneA?->name ?? '—' }}</span>
                </div>

                <div class="info-item">
                    <label>Équipe assignée</label>
                    <div style="margin-top:10px; display:flex; flex-wrap:wrap; gap:8px;">
                        @forelse($ticket->membres as $membre)
                            <span class="assigne-tag">
                                👤 {{ $membre->name }}
                                <span style="margin-left:6px; font-size:11px; color:#94a3b8;">
                                    ({{ $membre->pivot->role === 'editeur' ? '✏️ Éditeur' : '👁 Lecteur' }})
                                </span>
                            </span>
                        @empty
                            <span style="color:#94a3b8;">Aucun membre assigné</span>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        @if($ticket->createur_id === auth()->id())
            <div style="margin-top:20px; text-align:right;">
                <form action="{{ route('tickets.destroy', $ticket) }}" method="POST"
                    onsubmit="return confirm('Supprimer définitivement ce ticket ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-supr">🗑 Supprimer le ticket</button>
                </form>
            </div>
        @endif

    </div>

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
            margin-bottom: 30px;
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