document.addEventListener('DOMContentLoaded', function () {
    const thumbnailContainer = document.querySelector('.thumbnail-container');
    const prevPhoto = document.querySelector('.prev-photo');
    const nextPhoto = document.querySelector('.next-photo');

    // Fonction pour mettre à jour la miniature
    function updateThumbnail(url) {
        console.log("Tentative de mise à jour de la miniature avec l'URL :", url);
        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newThumbnail = doc.querySelector('.next-thumbnail');

                if (newThumbnail) {
                    // Mise à jour de la miniature
                    const link = thumbnailContainer.querySelector('a');
                    if (link) {
                        link.innerHTML = '';
                        link.appendChild(newThumbnail);
                        console.log("Miniature mise à jour avec succès.");
                    } else {
                        console.error("Lien pour la miniature introuvable.");
                    }
                } else {
                    console.error("Aucune miniature trouvée dans la page.");
                }
            })
            .catch(error => {
                console.error("Erreur lors de la mise à jour de la miniature :", error);
            });
    }

    // Événements de survol pour les flèches gauche et droite
    if (prevPhoto) {
        prevPhoto.addEventListener('mouseover', function() {
            const prevPostUrl = prevPhoto.dataset.url;
            console.log("Survol de la flèche précédente. URL de la photo précédente :", prevPostUrl);
            updateThumbnail(prevPostUrl);  // Mettre à jour la miniature pour le post précédent
        });
    }

    if (nextPhoto) {
        nextPhoto.addEventListener('mouseover', function() {
            const nextPostUrl = nextPhoto.dataset.url;
            console.log("Survol de la flèche suivante. URL de la photo suivante :", nextPostUrl);
            updateThumbnail(nextPostUrl);  // Mettre à jour la miniature pour le post suivant
        });
    }

    // Clic sur les flèches pour rediriger
    if (prevPhoto) {
        prevPhoto.addEventListener('click', (e) => {
            e.preventDefault();
            const url = prevPhoto.dataset.url;
            if (url) {
                window.location.href = url; // Redirection
                console.log("Redirection vers la photo précédente :", url);
            }
        });
    }

    if (nextPhoto) {
        nextPhoto.addEventListener('click', (e) => {
            e.preventDefault();
            const url = nextPhoto.dataset.url;
            if (url) {
                window.location.href = url; // Redirection
                console.log("Redirection vers la photo suivante :", url);
            }
        });
    }
});
