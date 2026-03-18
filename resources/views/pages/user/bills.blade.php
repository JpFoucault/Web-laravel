@include('pages.user.partials.head')

<body>
    @include('pages.user.partials.header', ['active' => 'bills'])

    <div class="content">
        <div class="page-actions">
            <h1>Factures & Devis</h1>
            <a href="{{ url('new_bills') }}" class="btn-create">+ Nouvelle Facture</a>
        </div>

        <div class="filter-section" style="margin-bottom: 20px;">
            <p style="font-weight: 600; margin-bottom: 10px;">Filtrer par :</p>
            
            <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 10px;">
                <button class="filter-btn btn-cancel" data-category="all">Tout voir</button>
            </div>

            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <span style="align-self: center; font-size: 13px; color: #94a3b8;">État :</span>
                <button class="filter-btn btn-cancel" data-category="status" data-value="Payée">Payée</button>
                <button class="filter-btn btn-cancel" data-category="status" data-value="in progress">En cours</button>
                <button class="filter-btn btn-cancel" data-category="status" data-value="Cancel">Cancel</button>
            </div>
        </div>

        <div class="table-card">
            <table class="ticket-table">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Montant HT</th>
                        <th>Statut</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="bill-rows">
                    <tr>
                        <td><strong>FAC-2024-001</strong></td>
                        <td>GreenMarket SAS</td>
                        <td>15 Jan 2024</td>
                        <td>1 250,00 €</td>
                        <td><span class="status-badge status-done">Payée</span></td>
                        <td class="text-right">
                            <a href="#" class="btn-details">Télécharger</a>
                            <a href="#" class="btn-icon" title="Supprimer">&times;</a>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>FAC-2024-002</strong></td>
                        <td>Groupe Dupond</td>
                        <td>28 Jan 2024</td>
                        <td>840,00 €</td>
                        <td><span class="status-badge status-cancel">Cancel</span></td>
                        <td class="text-right">
                            <a href="#" class="btn-details">Télécharger</a>
                            <a href="#" class="btn-icon" title="Supprimer">&times;</a>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>FAC-2024-002</strong></td>
                        <td>Groupe Dupond</td>
                        <td>28 Jan 2024</td>
                        <td>840,00 €</td>
                        <td><span class="status-badge status-progress">in progress</span></td>
                        <td class="text-right">
                            <a href="#" class="btn-details">Télécharger</a>
                            <a href="#" class="btn-icon" title="Supprimer">&times;</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="{{ asset('javascript/filter_bills.js') }}"></script>

</body>
</html>