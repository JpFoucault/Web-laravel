/**
 * new_bills.js — Validation du formulaire de création d'une facture
 *
 * But : vérifier côté client que tous les champs obligatoires du formulaire
 * de dépôt d'une nouvelle facture sont remplis avant de soumettre au serveur.
 *
 * Champs validés :
 *  - Référence : non vide
 *  - Client    : un client doit être sélectionné
 *  - Date      : une date doit être renseignée
 *  - Montant   : un montant doit être renseigné
 *  - Fichier   : un fichier PDF doit être sélectionné
 */

// Vérifie que le champ référence de la facture n'est pas vide
// Retourne 1 si erreur (affiche le message), 0 si valide (masque le message)
function check_reference() {
    const reference_input = document.querySelector('#reference');
    const reference_error = document.querySelector('#reference_error');

    if (reference_input.value.trim() === "") {
        reference_error.classList.remove('titanic'); // Affiche le message d'erreur
        return 1;
    } else {
        reference_error.classList.add('titanic'); // Masque le message d'erreur
        return 0;
    }
}

// Vérifie qu'un client est sélectionné dans le menu déroulant
function check_client() {
    const client_select = document.querySelector('#client');
    const client_error = document.querySelector('#client_error');

    if (client_select.value === "") {
        client_error.classList.remove('titanic');
        return 1;
    } else {
        client_error.classList.add('titanic');
        return 0;
    }
}

// Vérifie qu'une date de facture est renseignée
function check_date() {
    const date_input = document.querySelector('#date_facture');
    const date_error = document.querySelector('#date_error');

    if (date_input.value === "") {
        date_error.classList.remove('titanic');
        return 1;
    } else {
        date_error.classList.add('titanic');
        return 0;
    }
}

// Vérifie qu'un montant est renseigné
function check_montant() {
    const montant_input = document.querySelector('#montant');
    const montant_error = document.querySelector('#montant_error');

    if (montant_input.value === "") {
        montant_error.classList.remove('titanic');
        return 1;
    } else {
        montant_error.classList.add('titanic');
        return 0;
    }
}

// Vérifie qu'un fichier PDF a bien été sélectionné dans l'input file
function check_file() {
    const file_input = document.querySelector('#facture_pdf');
    const file_error = document.querySelector('#file_error');

    console.log("Fichier sélectionné : " + file_input.value);

    if (file_input.value === "") {
        file_error.classList.remove('titanic');
        return 1;
    } else {
        file_error.classList.add('titanic');
        return 0;
    }
}

// Sélectionne le formulaire de création de facture
const f = document.querySelector('#new_bill_form');

// À la soumission, on bloque l'envoi natif et on valide tous les champs
f.addEventListener("submit", function(event) {
    event.preventDefault();
    console.log("Tentative de création de facture");

    // Cumule le nombre d'erreurs — chaque fonction retourne 1 si invalide, 0 si valide
    let nb_errors = 0;
    nb_errors += check_reference();
    nb_errors += check_client();
    nb_errors += check_date();
    nb_errors += check_montant();
    nb_errors += check_file();

    console.log("nb errors :" + nb_errors);

    // Si aucune erreur, on soumet réellement le formulaire vers le serveur
    if (nb_errors === 0) {
        f.submit();
    }
});
