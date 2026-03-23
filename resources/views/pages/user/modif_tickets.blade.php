@include('pages.user.partials.head')

<body>
    @include('pages.user.partials.header', ['active' => 'tickets'])

    <div class="content_create_ticket">
        <div class="form-card">
            <div class="form-header">
                <h1>Modifier le ticket #{{ $ticket->id }}</h1>
                <p>Mettez à jour les informations de la demande.</p>
            </div>

            <form action="{{ route('tickets.update', $ticket) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="titre">Sujet de la demande <span class="text-required">*</span></label>
                    <input type="text" id="titre" name="titre" class="form-control"
                           value="{{ old('titre', $ticket->titre) }}" required>
                    @error('titre') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="projet_id">Projet concerné (optionnel)</label>
                        <select id="projet_id" name="projet_id" class="form-control">
                            <option value="">— Aucun projet —</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}"
                                    {{ old('projet_id', $ticket->projet_id) == $project->id ? 'selected' : '' }}>
                                    {{ $project->nom_projet }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="statut">Statut</label>
                        <select id="statut" name="statut" class="form-control">
                            @foreach(['Nouveau', 'En cours', 'En revue', 'Terminé'] as $s)
                                <option value="{{ $s }}" {{ old('statut', $ticket->statut) === $s ? 'selected' : '' }}>
                                    {{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="type">Type de ticket</label>
                        <select id="type" name="type" class="form-control">
                            <option value="bug"     {{ old('type', $ticket->type) === 'bug'     ? 'selected' : '' }}>Bug</option>
                            <option value="feature" {{ old('type', $ticket->type) === 'feature' ? 'selected' : '' }}>Amélioration</option>
                            <option value="support" {{ old('type', $ticket->type) === 'support' ? 'selected' : '' }}>Support</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="priorite">Priorité</label>
                        <select id="priorite" name="priorite" class="form-control">
                            <option value="low"      {{ old('priorite', $ticket->priorite) === 'low'      ? 'selected' : '' }}>Basse</option>
                            <option value="medium"   {{ old('priorite', $ticket->priorite) === 'medium'   ? 'selected' : '' }}>Moyenne</option>
                            <option value="high"     {{ old('priorite', $ticket->priorite) === 'high'     ? 'selected' : '' }}>Haute</option>
                            <option value="critical" {{ old('priorite', $ticket->priorite) === 'critical' ? 'selected' : '' }}>Critique</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="delai">Délai souhaité</label>
                    <input type="date" id="delai" name="delai" class="form-control"
                        value="{{ old('delai', $ticket->delai) }}">
                </div>

                <div class="form-group">
                    <label for="description">Description <span class="text-required">*</span></label>
                    <textarea id="description" name="description" class="form-control" rows="5" required>{{ old('description', $ticket->description) }}</textarea>
                    @error('description') <div class="error-text">{{ $message }}</div> @enderror
                </div>
                @if($ticket->createur_id === auth()->id())
                    <div class="form-group" style="margin-top: 20px;">
                        <label>Équipe du ticket</label>
                        <p style="color:#94a3b8; font-size:13px; margin-bottom:10px;">
                            Les utilisateurs non ajoutés ici ne verront pas ce ticket.
                        </p>
                        <div class="collabs-grid">
                            @foreach($users as $u)
                                <div class="collab-option">
                                    <div class="avatar" style="width:36px;height:36px;font-size:13px;">
                                        {{ strtoupper(substr($u->name, 0, 2)) }}
                                    </div>
                                    <div class="collab-info">
                                        <strong style="color:#f1f5f9; font-size:13px;">{{ $u->name }}</strong>
                                        <select name="membres[{{ $loop->index }}][role]" class="form-control"
                                                style="margin-top:4px; padding:3px 8px; font-size:12px;">
                                            <option value="">— Pas d'accès —</option>
                                            <option value="lecteur"
                                                {{ isset($membresActuels[$u->id]) && $membresActuels[$u->id] === 'lecteur' ? 'selected' : '' }}>
                                                👁 Lecteur
                                            </option>
                                            <option value="editeur"
                                                {{ isset($membresActuels[$u->id]) && $membresActuels[$u->id] === 'editeur' ? 'selected' : '' }}>
                                                ✏️ Éditeur
                                            </option>
                                        </select>
                                        <input type="hidden" name="membres[{{ $loop->index }}][id]" value="{{ $u->id }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="form-actions">
                    <a href="{{ route('tickets.index') }}" class="btn-cancel">Annuler</a>
                    <button type="submit" class="btn-submit">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
    <script>
    // Retire les membres sans rôle avant envoi du formulaire
    document.querySelector('form').addEventListener('submit', function() {
        document.querySelectorAll('select[name*="[role]"]').forEach(function(select) {
            if (!select.value) {
                select.closest('.collab-option').querySelectorAll('input, select').forEach(el => el.disabled = true);
            }
        });
    });
    </script>
</body>

</html>