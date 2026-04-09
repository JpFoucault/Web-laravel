/**
 * new_documents.js — Validation du formulaire d'import d'un document
 *
 * But : vérifier côté client que tous les champs obligatoires du formulaire
 * d'upload d'un nouveau document sont remplis avant de soumettre au serveur.
 *
 * Champs validés :
 *  - Fichier   : un fichier doit être sélectionné
 *  - Nom       : un nom de document doit être renseigné
 *  - Catégorie : une catégorie doit être sélectionnée
 */

// Vérifie qu'un fichier a bien été sélectionné dans l'input file
// Retourne 1 si erreur (affiche le message), 0 si valide (masque le message)
function check_file() {
    const file_input = document.querySelector('#document_file');
    const file_error = document.querySelector('#file_error');

    console.log("Fichier sélectionné : " + file_input.value);

    if (file_input.value === "") {
        file_error.classList.remove('titanic'); // Affiche le message d'erreur
        return 1;
    } else {
        file_error.classList.add('titanic'); // Masque le message d'erreur
        return 0;
    }
}

// Vérifie que le champ nom du document n'est pas vide
function check_name() {
    const name_input = document.querySelector('#doc_name');
    const name_error = document.querySelector('#name_error');

    if (name_input.value.trim() === "") {
        name_error.classList.remove('titanic');
        return 1;
    } else {
        name_error.classList.add('titanic');
        return 0;
    }
}

// Vérifie qu'une catégorie est sélectionnée dans le menu déroulant
function check_category() {
    const category_select = document.querySelector('#category');
    const category_error = document.querySelector('#category_error');

    if (category_select.value === "") {
        category_error.classList.remove('titanic');
        return 1;
    } else {
        category_error.classList.add('titanic');
        return 0;
    }
}

// Sélectionne le formulaire d'import de document
const f = document.querySelector('#new_document_form');

// À la soumission, on bloque l'envoi natif et on valide tous les champs
f.addEventListener("submit", function(event) {
    event.preventDefault();
    console.log("Tentative d'import de document");

    // Cumule le nombre d'erreurs — chaque fonction retourne 1 si invalide, 0 si valide
    let nb_errors = 0;
    nb_errors += check_file();
    nb_errors += check_name();
    nb_errors += check_category();

    console.log("nb errors :" + nb_errors);

    // Si aucune erreur, on soumet réellement le formulaire vers le serveur
    if (nb_errors === 0) {
        f.submit();
    }
});
