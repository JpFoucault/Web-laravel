@include('pages.user.partials.head')

<body>
    @include('pages.user.partials.header', ['active' => 'documents'])

    <div class="content">

        {{-- ===== SECTION DOCUMENTS ===== --}}
        <div class="page-actions">
            <h1>Documents</h1>
            <a href="{{ route('documents.create') }}" class="btn-create">+ Déposer un document</a>
        </div>

        <div class="filter-section" style="margin-bottom: 20px;">
            <p style="font-weight: 600; margin-bottom: 10px;">Filtrer par :</p>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 10px;">
                <button class="filter-btn btn-cancel" data-category="all">Tout voir</button>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <span style="align-self: center; font-size: 13px; color: #94a3b8;">État :</span>
                <button class="filter-btn btn-cancel" data-value="payee">Payée</button>
                <button class="filter-btn btn-cancel" data-value="en cours">En cours</button>
                <button class="filter-btn btn-cancel" data-value="cancel">Cancel</button>
            </div>
        </div>

        @if(session('success'))
            <p style="color: #4ade80; margin-bottom: 12px;">{{ session('success') }}</p>
        @endif

        <div class="table-card">
            <table class="ticket-table">
                <thead>
                    <tr>
                        <th>Nom du document</th>
                        <th>Fichier</th>
                        <th>État</th>
                        <th>Déposé le</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $document)
                        @php
                            // On choisit la classe CSS du badge selon le statut
                            $badgeClass = match($document->statut) {
                                'payee'    => 'status-done',
                                'cancel'   => 'status-cancel',
                                default    => 'status-progress',
                            };
                            $badgeLabel = match($document->statut) {
                                'payee'    => 'Payée',
                                'cancel'   => 'Cancel',
                                default    => 'En cours',
                            };
                        @endphp
                        <tr data-statut="{{ $document->statut }}">
                            <td><strong>{{ $document->nom_document }}</strong></td>
                            <td style="color: #94a3b8; font-size: 13px;">{{ $document->nom_fichier }}</td>
                            <td><span class="status-badge {{ $badgeClass }}">{{ $badgeLabel }}</span></td>
                            <td>{{ $document->created_at->format('d M Y') }}</td>
                            <td class="text-right">
                                <a href="{{ route('documents.download', $document) }}"
                                   class="btn-details" target="_blank">Télécharger</a>

                                <a href="{{ route('documents.edit', $document) }}"
                                   class="btn-details">Modifier</a>

                                <form method="POST" action="{{ route('documents.destroy', $document) }}"
                                      style="display: inline;"
                                      onsubmit="return confirm('Supprimer ce document ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon" title="Supprimer">x</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #94a3b8; padding: 30px;">
                                Aucun document déposé pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <script src="{{ asset('javascript/filter_bills.js') }}"></script>

</body>
</html>
