/**
 * filter_bills.js — Filtrage dynamique des factures par statut (version avancée)
 *
 * But : permettre à l'utilisateur de filtrer les lignes du tableau de factures
 * en cliquant sur les boutons de filtre (Tout voir, Payée, En cours, Cancel),
 * sans rechargement de page. Gère également l'état visuel "actif" des boutons.
 *
 * Fonctionnement :
 *  1. On maintient un objet `activeFilters` qui stocke le filtre de statut actif.
 *  2. Au clic sur un bouton, on met à jour le filtre et l'état actif visuel.
 *  3. La fonction `filterBills` parcourt les lignes et les affiche/masque
 *     selon que le badge de statut correspond au filtre actif.
 *  4. Le bouton "Tout voir" réinitialise tous les filtres et réaffiche tout.
 */

// Sélectionne tous les boutons de filtre présents dans la section de filtrage
const filterButtons = document.querySelectorAll(".filter-btn");

// Objet qui stocke les filtres actifs — null signifie "aucun filtre" (tout afficher)
let activeFilters = {
    status: null
};

// Retire la classe "active" de tous les boutons de filtre (réinitialisation visuelle)
function resetActiveButtons() {
    filterButtons.forEach(btn => btn.classList.remove('active'));
}

// Affiche ou masque chaque ligne du tableau selon le filtre de statut actif
function filterBills() {
    // Cible toutes les lignes à l'intérieur du tbody identifié par #bill-rows
    const rows = document.querySelectorAll('#bill-rows tr');

    rows.forEach(row => {
        let showRow = true; // Par défaut, on affiche la ligne

        if (activeFilters.status) {
            // Récupère le badge de statut dans la 5e colonne de la ligne
            const statusBadge = row.querySelector('td:nth-child(5) .status-badge');
            if (statusBadge) {
                const statusText = statusBadge.innerText.trim();
                // Si le texte du badge ne correspond pas au filtre, on cache la ligne
                if (statusText !== activeFilters.status) {
                    showRow = false;
                }
            }
        }

        // Utilise la classe "titanic" pour masquer (remove = visible, add = masqué)
        if (showRow) {
            row.classList.remove('titanic');
        } else {
            row.classList.add('titanic');
        }
    });
}

// Attache un écouteur de clic à chaque bouton de filtre
filterButtons.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();

        const category = this.getAttribute('data-category'); // "all" ou "status"
        const value = this.getAttribute('data-value');       // ex: "Payée", "En cours"

        // Cas du bouton "Tout voir" : réinitialise tous les filtres
        if (category === 'all') {
            activeFilters.status = null;
            resetActiveButtons();
            this.classList.add('active'); // Marque ce bouton comme actif
            filterBills();
            return;
        }

        // Pour tout autre filtre, on retire "actif" du bouton "Tout voir"
        const allButton = document.querySelector('[data-category="all"]');
        if (allButton) allButton.classList.remove('active');

        if (category === 'status') {
            // Si on clique sur le filtre déjà actif, on le désactive (bascule)
            if (activeFilters.status === value && this.classList.contains('active')) {
                activeFilters.status = null;
                this.classList.remove('active');
            } else {
                // Sinon, on retire "actif" de tous les boutons de statut
                // et on active uniquement celui qui vient d'être cliqué
                document.querySelectorAll('[data-category="status"]').forEach(btn => {
                    btn.classList.remove('active');
                });
                activeFilters.status = value;
                this.classList.add('active');
            }
        }

        // Relance le filtrage avec les nouveaux filtres actifs
        filterBills();
    });
});
