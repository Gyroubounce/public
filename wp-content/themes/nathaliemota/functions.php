<?php


// Enregistrer le menu
function nathaliemota_register_menus() {
    register_nav_menus([
        'main-menu' => __('Menu Principal', 'nathaliemota'),
        'footer-menu' => __('Menu Footer', 'nathaliemota'), 
    ]);
}
add_action('after_setup_theme', 'nathaliemota_register_menus');


// Charger les styles et scripts
function nathaliemota_enqueue_assets() {
    // Scripts JS
    wp_enqueue_script('custom-modal-script', get_template_directory_uri() . '/js/script.js');
    wp_enqueue_script('photo-navigation', get_template_directory_uri() . '/js/photo-navigation.js');
 
    if(is_front_page()) {
        wp_enqueue_script('charger-plus', get_template_directory_uri() . '/js/charger-plus.js');

        // Localiser l'URL AJAX en utilisant wp_add_inline_script
        $script = 'var ajaxurl = "' . admin_url('admin-ajax.php') . '";';
        wp_add_inline_script('charger-plus', $script);
  
    };

    // filtre-photo
    wp_enqueue_script('filtre-photo', get_template_directory_uri() . '/js/filtre-photo.js');
    
      // Localiser l'URL AJAX en utilisant wp_add_inline_script
      $script = 'var ajaxurl = "' . admin_url('admin-ajax.php') . '";';
      wp_add_inline_script('filtre-photo', $script);

      wp_enqueue_script('moodal-screen', get_template_directory_uri() . '/js/modal-screen.js');

    // Charger le CSS de Select2
    wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
    // Charger le JS de Select2
    wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js');
    // Charger votre script de personnalisation
    wp_enqueue_script('custom-select2-init', get_template_directory_uri() . '/js/select2-init.js');

    // Styles CSS
    wp_enqueue_style('nathaliemota-style', get_stylesheet_uri());
    wp_enqueue_style('main-style', get_template_directory_uri() . '/scss/main.css', [], '1.0');
}
add_action('wp_enqueue_scripts', 'nathaliemota_enqueue_assets');


class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    // Ajouter une classe CSS aux éléments de menu
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '<ul class="custom-class">';
    }

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $output .= '<li class="custom-li-class"><a href="' . $item->url . '">' . $item->title . '</a></li>';
    }
}


// Charger dynamiquement plus de photos via AJAX
function load_more_photos() {
    // Récupérer les paramètres AJAX
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 8;

    // Arguments pour WP_Query
    $args = [
        'post_type' => 'photos',
        'posts_per_page' => $posts_per_page,
        'offset' => $offset,
        'orderby' => 'date',
        'order' => 'DESC',
    ];

    $photo_query = new WP_Query($args);

    // Générer la sortie HTML
    if ($photo_query->have_posts()) {
        while ($photo_query->have_posts()) {
            $photo_query->the_post();
            ?>
            <div class="photo-item">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('large', ['class' => 'photo-full']); ?>
                    <?php else : ?>
                        <img src="path/to/default-image.jpg" alt="Image par défaut">
                    <?php endif; ?>
                </a>
                <div class="photo-overlay">
                    <a href="<?php the_permalink(); ?>" class="icon eye">
                        <img src="http://nathaliemota.local/wp-content/uploads/2024/11/eye.png" alt="Eye Icon">
                    </a>
                   <!-- Icônes de liens -->
                   <a href="#" data-lightbox="image-<?php the_ID(); ?>" class="icon fullscreen" data-photo-url="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ); ?>" data-photo-title="<?php the_title(); ?>" data-photo-reference="<?php the_field('reference'); ?>" data-photo-category="<?php echo esc_html( get_the_terms( get_the_ID(), 'categorie' )[0]->name ); ?>">
                            <img src="http://nathaliemota.local/wp-content/uploads/2024/11/Icon_fullscreen.png" alt="icône full-screen">
                        </a>
                    
                    <div class="text-filtre">
                        <div class="text-filtre-flex">
                            <div><?php echo esc_html(get_field('reference') ?: ''); ?></div>
                            <div>
                                <?php
                                $categories = get_field('categories'); 
                                if ($categories && !is_wp_error($categories)) {
                                    $category_term = get_term($categories[0], 'categorie');
                                    echo esc_html($category_term->name ?? 'Non classé');
                                } else {
                                    echo 'Non classé';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo ''; // Aucun résultat
    }

    wp_reset_postdata();
    wp_die(); // Terminer proprement
}

// Ajouter les actions AJAX
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

function load_filtered_photos() {
    // Récupérer les paramètres envoyés via AJAX
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $format = isset($_POST['format']) ? $_POST['format'] : '';
    $sort = isset($_POST['sort']) ? $_POST['sort'] : 'date_desc';
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 8;

    // Arguments pour la requête WP_Query
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => $posts_per_page,
        'offset' => $offset,
        'orderby' => $sort === 'date_asc' ? 'date' : 'date',
        'order' => $sort === 'date_asc' ? 'ASC' : 'DESC',
        'tax_query' => array(),
    );

    // Filtrer par catégorie
    if ($category) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $category,
            'operator' => 'IN',
        );
    }

    // Filtrer par format
    if ($format) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
            'operator' => 'IN',
        );
    }

    // Exécuter la requête avec les arguments filtrés
    $photo_query = new WP_Query($args);

    // Si des photos sont trouvées
    if ($photo_query->have_posts()) :
        while ($photo_query->have_posts()) : $photo_query->the_post();
            ?>
            <div class="photo-item">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('large', array('class' => 'photo-full')); ?>
                </a>
                <div class="photo-overlay">
                    <a href="<?php the_permalink(); ?>" class="icon eye">
                        <img src="http://nathaliemota.local/wp-content/uploads/2024/11/eye.png" alt="Eye Icon">
                    </a>
                     <!-- Icônes de liens -->
                     <a href="#" data-lightbox="image-<?php the_ID(); ?>" class="icon fullscreen" data-photo-url="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ); ?>" data-photo-title="<?php the_title(); ?>" data-photo-reference="<?php the_field('reference'); ?>" data-photo-category="<?php echo esc_html( get_the_terms( get_the_ID(), 'categorie' )[0]->name ); ?>">
                            <img src="http://nathaliemota.local/wp-content/uploads/2024/11/Icon_fullscreen.png" alt="icône full-screen">
                        </a>
                    
                </div>
            </div>
            <?php
        endwhile;
    else :
        echo 'Aucune photo ne correspond à vos critères.';
    endif;

    // Réinitialiser les données de la requête
    wp_reset_postdata();

    // Fin de la requête AJAX
    wp_die();
}

// Actions AJAX pour les utilisateurs connectés et non connectés
add_action('wp_ajax_load_filtered_photos', 'load_filtered_photos');
add_action('wp_ajax_nopriv_load_filtered_photos', 'load_filtered_photos');
