/**
 * modif_contacts.js — Validation du formulaire de modification d'un contact
 *
 * But : vérifier côté client que tous les champs du formulaire d'édition
 * d'un contact existant sont correctement remplis avant de soumettre
 * la mise à jour au serveur.
 *
 * Champs validés :
 *  - Prénom     : non vide
 *  - Nom        : non vide
 *  - Poste      : non vide
 *  - Entreprise : une entreprise doit être sélectionnée
 *  - Email      : format valide (regex)
 */

// Vérifie que le champ prénom n'est pas vide
// Retourne 1 si erreur (affiche le message), 0 si valide (masque le message)
function check_prenom() {
    const prenom_input = document.querySelector('#prenom');
    const prenom_error = document.querySelector('#prenom_error');

    if (prenom_input.value.trim() === "") {
        prenom_error.classList.remove('titanic'); // Affiche le message d'erreur
        return 1;
    } else {
        prenom_error.classList.add('titanic'); // Masque le message d'erreur
        return 0;
    }
}

// Vérifie que le champ nom n'est pas vide
function check_nom() {
    const nom_input = document.querySelector('#nom');
    const nom_error = document.querySelector('#nom_error');

    if (nom_input.value.trim() === "") {
        nom_error.classList.remove('titanic');
        return 1;
    } else {
        nom_error.classList.add('titanic');
        return 0;
    }
}

// Vérifie que le champ poste n'est pas vide
function check_poste() {
    const poste_input = document.querySelector('#poste');
    const poste_error = document.querySelector('#poste_error');

    if (poste_input.value.trim() === "") {
        poste_error.classList.remove('titanic');
        return 1;
    } else {
        poste_error.classList.add('titanic');
        return 0;
    }
}

// Vérifie qu'une entreprise est sélectionnée dans le menu déroulant
function check_entreprise() {
    const entreprise_select = document.querySelector('#entreprise');
    const entreprise_error = document.querySelector('#entreprise_error');

    if (entreprise_select.value === "") {
        entreprise_error.classList.remove('titanic');
        return 1;
    } else {
        entreprise_error.classList.add('titanic');
        return 0;
    }
}

// Vérifie qu'un email respecte le format standard (ex: user@domain.com)
function verifierEmail(email) {
    const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return regex.test(email);
}

// Vérifie que le champ email contient un email valide
function check_email() {
    const email_input = document.querySelector('#email');
    const email_error = document.querySelector('#email_error');

    if (!verifierEmail(email_input.value)) {
        email_error.classList.remove('titanic');
        return 1;
    } else {
        email_error.classList.add('titanic');
        return 0;
    }
}

// Sélectionne le formulaire de modification de contact
const f = document.querySelector('#modif_contact_form');

// À la soumission, on bloque l'envoi natif et on valide tous les champs
f.addEventListener("submit", function(event) {
    event.preventDefault();
    console.log("Tentative de modification de contact");

    // Cumule le nombre d'erreurs — chaque fonction retourne 1 si invalide, 0 si valide
    let nb_errors = 0;
    nb_errors += check_prenom();
    nb_errors += check_nom();
    nb_errors += check_poste();
    nb_errors += check_entreprise();
    nb_errors += check_email();

    console.log("nb errors :" + nb_errors);

    // Si aucune erreur, on soumet réellement le formulaire vers le serveur
    if (nb_errors === 0) {
        f.submit();
    }
});
