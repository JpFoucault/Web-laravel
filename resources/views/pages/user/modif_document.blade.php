@include('pages.user.partials.head')

<body>

    @include('pages.user.partials.header', ['active' => 'documents'])

    <div class="content_create">
        <div class="form-card">
            <div class="form-header">
                <h1>Modifier un document</h1>
                <p>Vous pouvez changer le nom et l'état du document. Le fichier ne peut pas être remplacé.</p>
            </div>

            <form method="POST" action="{{ route('documents.update', $document) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nom_document">Nom du document <span class="text-required">*</span></label>
                    <input type="text" id="nom_document" name="nom_document" class="form-control"
                           value="{{ old('nom_document', $document->nom_document) }}" required>
                    @error('nom_document')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="statut">État <span class="text-required">*</span></label>
                    <select id="statut" name="statut" class="form-control" required>
                        <option value="en cours" {{ old('statut', $document->statut) === 'en cours' ? 'selected' : '' }}>En cours</option>
                        <option value="payee"    {{ old('statut', $document->statut) === 'payee'    ? 'selected' : '' }}>Payée</option>
                        <option value="cancel"   {{ old('statut', $document->statut) === 'cancel'   ? 'selected' : '' }}>Cancel</option>
                    </select>
                    @error('statut')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Fichier actuel</label>
                    <input type="text" class="form-control" value="{{ $document->nom_fichier }}" readonly>
                </div>

                <div class="form-actions">
                    <a href="{{ route('documents.index') }}" class="btn-cancel">Annuler</a>
                    <button type="submit" class="btn-submit">Enregistrer les modifications</button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
