document.addEventListener("DOMContentLoaded", function() {
    // Sélectionner tous les boutons ayant la classe "contact-link"
    const contactLinks = document.querySelectorAll(".contact-link");

    if (contactLinks.length > 0) {
        console.log(`Trouvé ${contactLinks.length} boutons Contact.`);

        // Ajouter un événement 'click' à chaque bouton
        contactLinks.forEach(link => {
            link.addEventListener("click", function(e) {
                e.preventDefault(); // Empêche le comportement par défaut

                console.log("Clic sur le bouton Contact !");

                // Récupérer la référence de la photo à partir de l'attribut data-ref
                const refPhoto = this.getAttribute("data-ref");
                console.log("Référence de la photo :", refPhoto);

                // Mettre à jour le contenu de la modale
                const modalTitle = document.querySelector(".modal-title");
                if (modalTitle) {
                    modalTitle.textContent = `Référence : ${refPhoto}`;
                }

                // Afficher la modale en ajoutant la classe 'open'
                const modal = document.querySelector(".modal-overlay");
                if (modal) {
                    modal.classList.add("open");
                    console.log("La modale est maintenant ouverte.");
                }
            });
        });
    } else {
        console.log("Aucun bouton Contact trouvé.");
    }

    // Fermer la modale
    const modal = document.querySelector(".modal-overlay");
    const closeModal = document.querySelector(".modal-close");

    if (modal && closeModal) {
        console.log("Bouton de fermeture détecté.");

        closeModal.addEventListener("click", function() {
            modal.classList.remove("open");
            console.log("La modale est maintenant fermée.");
        });
    } else {
        console.log("Bouton de fermeture ou modale non trouvé.");
    }
});
