document.addEventListener('DOMContentLoaded', function () {
    const thumbnailContainer = document.querySelector('.thumbnail-container');
    const prevPhoto = document.querySelector('.prev-photo');
    const nextPhoto = document.querySelector('.next-photo');

    // Fonction pour mettre à jour la miniature sans supprimer la balise <a>
    function updateThumbnail(url, postId) {
        // Effectuer une requête AJAX pour obtenir la nouvelle miniature
        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newThumbnail = doc.querySelector('.next-thumbnail');

                if (newThumbnail) {
                    // Trouver la balise <a> dans le container
                    const link = thumbnailContainer.querySelector('a');

                    if (link) {
                        // Mettre à jour l'image dans le lien
                        link.innerHTML = '';
                        link.appendChild(newThumbnail);

                        // Mettre à jour l'attribut 'data-next' de la balise <a>
                        const newNextUrl = doc.querySelector('#thumbnail-link')?.getAttribute('data-next');
                        if (newNextUrl) {
                            link.setAttribute('data-next', newNextUrl);
                        }
                    } else {
                        console.error("La balise <a> est introuvable dans le container.");
                    }
                }

                // Mettre à jour les flèches
                const newPrev = doc.querySelector('.prev-photo');
                const newNext = doc.querySelector('.next-photo');

                if (prevPhoto && newPrev) {
                    prevPhoto.dataset.url = newPrev.dataset.url;
                    prevPhoto.dataset.id = newPrev.dataset.id;
                }

                if (nextPhoto && newNext) {
                    nextPhoto.dataset.url = newNext.dataset.url;
                    nextPhoto.dataset.id = newNext.dataset.id;
                }
            })
            .catch(error => {
                console.error("Erreur lors de la mise à jour de la miniature :", error);
            });
    }

    // Gestion des clics sur la flèche précédente
    if (prevPhoto) {
        prevPhoto.addEventListener('click', (e) => {
            e.preventDefault();
            const url = prevPhoto.dataset.url;
            const postId = prevPhoto.dataset.id;

            // Vérifier si l'URL est disponible
            if (url) {
                updateThumbnail(url, postId);
                console.log("URL précédente :", url);
            } else {
                console.error("URL précédente introuvable.");
            }
        });
    }

    // Gestion des clics sur la flèche suivante
    if (nextPhoto) {
        nextPhoto.addEventListener('click', (e) => {
            e.preventDefault();
            const url = nextPhoto.dataset.url;
            const postId = nextPhoto.dataset.id;

            // Vérifier si l'URL est disponible
            if (url) {
                updateThumbnail(url, postId);
                console.log("URL suivante :", url);
            } else {
                console.error("URL suivante introuvable.");
            }
        });
    }

    // Gestion du clic sur la miniature pour naviguer
    const thumbnailLink = thumbnailContainer.querySelector('#thumbnail-link');
    if (thumbnailLink) {
        thumbnailLink.addEventListener('click', (e) => {
            e.preventDefault();
            const nextUrl = thumbnailLink.getAttribute('data-next');

            if (nextUrl) {
                console.log("Navigation vers :", nextUrl);
                window.location.href = nextUrl; // Redirige vers l'URL
            } else {
                console.error("L'attribut 'data-next' est manquant.");
            }
        });
    } else {
        console.error("Le lien miniature (#thumbnail-link) est introuvable.");
    }
});
