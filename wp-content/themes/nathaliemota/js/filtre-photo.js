jQuery(document).ready(function($) {
    function loadPhotos() {
        var category = $('#filter-category').val();
        var format = $('#filter-format').val();
        var sort = $('#filter-sort').val();

        // Envoi de la requête AJAX avec les paramètres de filtrage
        $.ajax({
            url: ajaxurl, // L'URL de l'admin-ajax.php de WordPress
            method: 'POST',
            data: {
                action: 'load_filtered_photos', // Action pour l'AJAX
                category: category,
                format: format,
                sort: sort,
                offset: 0, // Réinitialiser l'offset pour la première page
                posts_per_page: 8
            },
            success: function(response) {
                $('#photo-gallery').html(response); // Injecter les photos filtrées
            }
        });
    }

    // Charger les photos dès que l'un des filtres change
    $('#filter-category, #filter-format, #filter-sort').change(function() {
        loadPhotos();
    });

    // Charger les photos initiales au chargement de la page
    loadPhotos();
});
