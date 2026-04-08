@include('pages.user.partials.head')

<body>

    @include('pages.user.partials.header', ['active' => 'bills'])

    <div class="content_create">
        <div class="form-card">
            <div class="form-header">
                <h1>Modifier une facture</h1>
                <p>Vous pouvez changer le nom et l'état de la facture. Le fichier ne peut pas être remplacé.</p>
            </div>

            <form method="POST" action="{{ route('factures.update', $facture) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nom_facture">Nom de la facture <span class="text-required">*</span></label>
                    <input type="text" id="nom_facture" name="nom_facture" class="form-control"
                           value="{{ old('nom_facture', $facture->nom_facture) }}" required>
                    @error('nom_facture')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="statut">État <span class="text-required">*</span></label>
                    <select id="statut" name="statut" class="form-control" required>
                        <option value="en cours" {{ old('statut', $facture->statut) === 'en cours' ? 'selected' : '' }}>En cours</option>
                        <option value="payee"    {{ old('statut', $facture->statut) === 'payee'    ? 'selected' : '' }}>Payée</option>
                        <option value="cancel"   {{ old('statut', $facture->statut) === 'cancel'   ? 'selected' : '' }}>Cancel</option>
                    </select>
                    @error('statut')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Fichier actuel</label>
                    <input type="text" class="form-control" value="{{ $facture->nom_fichier }}" readonly>
                </div>

                <div class="form-actions">
                    <a href="{{ route('bills') }}" class="btn-cancel">Annuler</a>
                    <button type="submit" class="btn-submit">Enregistrer les modifications</button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
