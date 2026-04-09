/**
 * login.js — Validation du formulaire de connexion
 *
 * But : vérifier côté client que l'email et le mot de passe sont renseignés
 * avant d'envoyer la requête d'authentification au serveur.
 * Si les deux champs sont valides, le formulaire est soumis.
 */

// Vérifie qu'un email respecte le format standard (ex: user@domain.com)
function verifierEmail(email) {
    const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return regex.test(email);
}

// Vérifie que le champ email (identifiant) contient un email valide
// Retourne 1 si erreur (affiche le message), 0 si valide (masque le message)
function check_username() {
    const username_input = document.querySelector('#username');
    console.log("Username: " + username_input.value);
    const username_error = document.querySelector('#username_error');

    if (!verifierEmail(username_input.value)) {
        username_error.classList.remove('titanic'); // Affiche le message d'erreur
        return 1;
    } else {
        username_error.classList.add('titanic'); // Masque le message d'erreur
        return 0;
    }
}

// Vérifie que le champ mot de passe n'est pas vide
function check_password() {
    const password_input = document.querySelector('#password');
    const password_error = document.querySelector('#password_error');

    if (password_input.value === "") {
        password_error.classList.remove('titanic'); // Affiche le message d'erreur
        return 1;
    } else {
        password_error.classList.add('titanic'); // Masque le message d'erreur
        return 0;
    }
}

// Sélectionne le formulaire de connexion
const f = document.querySelector('#login_form');

// À la soumission, on bloque l'envoi natif et on valide les deux champs
f.addEventListener("submit", function(event) {
    event.preventDefault();
    console.log("Tentative de connexion");

    let nb_errors = 0;
    nb_errors += check_username();
    nb_errors += check_password();

    console.log("nb errors :" + nb_errors);

    // Si aucune erreur, on soumet réellement le formulaire vers le serveur
    if (nb_errors === 0) {
        f.submit();
    }
});
