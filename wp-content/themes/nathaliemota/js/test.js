document.addEventListener("DOMContentLoaded", function() {
    // Sélectionne tous les liens qui ouvrent la modale avec la classe 'contact-link'
    const contactLinks = document.querySelectorAll("a.contact-link");

    // Vérifie si des liens de contact existent
    if (contactLinks.length > 0) {
        console.log("Les liens Contact ont été trouvés !");
    
        // Ajoute un écouteur d'événements pour chaque lien de contact
        contactLinks.forEach(link => {
            link.addEventListener("click", function(e) {
                e.preventDefault(); // Empêche le comportement par défaut du lien
                console.log("Clic sur un lien Contact !");
                
                // Récupère la référence de la photo depuis l'attribut 'data-photo-ref'
                const photoRef = this.getAttribute("data-photo-ref");
                console.log("Référence de la photo:", photoRef);
                
                // Sélectionne la modale
                const modal = document.querySelector(".modal-overlay");
                if (modal) {
                    console.log("La modale a été trouvée !");
                    modal.classList.add('open');  // Affiche la modale
                }

                // Remplir le champ "Référence" dans le formulaire avec la référence de la photo
                // Ici, nous utilisons le nom du champ 'REFERENCE' comme indiqué dans le formulaire
                const photoRefInput = document.querySelector("[name='REFERENCE']");
                if (photoRefInput) {
                    photoRefInput.value = photoRef;  // Remplie le champ avec la référence de la photo
                }
            });
        });
    }

    // Sélectionne la modale et le bouton de fermeture
    const modal = document.querySelector(".modal-overlay");
    const closeModal = document.querySelector(".modal-close");

    if (modal && closeModal) {
        console.log("La modale et le bouton de fermeture ont été trouvés.");
    
        // Ferme la modale en retirant la classe 'open'
        closeModal.addEventListener("click", function() {
            modal.classList.remove('open');
        });
    }
});
