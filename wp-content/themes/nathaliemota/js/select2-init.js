jQuery(document).ready(function($) {
    // Initialiser les éléments Select2 avec des placeholders et le bouton de suppression activé
    $('#filter-category').select2({
        placeholder: "Catégories",
        allowClear: true
    }).on('select2:open', function () {
        $('.select2-container--open').attr('title', 'Catégories');
    });

    $('#filter-format').select2({
        placeholder: "Formats",
        allowClear: true
    }).on('select2:open', function () {
        $('.select2-container--open').attr('title', 'Formats');
    });

    $('#filter-sort').select2({
        placeholder: "Trier par",
        allowClear: true
    }).on('select2:open', function () {
        $('.select2-container--open').attr('title', 'Trier par');
    });

    // Ajouter la flèche initiale au chargement (chevron vers le bas)
    $('.select2-selection__arrow').each(function () {
        $(this).html('<b>&#10095;</b>'); // Chevron ">" par défaut
        $(this).css({
            transform: 'rotate(90deg) scale(1.2)', // Taille légèrement augmentée
            display: 'inline-block',

        });
    });

    // Modifier la flèche dynamiquement lorsque le menu déroulant est ouvert
    $('.select2').on('select2:open', function() {
        const arrow = $(this).siblings('.select2-container').find('.select2-selection__arrow b');
        arrow.html('&#10094;'); // Chevron "<" pour le menu ouvert
        arrow.parent().css({
            transform: 'rotate(90deg) scale(1.2)' // Rotation de 90° avec effet
        });
    });

    // Modifier la flèche dynamiquement lorsque le menu déroulant est fermé
    $('.select2').on('select2:close', function() {
        const arrow = $(this).siblings('.select2-container').find('.select2-selection__arrow b');
        arrow.html('&#10095;'); // Chevron ">" pour le menu fermé
        arrow.parent().css({
            transform: 'rotate(90deg) scale(1.2)' // Retour à l'état initial
        });
    });
});
