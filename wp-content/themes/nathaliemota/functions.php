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
    wp_enqueue_script('miniature', get_template_directory_uri() . '/js/référence.js');
    wp_enqueue_script('charger-plus', get_template_directory_uri() . '/js/charger-plus.js');

      // Localiser l'URL AJAX en utilisant wp_add_inline_script
      $script = 'var ajaxurl = "' . admin_url('admin-ajax.php') . '";';
      wp_add_inline_script('charger-plus', $script);
      
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
                    <a href="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>" 
                       data-lightbox="image-<?php the_ID(); ?>" class="icon fullscreen">
                        <img src="http://nathaliemota.local/wp-content/uploads/2024/11/Icon_fullscreen.png" alt="Icône plein écran">
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
