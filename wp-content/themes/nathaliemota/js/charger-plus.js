document.addEventListener('DOMContentLoaded', function () {
    console.log("Document chargé"); // Confirme que le DOM est prêt

    let offset = 8; // Nombre initial de photos chargées
    const loadMoreButton = document.getElementById('load-more');
    const gallery = document.getElementById('photo-gallery');

    if (!loadMoreButton) {
        console.error("Bouton Charger plus non trouvé !");
        return; // Stoppe le script si le bouton est introuvable
    }

    console.log("Bouton Charger plus trouvé :", loadMoreButton);

    loadMoreButton.addEventListener('click', function () {
        console.log("Bouton cliqué"); // Log lorsque le bouton est cliqué

        const data = {
            action: 'load_more_photos', // Action identifiée côté serveur
            offset: offset,            // Début du prochain lot
            posts_per_page: 8,          // Nombre de photos à charger
            post_type: 'photos', // Ajoutez ceci si nécessaire
        };

        loadMoreButton.textContent = 'Chargement...';
        console.log("Requête AJAX envoyée avec les données :", data);

        // Requête AJAX
        fetch(ajaxurl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams(data)
        })
        .then(response => {
            console.log("Réponse reçue :", response);
            return response.text();
        })
        .then(html => {
            if (html.trim() === '') {
                console.warn("Aucune photo supplémentaire à afficher");
                loadMoreButton.textContent = 'Aucune autre photo';
                loadMoreButton.disabled = true;
            } else {
                console.log("HTML des nouvelles photos :", html);
                gallery.insertAdjacentHTML('beforeend', html); // Ajouter les nouvelles photos
                offset += 8; // Augmenter l'offset pour le prochain lot
                loadMoreButton.textContent = 'Charger plus';
            }
        })
        .catch(error => {
            console.error('Erreur lors du chargement des photos :', error);
            loadMoreButton.textContent = 'Réessayer';
        });
    });
});
