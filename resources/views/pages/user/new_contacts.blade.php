@include('pages.user.partials.head')

<body>

    @include('pages.user.partials.header', ['active' => 'contacts'])

    <div class="content_create">
        <div class="form-card">
            <div class="form-header">
                <h1>Ajouter un contact</h1>
                <p>Créez une fiche pour un client, un collaborateur ou un partenaire.</p>
            </div>

            {{-- On envoie le formulaire vers contacts.store (méthode POST) --}}
            <form method="POST" action="{{ route('contacts.store') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="prenom">Prénom <span class="text-required">*</span></label>
                        <input type="text" id="prenom" name="prenom" class="form-control"
                               placeholder="Ex: Jean" value="{{ old('prenom') }}" required>
                        @error('prenom')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nom">Nom <span class="text-required">*</span></label>
                        <input type="text" id="nom" name="nom" class="form-control"
                               placeholder="Ex: Dupont" value="{{ old('nom') }}" required>
                        @error('nom')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="poste">Poste / Fonction <span class="text-required">*</span></label>
                        <input type="text" id="poste" name="poste" class="form-control"
                               placeholder="Ex: Chef de projet, CTO..." value="{{ old('poste') }}" required>
                        @error('poste')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="entreprise">Entreprise rattachée <span class="text-required">*</span></label>
                        <input type="text" id="entreprise" name="entreprise" class="form-control"
                               placeholder="Ex: GreenMarket SAS" value="{{ old('entreprise') }}" required>
                        @error('entreprise')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Adresse Email <span class="text-required">*</span></label>
                        <input type="email" id="email" name="email" class="form-control"
                               placeholder="jean.dupont@exemple.com" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telephone">Numéro de téléphone</label>
                        <input type="tel" id="telephone" name="telephone" class="form-control"
                               placeholder="06 12 34 56 78" value="{{ old('telephone') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Notes internes (Optionnel)</label>
                    <textarea id="notes" name="notes" class="form-control"
                              placeholder="Informations complémentaires, disponibilités, etc."
                              style="min-height: 80px;">{{ old('notes') }}</textarea>
                </div>

                <div class="form-actions">
                    <a href="{{ route('contacts.index') }}" class="btn-cancel">Annuler</a>
                    <button type="submit" class="btn-submit">Enregistrer le contact</button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
