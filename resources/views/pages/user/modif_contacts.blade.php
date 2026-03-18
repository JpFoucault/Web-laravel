@include('pages.user.partials.head')


<body>
    
    @include('pages.user.partials.header', ['active' => 'contacts'])

    <div class="content_create"> <div class="form-card">
            <div class="form-header">
                <h1>Modifier un contact</h1>
                <p>Modifier la fiche d'un client, un collaborateur ou un partenaire.</p>
            </div>

            <form id="modif_contact_form" action="contacts.html">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="prenom">Prénom <span class="text-required">*</span></label>
                        <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Ex: Jean">
                        <div id="prenom_error" class="error-text titanic">Veuillez entrer un prénom.</div>
                    </div>

                    <div class="form-group">
                        <label for="nom">Nom <span class="text-required">*</span></label>
                        <input type="text" id="nom" name="nom" class="form-control" placeholder="Ex: Dupont">
                        <div id="nom_error" class="error-text titanic">Veuillez entrer un nom.</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="poste">Poste / Fonction <span class="text-required">*</span></label>
                        <input type="text" id="poste" name="poste" class="form-control" placeholder="Ex: Chef de projet, CTO...">
                        <div id="poste_error" class="error-text titanic">Veuillez indiquer le poste.</div>
                    </div>

                    <div class="form-group">
                        <label for="entreprise">Entreprise rattachée <span class="text-required">*</span></label>
                        <select id="entreprise" name="entreprise" class="form-control">
                            <option value="" disabled selected>-- Choisir une structure --</option>
                            <option value="greenmarket">GreenMarket SAS</option>
                            <option value="dupond">Groupe Dupond</option>
                        </select>
                        <div id="entreprise_error" class="error-text titanic">Veuillez sélectionner une entreprise.</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Adresse Email <span class="text-required">*</span></label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="jean.dupont@exemple.com">
                        <div id="email_error" class="error-text titanic">Veuillez entrer un email valide.</div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Numéro de téléphone</label>
                        <input type="tel" id="phone" name="phone" class="form-control" placeholder="06 12 34 56 78">
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Notes internes (Optionnel)</label>
                    <textarea id="notes" name="notes" class="form-control" placeholder="Informations complémentaires, disponibilités, etc." style="min-height: 80px;"></textarea>
                </div>

                <div class="form-actions">
                    <a href="{{ url('contacts') }}" class="btn-cancel">Annuler</a>
                    <button type="submit" class="btn-submit">Modifier le contact</button>
                </div>

            </form>
        </div>

    </div>

    <script src="{{ asset('javascript/modif_contacts.js') }}"></script>
</body>
</html>