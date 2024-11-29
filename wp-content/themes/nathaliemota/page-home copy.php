<?php
/**
 * Template Name: Home Page
 * Description: Template personnalisé pour la page d'accueil.
 */
get_header();
?>

<div class="filters">
    <div class="filter-group">
        <!-- Menu déroulant Catégories -->
        <select id="filter-category">
            <option value="">Toutes les catégories</option>
            <?php
            $categories = get_terms(array('taxonomy' => 'categorie', 'hide_empty' => true));
            foreach ($categories as $category) {
                echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
            }
            ?>
        </select>

        <!-- Menu déroulant Formats -->
        <select id="filter-format">
            <option value="">Tous les formats</option>
            <?php
            $formats = get_terms(array('taxonomy' => 'format', 'hide_empty' => true));
            foreach ($formats as $format) {
                echo '<option value="' . esc_attr($format->slug) . '">' . esc_html($format->name) . '</option>';
            }
            ?>
        </select>
    </div>

    <!-- Menu déroulant Trier par -->
    <div class="filter-sort">
        <select id="filter-sort">
            <option value="2024">2024</option>
            <option value="2023">2023</option>
            <option value="2022">2022</option>
        </select>
    </div>
</div>

<script>
    // Log des filtres pour débogage
    document.getElementById('filter-category').addEventListener('change', function() {
        console.log('Filtre catégorie changé:', this.value);
        // Mettre en place le comportement de filtrage si nécessaire
    });

    document.getElementById('filter-format').addEventListener('change', function() {
        console.log('Filtre format changé:', this.value);
        // Mettre en place le comportement de filtrage si nécessaire
    });

    document.getElementById('filter-sort').addEventListener('change', function() {
        console.log('Filtre trier par changé:', this.value);
        // Mettre en place le comportement de tri si nécessaire
    });
</script>

<div class="related-photos-wrapper">
    <?php
    // Requête initiale pour 8 photos
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $photo_query = new WP_Query($args);


    ?>
</div>


    <!-- Bouton Charger plus -->
    <div class="load-more-container">
        <button id="load-more-photos-btn">Charger plus</button>
    </div>

    <script>
        document.getElementById('load-more-photos-btn').addEventListener('click', function() {
            console.log('Bouton "Charger plus" cliqué');
            // Charger plus de photos avec une nouvelle requête AJAX
        });
    </script>



<?php get_footer() ?>