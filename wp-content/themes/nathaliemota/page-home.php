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
        <div class="filter-category">
            <select id="filter-category" class="select2">
                <option value="">Catégories</option>
                <?php
                $categories = get_terms(array('taxonomy' => 'categorie', 'hide_empty' => true));
                foreach ($categories as $category) {
                    echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
                }
                ?>
            </select>
        </div>
        <!-- Menu déroulant Formats -->
        <div class="filter-format">
            <select id="filter-format" class="select2">
                <option value="">Formats</option>
                <?php
                $formats = get_terms(array('taxonomy' => 'format', 'hide_empty' => true));
                foreach ($formats as $format) {
                    echo '<option value="' . esc_attr($format->slug) . '">' . esc_html($format->name) . '</option>';
                }
                ?>
            </select>
        </div>   
    </div>

    <!-- Menu déroulant Trier par -->
    <div class="filter-sort">
        <select id="filter-sort" class="select2">
            <option value="">Trier par</option>
            <option value="date_desc">Plus récentes</option>
            <option value="date_asc">Plus anciennes</option>
        </select>
    </div>
</div>



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
                    <!-- Icônes de liens -->
                    <a href="#" data-lightbox="image-<?php the_ID(); ?>" class="icon fullscreen" data-photo-url="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ); ?>" data-photo-title="<?php the_title(); ?>" data-photo-reference="<?php the_field('reference'); ?>" data-photo-category="<?php echo esc_html( get_the_terms( get_the_ID(), 'categorie' )[0]->name ); ?>">
                            <img src="http://nathaliemota.local/wp-content/uploads/2024/11/Icon_fullscreen.png" alt="icône full-screen">
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
        <button id="load-more">
            Charger plus
        </button>
    </div>
</div>

