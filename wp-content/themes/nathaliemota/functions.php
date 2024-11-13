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

    // Charger le fichier CSS du thème
    wp_enqueue_style('nathaliemota-style', get_stylesheet_uri());
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
