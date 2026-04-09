/**
 * modif_ticket.js — Validation du formulaire de modification d'un ticket
 *
 * But : vérifier côté client que tous les champs obligatoires du formulaire
 * d'édition d'un ticket existant sont remplis avant de soumettre
 * la mise à jour au serveur.
 *
 * Champs validés :
 *  - Titre       : non vide
 *  - Projet      : un projet doit être sélectionné
 *  - Description : non vide
 */

// Vérifie que le champ titre du ticket n'est pas vide
// Retourne 1 si erreur (affiche le message), 0 si valide (masque le message)
function check_titre() {
    const titre_input = document.querySelector('#titre');
    console.log("Titre ticket : " + titre_input.value);
    const titre_error = document.querySelector('#titre_error');

    if (titre_input.value.trim() === "") {
        titre_error.classList.remove('titanic'); // Affiche le message d'erreur
        return 1;
    } else {
        titre_error.classList.add('titanic'); // Masque le message d'erreur
        return 0;
    }
}

// Vérifie qu'un projet est sélectionné dans le menu déroulant
function check_projet() {
    const projet_select = document.querySelector('#projet');
    console.log("Projet sélectionné : " + projet_select.value);
    const projet_error = document.querySelector('#projet_error');

    if (projet_select.value === "") {
        projet_error.classList.remove('titanic');
        return 1;
    } else {
        projet_error.classList.add('titanic');
        return 0;
    }
}

// Vérifie que le champ description n'est pas vide
function check_description() {
    const description_input = document.querySelector('#description');
    const description_error = document.querySelector('#description_error');

    if (description_input.value.trim() === "") {
        description_error.classList.remove('titanic');
        return 1;
    } else {
        description_error.classList.add('titanic');
        return 0;
    }
}

// Sélectionne le formulaire de modification du ticket
const f = document.querySelector('#modif_ticket_form');

// À la soumission, on bloque l'envoi natif et on valide tous les champs
f.addEventListener("submit", function(event) {
    event.preventDefault();
    console.log("Tentative de modification de ticket");

    // Cumule le nombre d'erreurs — chaque fonction retourne 1 si invalide, 0 si valide
    let nb_errors = 0;
    nb_errors += check_titre();
    nb_errors += check_projet();
    nb_errors += check_description();

    console.log("nb errors :" + nb_errors);

    // Si aucune erreur, on soumet réellement le formulaire vers le serveur
    if (nb_errors === 0) {
        f.submit();
    }
});
