@include('pages.user.partials.head')

<body>
    @include('pages.user.partials.header', ['active' => 'contacts'])

    <div class="content_contact">

        <div class="page-actions">
            <h1>Répertoire Contacts</h1>
            <a href="{{ route('contacts.create') }}" class="btn-create">+ Nouveau Contact</a>
        </div>

        <div class="table-card">
            <table class="contact-table">
                <thead>
                    <tr>
                        <th>Nom & Prénom</th>
                        <th>Poste / Rôle</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Entreprise</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        // Couleurs disponibles pour les avatars, on les fait tourner
                        $couleurs = ['av-yellow', 'av-blue', 'av-green', 'av-purple', 'av-pink'];
                    @endphp

                    @forelse($contacts as $contact)
                        @php
                            // Initiales = 1ère lettre du prénom + 1ère lettre du nom
                            $initiales = strtoupper(substr($contact->prenom, 0, 1) . substr($contact->nom, 0, 1));
                            // On choisit une couleur selon la position du contact
                            $couleur = $couleurs[$loop->index % count($couleurs)];
                        @endphp
                        <tr>
                            <td>
                                <div class="contact-name-cell">
                                    <div class="avatar {{ $couleur }}">{{ $initiales }}</div>
                                    <span>{{ $contact->prenom }} {{ $contact->nom }}</span>
                                </div>
                            </td>
                            <td class="job-title">{{ $contact->poste }}</td>
                            <td>{{ $contact->telephone ?? '—' }}</td>
                            <td>{{ $contact->email }}</td>
                            <td><span class="company-badge">{{ $contact->entreprise }}</span></td>
                            <td class="text-right">
                                <a href="#popup-{{ $contact->id }}" class="btn-view">Voir fiche</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #94a3b8; padding: 30px;">
                                Aucun contact pour le moment.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>

    {{-- On génère une popup pour chaque contact --}}
    @foreach($contacts as $contact)
        @php
            $initiales = strtoupper(substr($contact->prenom, 0, 1) . substr($contact->nom, 0, 1));
            $couleur = $couleurs[$loop->index % count($couleurs)];
        @endphp
        <div id="popup-{{ $contact->id }}" class="modal-overlay">
            <div class="modal-content">

                <a href="#" class="close-btn">&times;</a>

                <div class="contact-header">
                    <div class="avatar {{ $couleur }}">{{ $initiales }}</div>
                    <div class="contact-title">
                        <h2>{{ $contact->prenom }} {{ $contact->nom }}</h2>
                        <p>{{ $contact->poste }} chez <strong>{{ $contact->entreprise }}</strong></p>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="contact-grid">
                        <div class="contact-item">
                            <span class="ci-label">Téléphone</span>
                            <span class="ci-value">{{ $contact->telephone ?? '—' }}</span>
                        </div>
                        <div class="contact-item">
                            <span class="ci-label">Email</span>
                            <span class="ci-value">
                                <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                            </span>
                        </div>
                        <div class="contact-item">
                            <span class="ci-label">Poste</span>
                            <span class="ci-value">{{ $contact->poste }}</span>
                        </div>
                        <div class="contact-item">
                            <span class="ci-label">Entreprise</span>
                            <span class="ci-value">{{ $contact->entreprise }}</span>
                        </div>
                    </div>

                    @if($contact->notes)
                        <p class="info-label">Notes internes & Description :</p>
                        <div class="description-box">{{ $contact->notes }}</div>
                    @endif
                </div>

                <div class="modal-footer" style="display: flex; justify-content: space-between;">
                    <a href="{{ route('contacts.edit', $contact) }}" class="btn-edit-contact">Modifier le contact</a>

                    {{-- Formulaire de suppression --}}
                    <form method="POST" action="{{ route('contacts.destroy', $contact) }}" onsubmit="return confirm('Supprimer ce contact ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-supr">Supprimer le contact</button>
                    </form>

                    <a href="#" class="btn-modal-action" style="background-color: #334155; border: 1px solid #475569;">Fermer</a>
                </div>

            </div>
        </div>
    @endforeach

</body>
</html>
