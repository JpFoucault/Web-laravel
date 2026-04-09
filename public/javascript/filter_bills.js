/**
 * filter_bills.js — Filtrage dynamique des factures par statut
 *
 * But : permettre à l'utilisateur de filtrer les lignes du tableau de factures
 * (page "Mes Factures") en cliquant sur les boutons de filtre (Tout voir,
 * Payée, En cours, Cancel), sans rechargement de page.
 *
 * Fonctionnement :
 *  1. On sélectionne tous les boutons de filtre et toutes les lignes du tableau.
 *  2. Au clic sur un bouton, on lit la valeur du filtre (data-value).
 *  3. On parcourt chaque ligne et on la masque ou affiche selon que son
 *     attribut data-statut correspond au filtre sélectionné.
 *  4. Le bouton "Tout voir" (sans data-value) réaffiche toutes les lignes.
 */

// Sélectionne tous les boutons de filtre présents dans la section de filtrage
const filterBtns = document.querySelectorAll('.filter-btn');

// Sélectionne toutes les lignes du tableau qui possèdent un attribut data-statut
// (chaque ligne correspond à une facture avec son statut : "payee", "en cours", "cancel")
const rows = document.querySelectorAll('tr[data-statut]');

// On attache un écouteur de clic à chaque bouton de filtre
filterBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
        // Récupère la valeur du filtre depuis l'attribut data-value du bouton
        // ex: "payee", "en cours", "cancel" — ou undefined pour "Tout voir"
        const valeur = btn.dataset.value;

        // Pour chaque ligne de facture, on décide de l'afficher ou de la masquer
        rows.forEach(function(row) {
            if (!valeur) {
                // Bouton "Tout voir" (pas de data-value) : on réaffiche toutes les lignes
                row.style.display = '';
            } else {
                // On affiche la ligne uniquement si son statut correspond au filtre choisi
                row.style.display = (row.dataset.statut === valeur) ? '' : 'none';
            }
        });
    });
});
