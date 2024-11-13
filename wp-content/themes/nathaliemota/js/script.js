    
    document.addEventListener("DOMContentLoaded", function() {
        // Sélectionne le lien "Contact" dans le menu
        const contactLink = document.querySelector("a[href='#contact']");
    
        if (contactLink) {
            console.log("Le lien Contact a été trouvé !");
    
            contactLink.addEventListener("click", function(e) {
                e.preventDefault(); // Empêche le comportement par défaut du lien
                console.log("Clic sur le lien Contact !");
    
                // Sélectionne la modale et ajoute la classe 'open' pour l'afficher
                const modal = document.querySelector(".modal-overlay");
                if (modal) {
                    console.log("La modale a été trouvée !");
                    modal.classList.add('open');
                }
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
    
    