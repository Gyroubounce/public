jQuery(document).ready(function($) {

    // Array to store the images in the lightbox
    var images = []; // Vous devrez remplir ce tableau avec les URLs des images
    var currentIndex = 0; // L'index de l'image actuellement affichée dans la lightbox

    // Collecter toutes les images et leurs données dans un tableau
    $('.icon.fullscreen').each(function() {
        var imageUrl = $(this).data('photo-url');
        var imageTitle = $(this).data('photo-title');
        var imageReference = $(this).data('photo-reference');
        var imageCategory = $(this).data('photo-category');

        // Ajouter l'image et ses données dans le tableau 'images'
        images.push({
            url: imageUrl,
            title: imageTitle,
            reference: imageReference,
            category: imageCategory
        });
    });


    // Afficher la modale avec les données dynamiques
    $(document).on('click', '.icon.fullscreen', function(e) {
        console.log('click');
        e.preventDefault();
    
        // Récupérer les données de la photo
        var photoUrl = $(this).data('photo-url');
        var photoTitle = $(this).data('photo-title');
        var photoReference = $(this).data('photo-reference');
        var photoCategory = $(this).data('photo-category');
    
        // Injecter les données dans la modale
        $('#lightbox-photo').attr('src', photoUrl);
        $('#lightbox-title').text(photoTitle);
        $('#lightbox-reference').text(photoReference);
        $('#lightbox-category').text(photoCategory);
    
        // Afficher la modale
        $('#lightbox').fadeIn();
    
        // Mettre à jour l'index pour la navigation
        currentIndex = images.findIndex(image => image.url === photoUrl);
    });
    

    // Navigation précédente
    $('#lightbox-prev').click(function() {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = images.length - 1; // Aller à la dernière image
        }

        var prevImage = images[currentIndex];
        $('#lightbox-photo').attr('src', prevImage.url);
        $('#lightbox-title').text(prevImage.title);
        $('#lightbox-reference').text(prevImage.reference);
        $('#lightbox-category').text(prevImage.category);
    });

    // Navigation suivante
    $('#lightbox-next').click(function() {
        if (currentIndex < images.length - 1) {
            currentIndex++;
        } else {
            currentIndex = 0; // Revenir à la première image
        }

        var nextImage = images[currentIndex];
        $('#lightbox-photo').attr('src', nextImage.url);
        $('#lightbox-title').text(nextImage.title);
        $('#lightbox-reference').text(nextImage.reference);
        $('#lightbox-category').text(nextImage.category);
    });

    // Fermeture de la lightbox
    $('#close-lightbox').click(function() {
        $('#lightbox').fadeOut();
    });
});
console.log("Modal script loaded!");
