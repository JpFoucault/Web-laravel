@include('pages.user.partials.head')

<body>
    @include('pages.user.partials.header', ['active' => 'project'])

    <div class="content_create">
        <div class="form-card">
            <div class="form-header">
                <h1>Nouveau Projet</h1>
                <p>Définissez le cadre, le client, le budget et l'équipe pour ce nouveau projet.</p>
            </div>

            <form id="submitform" action="{{ route('projets.store') }}" method="POST">
                @csrf

                <div class="form-section">
                    <h3 class="form-section-title">Informations générales</h3>
                    
                    <div class="form-group-project">
                        <label for="nom_projet">Nom du projet <span class="text-required">*</span></label>
                        <input type="text" id="nom_projet" name="nom_projet" class="form-control" value="{{ old('nom_projet') }}" placeholder="Ex: Site E-Commerce Bio" required>
                        {{-- Affichage de l'erreur si la validation Laravel échoue --}}
                        @error('nom_projet') <div style="color:#ef4444; font-size:12px; margin-top:5px;">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group-project">
                            <label for="client_name">Client rattaché</label>
                            <input type="text" id="client_name" name="client_name" class="form-control" value="{{ old('client_name') }}" placeholder="Nom de l'entreprise cliente">
                        </div>

                        <div class="form-group-project">
                            <label for="statut">Statut du projet <span class="text-required">*</span></label>
                            <select id="statut" name="statut" class="form-control" required>
                                <option value="nouveau" {{ old('statut') == 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                                <option value="en_cours" {{ old('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="termine" {{ old('statut') == 'termine' ? 'selected' : '' }}>Terminé</option>
                                <option value="en_pause" {{ old('statut') == 'en_pause' ? 'selected' : '' }}>En pause</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group-project">
                        <label for="description">Description et contexte</label>
                        <textarea id="description" name="description" class="form-control" placeholder="Objectifs du projet...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">Planning</h3>
                    <div class="form-row">
                        <div class="form-group-project">
                            <label for="date_debut">Date de début</label>
                            <input type="date" id="date_debut" name="date_debut" class="form-control" value="{{ old('date_debut') }}">
                        </div>

                        <div class="form-group-project">
                            <label for="date_fin">Date de fin prévisionnelle</label>
                            <input type="date" id="date_fin" name="date_fin" class="form-control" value="{{ old('date_fin') }}">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">Budget et ressources</h3>
                    <div class="form-row">
                        <div class="form-group-project">
                            <label for="budget">Budget total (€)</label>
                            <input type="number" id="budget" name="budget" class="form-control" value="{{ old('budget') }}" placeholder="Ex: 45000" step="100">
                        </div>

                        <div class="form-group-project">
                            <label for="temps_estime">Temps estimé (heures)</label>
                            <input type="number" id="temps_estime" name="temps_estime" class="form-control" value="{{ old('temps_estime') }}" placeholder="Ex: 320" step="1">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">Technologies utilisées</h3>
                    <div class="form-group-project">
                        <label for="technologies">Technologies (séparées par des virgules)</label>
                        <input type="text" id="technologies" name="technologies" class="form-control" value="{{ old('technologies') }}" placeholder="Ex: React, Node.js, MongoDB...">
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">Équipe du projet</h3>
                    <div class="form-group-project">
                        <label>Assigner des collaborateurs</label>
                        <div class="collabs-grid">
                            @foreach($users as $user)
                                <label class="collab-option">
                                    {{-- Permet de garder la case cochée en cas d'erreur de formulaire --}}
                                    <input type="checkbox" name="collabs[]" value="{{ $user->id }}" {{ (is_array(old('collabs')) && in_array($user->id, old('collabs'))) ? 'checked' : '' }}>
                                    <span class="avatar">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                    <span class="collab-name">{{ $user->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('projets.index') }}" class="btn-cancel">Annuler</a>
                    <button type="submit" class="btn-submit">Créer le projet</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>