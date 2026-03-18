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
                <input type="text" id="titre" name="titre" class="form-control" value="{{ old('titre') }}" placeholder="Ex: Erreur lors du paiement...">
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
                    <select id="projet_id" name="projet_id" class="form-control">
                        <option value="">-- Sélectionner un projet --</option>
                        <select name="projet_id" class="form-control">
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

            <div class="form-actions">
                <a href="{{ route('tickets.index') }}" class="btn-cancel">Annuler</a>
                <button type="submit" class="btn-submit">Créer le ticket</button>
            </div>
        </form>
        </div>

    </div>

    <script src="{{ asset('javascript/create_ticket.js') }}"></script>
</body>
</html>