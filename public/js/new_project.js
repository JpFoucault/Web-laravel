/**
 * new_project.js — Gestion du formulaire de création d'un nouveau projet
 *
 * But : permettre d'ajouter dynamiquement des technologies sous forme de badges
 * cliquables dans le formulaire, et valider les champs obligatoires avant
 * de soumettre le formulaire au serveur.
 *
 * Fonctionnalités :
 *  1. Ajout de technologies via le bouton "+" ou la touche Entrée — chaque
 *     technologie est affichée sous forme de badge avec un bouton de suppression.
 *  2. Validation du formulaire : nom du projet (non vide), client sélectionné,
 *     et date de début renseignée.
 */

// Écoute le clic sur le bouton d'ajout de technologie
document.querySelector('.btn-add-tech').addEventListener('click', function() {
    const input = document.getElementById('technologies');
    const techValue = input.value.trim(); // Récupère et nettoie la valeur saisie

    if (techValue) {
        const techList = document.getElementById('tech-list');

        // Crée un badge <span> pour afficher la technologie ajoutée
        const techBadge = document.createElement('span');
        techBadge.className = 'tech-badge';
        // Le badge contient le nom de la techno + un bouton "×" pour la supprimer
        techBadge.innerHTML = techValue + ' <button type="button" class="tech-remove">×</button>';

        techList.appendChild(techBadge); // Ajoute le badge à la liste
        input.value = ''; // Vide le champ de saisie après ajout

        // Permet de supprimer le badge en cliquant sur son bouton "×"
        techBadge.querySelector('.tech-remove').addEventListener('click', function() {
            techBadge.remove();
        });
    }
});

// Permet d'ajouter une technologie en appuyant sur Entrée dans le champ de saisie
document.getElementById('technologies').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault(); // Empêche la soumission accidentelle du formulaire
        document.querySelector('.btn-add-tech').click(); // Simule un clic sur le bouton "+"
    }
});

// Valide et soumet le formulaire de création de projet
document.getElementById('submitform').addEventListener('submit', function(e) {
    e.preventDefault(); // Bloque l'envoi natif pour effectuer la validation d'abord

    let isValid = true; // Indicateur global de validité du formulaire

    // Vérifie que le nom du projet n'est pas vide
    const nomProjet = document.getElementById('nom_projet');
    const projectError = document.getElementById('project_name_error');
    if (!nomProjet.value.trim()) {
        projectError.classList.remove('titanic'); // Affiche le message d'erreur
        isValid = false;
    } else {
        projectError.classList.add('titanic'); // Masque le message d'erreur
    }

    // Vérifie qu'un client est sélectionné (pas la valeur par défaut)
    const client = document.getElementById('client');
    const clientError = document.getElementById('client_name_error');
    if (client.value === '-- Sélectionner --' || !client.value) {
        clientError.classList.remove('titanic');
        isValid = false;
    } else {
        clientError.classList.add('titanic');
    }

    // Vérifie qu'une date de début est renseignée
    const startDate = document.getElementById('start_date');
    if (!startDate.value) {
        isValid = false;
    }

    // Si tous les champs sont valides, redirige vers la page des projets
    if (isValid) {
        window.location.href = 'project.php';
    }
});
