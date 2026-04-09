/**
 * modif_project.js — Validation du formulaire de modification d'un projet
 *
 * But : vérifier côté client que les champs obligatoires du formulaire
 * d'édition d'un projet existant sont remplis avant de soumettre
 * la mise à jour au serveur.
 *
 * Champs validés :
 *  - Nom du projet : non vide
 *  - Client        : un client doit être sélectionné
 */

// Vérifie que le champ nom du projet n'est pas vide
// Retourne 1 si erreur (affiche le message), 0 si valide (masque le message)
function check_project_name() {
    const project_name = document.querySelector('#nom_projet');
    console.log("Projet : " + project_name.value);
    const project_error = document.querySelector('#project_name_error');

    if (project_name.value.trim() === "") {
        project_error.classList.remove('titanic'); // Affiche le message d'erreur
        return 1;
    } else {
        project_error.classList.add('titanic'); // Masque le message d'erreur
        return 0;
    }
}

// Vérifie qu'un client est sélectionné dans le menu déroulant
function check_client() {
    const client_select = document.querySelector('#client');
    console.log("Client value : " + client_select.value);
    const client_error = document.querySelector('#client_error');

    if (client_select.value === "") {
        client_error.classList.remove('titanic');
        return 1;
    } else {
        client_error.classList.add('titanic');
        return 0;
    }
}

// Sélectionne le formulaire de modification du projet
const f = document.querySelector('#modif_project_form');

// À la soumission, on bloque l'envoi natif et on valide les champs
f.addEventListener("submit", function(event) {
    event.preventDefault();
    console.log("Tentative de modification du projet");

    // Cumule le nombre d'erreurs — chaque fonction retourne 1 si invalide, 0 si valide
    let nb_errors = 0;
    nb_errors += check_project_name();
    nb_errors += check_client();

    console.log("nb errors :" + nb_errors);

    // Si aucune erreur, on soumet réellement le formulaire vers le serveur
    if (nb_errors === 0) {
        f.submit();
    }
});
