@include('pages.user.partials.head')


<body>
    
    @include('pages.user.partials.header', ['active' => 'bills'])

    <div class="content_create"> <div class="form-card">
            <div class="form-header">
                <h1>Éditer une nouvelle facture</h1>
                <p>Remplissez les informations financières et joignez le document PDF.</p>
            </div>

            <form id="new_bill_form" action="bills.html">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="reference">Référence Facture <span class="text-required">*</span></label>
                        <input type="text" id="reference" name="reference" class="form-control" placeholder="Ex: FAC-2024-042">
                        <div id="reference_error" class="error-text titanic">Veuillez entrer une référence de facture.</div>
                    </div>

                    <div class="form-group">
                        <label for="client">Client facturé <span class="text-required">*</span></label>
                        <select id="client" name="client" class="form-control">
                            <option value="" disabled selected>-- Choisir un client --</option>
                            <option value="greenmarket">GreenMarket SAS</option>
                            <option value="dupond">Groupe Dupond</option>
                            <option value="fastdelivery">FastDelivery</option>
                        </select>
                        <div id="client_error" class="error-text titanic">Veuillez sélectionner un client.</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="date_facture">Date d'émission <span class="text-required">*</span></label>
                        <input type="date" id="date_facture" name="date_facture" class="form-control">
                        <div id="date_error" class="error-text titanic">Veuillez choisir une date.</div>
                    </div>

                    <div class="form-group">
                        <label for="montant">Montant HT (€) <span class="text-required">*</span></label>
                        <input type="number" id="montant" name="montant" class="form-control" placeholder="0.00" step="0.01">
                        <div id="montant_error" class="error-text titanic">Veuillez entrer un montant valide.</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="statut">Statut initial</label>
                    <select id="statut" name="statut" class="form-control">
                        <option value="draft">Brouillon</option>
                        <option value="sent" selected>Envoyée / En attente</option>
                        <option value="paid">Payée</option>
                        <option value="late">En retard</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Document original (PDF) <span class="text-required">*</span></label>
                    
                    <div class="file-upload-zone">
                        <input type="file" id="facture_pdf" name="facture_pdf" class="file-input" accept="application/pdf">
                        
                        <span class="upload-icon">📄</span>
                        <span class="upload-text">Cliquez pour déposer votre facture ou glissez le fichier ici</span>
                        <span class="upload-hint">PDF uniquement</span>
                    </div>
                    <div id="file_error" class="error-text titanic" style="margin-top: 10px;">Veuillez joindre le fichier PDF de la facture.</div>
                </div>

                <div class="form-actions">
                    <a href="{{ url('bills') }}" class="btn-cancel">Annuler</a>
                    <button type="submit" class="btn-submit">Enregistrer la facture</button>
                </div>

            </form>
        </div>

    </div>

    <script src="{{ asset('javascript/new_bills.js') }}"></script>
    
</body>
</html>