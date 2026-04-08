@include('pages.user.partials.head')

<body>
    @include('pages.user.partials.header', ['active' => 'project'])

    <div class="content_create">
        <div class="form-card">
            <div class="form-header">
                <h1>Modifier le projet : {{ $projet->nom_projet }}</h1>
                <p>Mettez à jour les informations, le budget et l'équipe pour ce projet.</p>
            </div>

            <form id="submitform" action="{{ route('projets.update', $projet->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Indispensable pour la modification en Laravel --}}

                <div class="form-section">
                    <h3 class="form-section-title">Informations générales</h3>
                    
                    <div class="form-group-project">
                        <label for="nom_projet">Nom du projet <span class="text-required">*</span></label>
                        <input type="text" id="nom_projet" name="nom_projet" class="form-control" value="{{ old('nom_projet', $projet->nom_projet) }}" required>
                        @error('nom_projet') <div style="color:#ef4444; font-size:12px; margin-top:5px;">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group-project">
                            <label for="client_name">Client rattaché</label>
                            <input type="text" id="client_name" name="client_name" class="form-control" value="{{ old('client_name', $projet->client_name) }}">
                        </div>

                        <div class="form-group-project">
                            <label for="statut">Statut du projet <span class="text-required">*</span></label>
                            <select id="statut" name="statut" class="form-control" required>
                                <option value="nouveau" {{ old('statut', $projet->statut) == 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                                <option value="en_cours" {{ old('statut', $projet->statut) == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="termine" {{ old('statut', $projet->statut) == 'termine' ? 'selected' : '' }}>Terminé</option>
                                <option value="en_pause" {{ old('statut', $projet->statut) == 'en_pause' ? 'selected' : '' }}>En pause</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group-project">
                        <label for="description">Description et contexte</label>
                        <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $projet->description) }}</textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">Planning</h3>
                    <div class="form-row">
                        <div class="form-group-project">
                            <label for="date_debut">Date de début</label>
                            <input type="date" id="date_debut" name="date_debut" class="form-control" value="{{ old('date_debut', $projet->date_debut) }}">
                        </div>

                        <div class="form-group-project">
                            <label for="date_fin">Date de fin prévisionnelle</label>
                            <input type="date" id="date_fin" name="date_fin" class="form-control" value="{{ old('date_fin', $projet->date_fin) }}">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">Budget et ressources</h3>
                    <div class="form-row">
                        <div class="form-group-project">
                            <label for="budget">Budget total (€)</label>
                            <input type="number" id="budget" name="budget" class="form-control" value="{{ old('budget', $projet->budget) }}" step="100">
                        </div>

                        <div class="form-group-project">
                            <label for="temps_estime">Temps estimé (heures)</label>
                            <input type="number" id="temps_estime" name="temps_estime" class="form-control" value="{{ old('temps_estime', $projet->temps_estime) }}" step="1">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">Technologies utilisées</h3>
                    <div class="form-group-project">
                        <label for="technologies">Technologies (séparées par des virgules)</label>
                        <input type="text" id="technologies" name="technologies" class="form-control" value="{{ old('technologies', $projet->technologies) }}">
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">Équipe du projet</h3>
                    <div class="form-group-project">
                        <label>Modifier les collaborateurs</label>
                        <div class="collabs-grid">
                            @php
                                // On récupère les IDs des collaborateurs actuels sous forme de tableau
                                $currentCollabs = $projet->collaborateurs->pluck('id')->toArray();
                            @endphp

                            @foreach($users as $user)
                                <label class="collab-option">
                                    {{-- On pré-coche si l'utilisateur faisait déjà partie du projet (ou si on revient d'une erreur de validation) --}}
                                    <input type="checkbox" name="collabs[]" value="{{ $user->id }}" 
                                        {{ (is_array(old('collabs', $currentCollabs)) && in_array($user->id, old('collabs', $currentCollabs))) ? 'checked' : '' }}>
                                    <span class="avatar">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                    <span class="collab-name">{{ $user->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('projets.show', $projet->id) }}" class="btn-cancel">Annuler</a>
                    <button type="submit" class="btn-submit">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>