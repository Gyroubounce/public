<?php


// Enregistrer le menu
function nathaliemota_register_menus() {
    register_nav_menus([
        'main-menu' => __('Menu Principal', 'nathaliemota'),
        'footer-menu' => __('Menu Footer', 'nathaliemota'), 
    ]);
}
add_action('after_setup_theme', 'nathaliemota_register_menus');

function nathaliemota_enqueue_styles() {
    // Charger le script JS personnalisé
    wp_enqueue_script('custom-modal-script', get_template_directory_uri() . '/js/script.js');

    // photo-navigation
    wp_enqueue_script('photo-navigation', get_stylesheet_directory_uri() . '/js/photo-navigation.js');

    // miniature
    wp_enqueue_script('miniature', get_stylesheet_directory_uri() . '/js/référence.js');

    wp_enqueue_script('ajax-load-more-photos', get_stylesheet_directory_uri() . '/js/charger-plus.js', array('jquery'), null, true);
    wp_localize_script('custom-js', 'ajaxurl', array( 'url' => admin_url('admin-ajax.php') ));

    // Charger le fichier CSS du thème
    wp_enqueue_style('nathaliemota-style', get_stylesheet_uri());

    wp_enqueue_style('main-style', get_stylesheet_directory_uri() . '/scss/main.css', array(), '1.0', 'all');

}
add_action('wp_enqueue_scripts', 'nathaliemota_enqueue_styles');


class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    // Ajouter une classe CSS aux éléments de menu
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '<ul class="custom-class">';
    }

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $output .= '<li class="custom-li-class"><a href="' . $item->url . '">' . $item->title . '</a></li>';
    }
}

function filter_photos_ajax() {
  // Vérifiez si tous les paramètres sont fournis
  if (isset($_POST['category']) && isset($_POST['format']) && isset($_POST['year'])) {
    $category = sanitize_text_field($_POST['category']);  // Catégorie envoyée
    $format = sanitize_text_field($_POST['format']);
    $year = sanitize_text_field($_POST['year']);  // Année envoyée

    // Initialiser les arguments de la requête WP
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8, // Nombre de photos à récupérer
        'orderby' => 'date', // Tri par date
        'order' => 'DESC', // Ordre décroissant (les plus récentes en premier)
    );

    // Vérifiez si un filtre de catégorie est spécifié
    if (!empty($category)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categorie',
                'field'    => 'slug', // Utilisation du slug de la catégorie
                'terms'    => $category,
            ),
        );
    }

    // Vérifiez si un filtre de format est spécifié
    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    // Vérifiez si un filtre d'année est spécifié
    if (!empty($year)) {
        $args['date_query'] = array(
            array(
                'year' => $year,
            ),
        );
    }

        // Requête WP
        $photo_query = new WP_Query($args);

        if ($photo_query->have_posts()) {
            $content = '';
            while ($photo_query->have_posts()) {
                $photo_query->the_post();
                ob_start(); // Démarrer la capture du contenu HTML
                ?>
                <div class="photo-item">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('large', array('class' => 'photo-full')); ?>
                    </a>
                    <div class="photo-overlay">
                        <a href="<?php the_permalink(); ?>" class="icon eye">
                            <img src="http://nathaliemota.local/wp-content/uploads/2024/11/eye.png" alt="Eye Icon">
                        </a>
                        <a href="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>" 
                           data-lightbox="image-<?php the_ID(); ?>" class="icon fullscreen">
                            <img src="http://nathaliemota.local/wp-content/uploads/2024/11/Icon_fullscreen.png" alt="Icône plein écran">
                        </a>
                        <div class="text-filtre">
                            <div class="text-filtre-flex">
                                <div><?php the_field('reference'); ?></div>
                                <div>
                                    <?php
                                    $categories = get_field('categories');
                                    $category_name = 'Non classé'; 
                                    if ($categories && !is_wp_error($categories)) {
                                        $category_term = get_term($categories[0], 'categorie');
                                        if (!is_wp_error($category_term) && $category_term) {
                                            $category_name = $category_term->name;
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
                $content .= ob_get_clean(); // Ajouter le contenu HTML à la variable $content
            }
            wp_reset_postdata();
            
            // Retourner la réponse JSON avec les nouvelles photos
            wp_send_json_success(array('content' => $content));
        } else {
            wp_send_json_success(array('content' => '<p>Aucune photo trouvée.</p>'));
        }
    } else {
        wp_send_json_error('Paramètres manquants');
    }
}

// Attacher l'action AJAX à la fonction
add_action('wp_ajax_filter_photos', 'filter_photos_ajax');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos_ajax');
