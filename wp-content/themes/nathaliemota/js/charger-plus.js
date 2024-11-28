document.addEventListener('DOMContentLoaded', function () {
    function updateGallery() {
        console.log("updateGallery called");

        const category = document.getElementById('filter-category').value;
        const format = document.getElementById('filter-format').value;
        const year = document.getElementById('filter-year').value; // Récupérer l'année

        // Exemple de requête AJAX
        fetch(ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'filter_photos',
                category: category,
                format: format,
                year: year // Envoyer l'année dans la requête AJAX
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("Photos mises à jour:", data.data);
                // Mettez à jour la galerie avec les nouvelles photos ici
                // Exemple : Affichage des photos et de leurs catégories
                const galleryContainer = document.getElementById('photo-gallery');
                galleryContainer.innerHTML = ''; // Vider le conteneur

                data.data.forEach(photo => {
                    const photoElement = document.createElement('div');
                    photoElement.classList.add('photo-item');
                    photoElement.innerHTML = `
                        <img src="${photo.featured_media_url}" alt="${photo.title}">
                        <h3>${photo.title}</h3>
                        <p>${photo.category}</p> <!-- Afficher la catégorie -->
                    `;
                    galleryContainer.appendChild(photoElement);
                });
            } else {
                console.error("Erreur lors du chargement des photos.");
            }
        })
        .catch(error => console.error('Erreur AJAX:', error));
    }

    // Attacher l'événement de mise à jour de la galerie au changement des filtres
    document.getElementById('filter-category').addEventListener('change', updateGallery);
    document.getElementById('filter-format').addEventListener('change', updateGallery);
    document.getElementById('filter-year').addEventListener('change', updateGallery);
});
