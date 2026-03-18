<section>
    <header>
        <h2 style="color: #f8fafc; margin-top: 0; font-size: 20px;">
            Supprimer le compte
        </h2>
        <p style="color: #94a3b8; font-size: 14px; margin-top: 5px;">
            Une fois votre compte supprimé, toutes ses ressources et données seront effacées de manière permanente. Avant de supprimer votre compte, veuillez télécharger les données ou informations que vous souhaitez conserver.
        </p>
    </header>

    <button type="button" class="btn-supr" style="margin-top: 20px;" onclick="document.getElementById('modal-delete-account').style.opacity='1'; document.getElementById('modal-delete-account').style.visibility='visible';">
        Supprimer le compte
    </button>

    <div id="modal-delete-account" class="modal-overlay">
        <div class="modal-content">
            <a href="#" class="close-btn" onclick="event.preventDefault(); document.getElementById('modal-delete-account').style.opacity='0'; document.getElementById('modal-delete-account').style.visibility='hidden';">&times;</a>

            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="modal-header">
                    <h2 style="color: #f8fafc; margin: 0;">Êtes-vous sûr de vouloir supprimer votre compte ?</h2>
                </div>

                <div class="modal-body">
                    <p style="color: #cbd5e1; margin-bottom: 20px;">
                        Une fois votre compte supprimé, toutes vos données seront perdues. Veuillez entrer votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre compte.
                    </p>

                    <div class="form-group">
                        <label for="password">Mot de passe <span class="text-required">*</span></label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Votre mot de passe" required>
                        
                        @error('password', 'userDeletion')
                            <div class="error-text" style="margin-top: 10px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer" style="display: flex; justify-content: flex-end; gap: 15px;">
                    <button type="button" class="btn-cancel" onclick="document.getElementById('modal-delete-account').style.opacity='0'; document.getElementById('modal-delete-account').style.visibility='hidden';">
                        Annuler
                    </button>
                    <button type="submit" class="btn-supr" style="margin: 0;">
                        Confirmer la suppression
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>