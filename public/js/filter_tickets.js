const filterButtons = document.querySelectorAll(".filter-btn");

let activeFilters = {
    status: null
};

function filterTickets() {
    // On cible les cartes de tickets au lieu des lignes de tableau
    const cards = document.querySelectorAll('.ticket-card');
    
    cards.forEach(card => {
        let showCard = true;
        
        if (activeFilters.status) {
            // On récupère le statut via l'attribut data-status que nous avons mis sur la carte
            const cardStatus = card.getAttribute('data-status');
            if (cardStatus !== activeFilters.status) {
                showCard = false;
            }
        }

        if (showCard) {
            card.style.display = "block"; // Ou utilise ta classe .titanic si tu préfères
        } else {
            card.style.display = "none";
        }
    });
}

filterButtons.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        
        const category = this.getAttribute('data-category');
        const value = this.getAttribute('data-value');
        
        // Gestion du bouton "Tous"
        if (category === 'all') {
            activeFilters.status = null;
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            filterTickets();
            return;
        }
        
        // Gestion de l'état actif des boutons
        document.querySelectorAll('[data-category="status"]').forEach(btn => btn.classList.remove('active'));
        document.querySelector('[data-category="all"]').classList.remove('active');
        
        activeFilters.status = value;
        this.classList.add('active');
        
        filterTickets();
    });
});