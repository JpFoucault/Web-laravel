@include('pages.user.partials.head')

<body>

    @include('pages.user.partials.header', ['active' => 'documents'])

    <div class="content_create">
        <div class="form-card">
            <div class="form-header">
                <h1>Déposer un document</h1>
                <p>Ajoutez un fichier de document. Il sera uniquement visible par vous.</p>
            </div>

            {{-- enctype="multipart/form-data" est obligatoire pour envoyer des fichiers --}}
            <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nom_document">Nom du document <span class="text-required">*</span></label>
                    <input type="text" id="nom_document" name="nom_document" class="form-control"
                           placeholder="Ex: Rapport annuel 2025" value="{{ old('nom_document') }}" required>
                    @error('nom_document')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="statut">État <span class="text-required">*</span></label>
                    <select id="statut" name="statut" class="form-control" required>
                        <option value="en cours" {{ old('statut') === 'en cours' ? 'selected' : '' }}>En cours</option>
                        <option value="payee"    {{ old('statut') === 'payee'    ? 'selected' : '' }}>Payée</option>
                        <option value="cancel"   {{ old('statut') === 'cancel'   ? 'selected' : '' }}>Cancel</option>
                    </select>
                    @error('statut')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Fichier <span class="text-required">*</span></label>
                    <div class="file-upload-zone">
                        <input type="file" id="fichier" name="fichier" class="file-input"
                               accept=".pdf,.doc,.docx" required>
                        <span class="upload-icon">📄</span>
                        <span class="upload-text">Cliquez pour déposer votre fichier ou glissez-le ici</span>
                        <span class="upload-hint">PDF, DOC, DOCX — max 10 Mo</span>
                    </div>
                    @error('fichier')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('documents.index') }}" class="btn-cancel">Annuler</a>
                    <button type="submit" class="btn-submit">Déposer le document</button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
