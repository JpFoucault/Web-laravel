// Récupère tous les boutons de filtre et toutes les lignes de la table contrats
const filterBtns = document.querySelectorAll('.filter-btn');
const rows = document.querySelectorAll('tr[data-statut]');

filterBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
        const valeur = btn.dataset.value; // ex: "payee", "en cours", "cancel" ou undefined (= "Tout voir")

        // Pour chaque ligne, on affiche ou on cache selon le statut
        rows.forEach(function(row) {
            if (!valeur) {
                // Bouton "Tout voir" : on affiche tout
                row.style.display = '';
            } else {
                // On affiche la ligne seulement si son statut correspond au filtre
                row.style.display = (row.dataset.statut === valeur) ? '' : 'none';
            }
        });
    });
});
