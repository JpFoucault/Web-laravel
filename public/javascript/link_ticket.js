document.getElementById('btn-link-ticket').addEventListener('click', function () {
    const select = document.getElementById('ticket_id');
    const errorEl = document.getElementById('link-error');
    const ticketId = select.value;

    errorEl.style.display = 'none';
    errorEl.textContent = '';

    if (!ticketId) {
        errorEl.textContent = 'Veuillez sélectionner un ticket.';
        errorEl.style.display = 'block';
        return;
    }

    this.disabled = true;

    fetch(window.LINK_TICKET_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': window.CSRF_TOKEN
        },
        body: JSON.stringify({ ticket_id: ticketId })
    })
    .then(function (res) { return res.json(); })
    .then(function (data) {
        if (!data.success) {
            errorEl.textContent = data.error ?? 'Une erreur est survenue.';
            errorEl.style.display = 'block';
            document.getElementById('btn-link-ticket').disabled = false;
            return;
        }

        const t = data.ticket;

        // Supprime la ligne "vide" si présente
        const emptyRow = document.getElementById('empty-row');
        if (emptyRow) emptyRow.remove();

        // Détermine la classe CSS du statut
        const statusClasses = { 'Nouveau': 'status-new', 'En cours': 'status-progress', 'Terminé': 'status-done' };
        const statusClass = statusClasses[t.statut] ?? 'status-new';

        // Construit et insère la nouvelle ligne
        const tbody = document.getElementById('tickets-tbody');
        const tr = document.createElement('tr');
        tr.innerHTML =
            '<td>' +
                '<div class="ticket-info">' +
                    '<span class="ticket-title">' + t.titre + '</span>' +
                    '<span class="ticket-project" style="font-size:12px; color:#94a3b8;">' +
                        '#TICK-' + String(t.id).padStart(4, '0') +
                    '</span>' +
                '</div>' +
            '</td>' +
            '<td><span class="priority-badge priority-' + t.priorite + '">' + t.priorite.charAt(0).toUpperCase() + t.priorite.slice(1) + '</span></td>' +
            '<td><span class="status-badge ' + statusClass + '">' + t.statut + '</span></td>' +
            '<td>' + t.createur + '</td>' +
            '<td>' + (t.delai ?? '—') + '</td>' +
            '<td class="text-right"><a href="' + t.url + '" class="btn-details">Voir détails</a></td>';
        tbody.appendChild(tr);

        // Incrémente le compteur total
        const statTotal = document.getElementById('stat-total');
        statTotal.textContent = parseInt(statTotal.textContent) + 1;

        // Supprime l'option du select
        select.querySelector('option[value="' + ticketId + '"]').remove();

        // Si plus aucun ticket libre, retire le bouton "Lier un ticket"
        if (select.querySelectorAll('option[value]').length === 0) {
            const wrapper = document.getElementById('btn-lier-wrapper');
            wrapper.innerHTML = '<span style="color:#64748b; font-size:13px;">Aucun ticket disponible à lier</span>';
        }

        // Ferme le modal
        window.location.hash = '';
        document.getElementById('btn-link-ticket').disabled = false;
    })
    .catch(function () {
        errorEl.textContent = 'Erreur réseau, veuillez réessayer.';
        errorEl.style.display = 'block';
        document.getElementById('btn-link-ticket').disabled = false;
    });
});
