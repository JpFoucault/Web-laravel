/**
 * create_account.js — Validation du formulaire de création de compte
 *
 * But : vérifier côté client que tous les champs du formulaire d'inscription
 * sont correctement remplis avant de soumettre la requête au serveur.
 * Les erreurs sont affichées/masquées via la classe CSS "titanic" (= masqué).
 *
 * Champs validés :
 *  - Prénom        : non vide
 *  - Nom de famille : non vide
 *  - Email         : format valide (regex)
 *  - Mot de passe  : 7-20 caractères, au moins une majuscule et un chiffre
 */

// Vérifie que le champ prénom n'est pas vide
// Retourne 1 si erreur (affiche le message), 0 si valide (masque le message)
function check_account_first_name()
{
    const account_first_name = document.querySelector('#account_first_name');
    console.log(account_first_name.value);
    const titre_error = document.querySelector('#client_first_name_error');

    if(account_first_name.value == "")
    {
        titre_error.classList.remove('titanic'); // Affiche le message d'erreur
        return 1;
    } else{
        titre_error.classList.add('titanic'); // Masque le message d'erreur
        return 0;
    }
}

// Vérifie que le champ nom de famille n'est pas vide
function check_account_family_name()
{
    const account_family_name = document.querySelector('#account_family_name');
    console.log(account_family_name.value);
    const titre_error = document.querySelector('#client_family_name_error');

    if(account_family_name.value == "")
    {
        titre_error.classList.remove('titanic');
        return 1;
    } else{
        titre_error.classList.add('titanic');
        return 0;
    }
}

// Vérifie qu'un email respecte le format standard (ex: user@domain.com)
function verifierEmail(email) {
    const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    return regex.test(email);
}

// Vérifie que le champ email contient un email valide
function check_account_email()
{
    const account_email = document.querySelector('#account_email');
    console.log(account_email.value);
    const titre_error = document.querySelector('#client_email_error');

    if(!verifierEmail(account_email.value))
    {
        titre_error.classList.remove('titanic');
        return 1;
    } else{
        titre_error.classList.add('titanic');
        return 0;
    }
}

// Vérifie que le mot de passe fait entre 7 et 20 caractères,
// contient au moins une majuscule et au moins un chiffre
function verifierMotDePasse(mdp) {
    const regex = /^(?=.*[A-Z])(?=.*\d).{7,20}$/;

    return regex.test(mdp);
}

// Vérifie que le champ mot de passe respecte les règles de sécurité
function check_account_password()
{
    const account_password = document.querySelector('#account_password');
    console.log(account_password.value);
    const titre_error = document.querySelector('#password_error');

    if(!verifierMotDePasse(account_password.value))
    {
        titre_error.classList.remove('titanic');
        return 1;
    } else{
        titre_error.classList.add('titanic');
        return 0;
    }
}

// Sélectionne le formulaire de création de compte
const f = document.querySelector('#create_account_form');

// À la soumission, on bloque l'envoi natif et on lance toutes les validations
f.addEventListener("submit", function(event) {
    event.preventDefault();
    console.log("Soumission de la creation du compte");

    // Cumule le nombre d'erreurs — chaque fonction retourne 1 si invalide, 0 si valide
    let nb_errors = 0;
    nb_errors += check_account_first_name();
    nb_errors += check_account_family_name();
    nb_errors += check_account_email();
    nb_errors += check_account_password();

    console.log("nb errors :" + nb_errors);
    // Note : la soumission réelle n'est pas encore déclenchée ici si des erreurs sont présentes
});
