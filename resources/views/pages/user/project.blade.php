@extends('layouts.app')

@section('content')
<div class="content">
    <div class="page-actions">
        <h1>Liste des Projets</h1>
        <a href="{{ route('projets.create') }}" class="btn-create">+ Nouveau Projet</a>
    </div>

    @if(session('success'))
        <div style="color:green; margin-bottom: 20px;">{{ session('success') }}</div>
    @endif

    <div class="projects-grid">
        @forelse ($projets as $projet)
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
                                $badgeClass = match($projet->statut) {
                                    'en_cours' => 'status-progress',
                                    'termine' => 'status-done',
                                    default => 'status-new',
                                };
                            @endphp
                            <span class="status-badge {{ $badgeClass }}">
                                {{ ucfirst(str_replace('_', ' ', $projet->statut)) }}
                            </span>
                        </li>
                        <li class="ticket-item">
                            <span>Budget</span>
                            <span style="color: #4ade80; font-weight: bold;">{{ number_format($projet->budget, 2, ',', ' ') }} €</span>
                        </li>
                    </ul>
                </div>

                <div class="card-footer">
                    <div class="avatars">
                        <div class="avatar av-blue">{{ strtoupper(substr($projet->nom_projet, 0, 1)) }}</div>
                    </div>
                    @if(Auth::id() === $projet->createur_id)
                        <a href="{{ route('projets.edit', $projet->id) }}" class="btn-add-collab">Modifier</a>
                    @endif
                </div>
                <a href="{{ route('projets.show', $projet->id) }}" class="btn-project-details">+ de détails</a>
            </article>
        @empty
            <div style="text-align: center; color: #94a3b8; width: 100%; grid-column: 1 / -1; padding: 40px;">
                <p>Aucun projet n'a été trouvé.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection