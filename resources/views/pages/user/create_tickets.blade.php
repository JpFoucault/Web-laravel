@include('pages.user.partials.head')

<body>
    @include('pages.user.partials.header', ['active' => 'tickets'])

    <div class="content_create_ticket">
        <div class="form-card">
            <div class="form-header">
                <h1>Créer un nouveau ticket</h1>
                <p>Veuillez remplir les informations ci-dessous pour ouvrir une demande.</p>
            </div>

            <form id="create_ticket_form" action="{{ route('tickets.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="titre">Sujet de la demande <span class="text-required">*</span></label>
                <input type="text" id="titre" name="titre" class="form-control"
                       value="{{ old('titre') }}" placeholder="Ex: Erreur lors du paiement...">
                @error('titre') <div class="error-text">{{ $message }}</div> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="type">Type de ticket</label>
                    <select id="type" name="type" class="form-control">
                        <option value="bug">Bug</option>
                        <option value="feature">Amélioration</option>
                        <option value="support" selected>Support</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="priorite">Priorité</label>
                    <select id="priorite" name="priorite" class="form-control">
                        <option value="low">Basse</option>
                        <option value="medium" selected>Moyenne</option>
                        <option value="high">Haute</option>
                        <option value="critical">Critique</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="delai">Délai souhaité</label>
                    <input type="date" id="delai" name="delai" class="form-control" value="{{ old('delai') }}">
                </div>

                <div class="form-group">
                    <label for="projet_id">Projet concerné</label>
                    {{-- ← Balise <select> unique (avant il y en avait 2 imbriquées) --}}
                    <select id="projet_id" name="projet_id" class="form-control">
                        <option value="">-- Sélectionner un projet --</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->nom_projet }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description du problème <span class="text-required">*</span></label>
                <textarea id="description" name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                @error('description') <div class="error-text">{{ $message }}</div> @enderror
            </div>

            {{-- Équipe du ticket --}}
            @if(count($users) > 0)
            <div class="form-group" style="margin-top: 20px;">
                <label>Équipe du ticket (optionnel)</label>
                <p style="color:#94a3b8; font-size:13px; margin-bottom:10px;">
                    Les utilisateurs sélectionnés auront accès à ce ticket.
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
                                    <option value="lecteur">👁 Lecteur</option>
                                    <option value="editeur">✏️ Éditeur</option>
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
                <button type="submit" class="btn-submit">Créer le ticket</button>
            </div>
        </form>
        </div>
    </div>
</body>
</html>