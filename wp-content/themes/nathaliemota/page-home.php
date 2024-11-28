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
    <div class="filter-year">
        <select id="filter-sort">
        <option value="2024">2024</option>
        <option value="2023">2023</option>
        <option value="2022">2022</option>
        </select>
    </div>
</div>

<script>
    // Affichage des filtres dans la console pour débogage
    document.getElementById('filter-category').addEventListener('change', function() {
        console.log('Filtre catégorie changé:', this.value);
    });

    document.getElementById('filter-format').addEventListener('change', function() {
        console.log('Filtre format changé:', this.value);
    });

    document.getElementById('filter-sort').addEventListener('change', function() {
        console.log('Filtre trier par changé:', this.value);
    });
</script>

<div class="photo-grid" id="photo-gallery">
    <?php
    // Requête initiale pour 8 photos
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $photo_query = new WP_Query($args);

    if ($photo_query->have_posts()) :
        while ($photo_query->have_posts()) : $photo_query->the_post();
            ?>
            <div class="photo-item">
                <a href="<?php the_permalink(); ?>">
                    <!-- Affichage de l'image à la une en taille large -->
                    <?php the_post_thumbnail('large', array('class' => 'photo-full')); ?>
                </a>
                <div class="photo-overlay">
                    <!-- Icône pour voir la publication -->
                    <a href="<?php the_permalink(); ?>" class="icon eye">
                        <img src="http://nathaliemota.local/wp-content/uploads/2024/11/eye.png" alt="Eye Icon">
                    </a>
                    <!-- Icône pour ouvrir l'image en plein écran -->
                    <a href="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>" 
                       data-lightbox="image-<?php the_ID(); ?>" class="icon fullscreen">
                        <img src="http://nathaliemota.local/wp-content/uploads/2024/11/Icon_fullscreen.png" alt="Icône plein écran">
                    </a>
                    <!-- Texte en bas -->
                    <div class="text-filtre">
                        <div class="text-filtre-flex">
                            <div><?php the_field('reference'); ?></div>
                            <div>
                                <?php
                                // Récupérer la catégorie liée à la taxonomie 'categorie'
                                $categories = get_field('categories'); 
                                $category_name = 'Non classé'; // Valeur par défaut
                                if ($categories && !is_wp_error($categories)) {
                                    $category_term = get_term($categories[0], 'categorie'); // Récupérer le terme
                                    if (!is_wp_error($category_term) && $category_term) {
                                        $category_name = $category_term->name; // Nom de la catégorie
                                    }
                                }
                                echo esc_html($category_name);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;
    ?>
</div>

<!-- Bouton Charger plus -->
<div class="load-more-container">
    <button id="load-more-photos-btn">Charger plus</button>
</div>

<script>
    // Log des éléments de la grille de photos
    const photoItems = document.querySelectorAll('.photo-item');
    console.log('Éléments de la galerie photo:', photoItems);

    // Log de l'élément du bouton "Charger plus"
    document.getElementById('load-more-photos-btn').addEventListener('click', function() {
        console.log('Bouton "Charger plus" cliqué');
        // Implémenter ici le comportement pour charger plus de photos
    });
</script>

<?php
get_footer();
