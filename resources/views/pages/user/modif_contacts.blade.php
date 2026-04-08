@include('pages.user.partials.head')

<body>

    @include('pages.user.partials.header', ['active' => 'contacts'])

    <div class="content_create">
        <div class="form-card">
            <div class="form-header">
                <h1>Modifier un contact</h1>
                <p>Modifier la fiche d'un client, un collaborateur ou un partenaire.</p>
            </div>

            {{-- On envoie le formulaire vers contacts.update (méthode PUT) --}}
            <form method="POST" action="{{ route('contacts.update', $contact) }}">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label for="prenom">Prénom <span class="text-required">*</span></label>
                        <input type="text" id="prenom" name="prenom" class="form-control"
                               value="{{ old('prenom', $contact->prenom) }}" required>
                        @error('prenom')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nom">Nom <span class="text-required">*</span></label>
                        <input type="text" id="nom" name="nom" class="form-control"
                               value="{{ old('nom', $contact->nom) }}" required>
                        @error('nom')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="poste">Poste / Fonction <span class="text-required">*</span></label>
                        <input type="text" id="poste" name="poste" class="form-control"
                               value="{{ old('poste', $contact->poste) }}" required>
                        @error('poste')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="entreprise">Entreprise rattachée <span class="text-required">*</span></label>
                        <input type="text" id="entreprise" name="entreprise" class="form-control"
                               value="{{ old('entreprise', $contact->entreprise) }}" required>
                        @error('entreprise')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Adresse Email <span class="text-required">*</span></label>
                        <input type="email" id="email" name="email" class="form-control"
                               value="{{ old('email', $contact->email) }}" required>
                        @error('email')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telephone">Numéro de téléphone</label>
                        <input type="tel" id="telephone" name="telephone" class="form-control"
                               value="{{ old('telephone', $contact->telephone) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Notes internes (Optionnel)</label>
                    <textarea id="notes" name="notes" class="form-control"
                              style="min-height: 80px;">{{ old('notes', $contact->notes) }}</textarea>
                </div>

                <div class="form-actions">
                    <a href="{{ route('contacts.index') }}" class="btn-cancel">Annuler</a>
                    <button type="submit" class="btn-submit">Modifier le contact</button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
