/**
 * forget_password.js — Validation du formulaire "Mot de passe oublié"
 *
 * But : vérifier que l'email saisi est valide avant d'envoyer la demande
 * de réinitialisation de mot de passe au serveur.
 * Si l'email est valide, le formulaire est soumis ; sinon, le message
 * d'erreur est affiché (retrait de la classe "titanic").
 */

// Vérifie qu'un email respecte le format standard (ex: user@domain.com)
function verifierEmail(email) {
    const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return regex.test(email);
}

// Vérifie que le champ email contient un email valide
// Retourne 1 si erreur (affiche le message), 0 si valide (masque le message)
function check_email() {
    const email_input = document.querySelector('#email_input');
    console.log(email_input.value);
    const titre_error = document.querySelector('#email_error');

    if (!verifierEmail(email_input.value)) {
        titre_error.classList.remove('titanic'); // Affiche le message d'erreur
        return 1;
    } else {
        titre_error.classList.add('titanic'); // Masque le message d'erreur
        return 0;
    }
}

// Sélectionne le formulaire de mot de passe oublié
const f = document.querySelector('#forget_password_form');

// À la soumission, on bloque l'envoi natif et on valide l'email
f.addEventListener("submit", function(event) {
    event.preventDefault();
    console.log("Soumission de mot de passe oublié");

    let nb_errors = 0;
    nb_errors += check_email();

    console.log("nb errors :" + nb_errors);

    // Si aucune erreur, on soumet réellement le formulaire vers le serveur
    if (nb_errors === 0) {
        f.submit();
    }
});
