/**
 * filter_tickets.js — Filtrage dynamique des tickets par statut
 *
 * But : permettre à l'utilisateur de filtrer les cartes de tickets
 * en cliquant sur les boutons de filtre (Tous, et par statut),
 * sans rechargement de page. Gère aussi l'état visuel "actif" des boutons.
 *
 * Fonctionnement :
 *  1. On maintient un objet `activeFilters` qui stocke le filtre de statut actif.
 *  2. Au clic sur un bouton, on met à jour le filtre et l'état actif visuel.
 *  3. La fonction `filterTickets` parcourt les cartes et les affiche/masque
 *     selon que leur attribut data-status correspond au filtre actif.
 *  4. Le bouton "Tous" réinitialise le filtre et réaffiche toutes les cartes.
 */

// Sélectionne tous les boutons de filtre présents dans la section de filtrage
const filterButtons = document.querySelectorAll(".filter-btn");

// Objet qui stocke les filtres actifs — null signifie "aucun filtre" (tout afficher)
let activeFilters = {
    status: null
};

// Affiche ou masque chaque carte de ticket selon le filtre de statut actif
function filterTickets() {
    // Cible les cartes de tickets (chaque ticket est affiché sous forme de carte)
    const cards = document.querySelectorAll('.ticket-card');

    cards.forEach(card => {
        let showCard = true; // Par défaut, on affiche la carte

        if (activeFilters.status) {
            // Récupère le statut du ticket depuis l'attribut data-status de la carte
            const cardStatus = card.getAttribute('data-status');
            // Si le statut de la carte ne correspond pas au filtre actif, on la masque
            if (cardStatus !== activeFilters.status) {
                showCard = false;
            }
        }

        // Affiche ou masque la carte via son style display
        if (showCard) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
}

// Attache un écouteur de clic à chaque bouton de filtre
filterButtons.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();

        const category = this.getAttribute('data-category'); // "all" ou "status"
        const value = this.getAttribute('data-value');       // ex: "ouvert", "fermé"

        // Cas du bouton "Tous" : réinitialise le filtre et réaffiche tout
        if (category === 'all') {
            activeFilters.status = null;
            // Retire "actif" de tous les boutons, puis marque celui-ci comme actif
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            filterTickets();
            return;
        }

        // Pour tout autre filtre de statut, on retire "actif" des autres boutons
        document.querySelectorAll('[data-category="status"]').forEach(btn => btn.classList.remove('active'));
        document.querySelector('[data-category="all"]').classList.remove('active');

        // Active le filtre sélectionné et marque son bouton comme actif
        activeFilters.status = value;
        this.classList.add('active');

        // Relance le filtrage avec le nouveau filtre actif
        filterTickets();
    });
});
