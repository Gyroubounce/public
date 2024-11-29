<?php get_header(); ?>


<?php
// Récupérer la catégorie de la photo actuelle
$categories = get_field('categories'); 
$category_name = 'Non classé'; // Valeur par défaut

if ($categories && !is_wp_error($categories)) {
    $category_term = get_term($categories[0], 'categorie'); 
    if (!is_wp_error($category_term) && $category_term) {
        $category_name = $category_term->name;
    }
}
?>

<div class="header-image">
    <?php
    // Requête pour récupérer une publication aléatoire avec une image à la une
    $args = array(
        'post_type' => 'photos', 
        'posts_per_page' => 1, 
        'orderby' => 'rand', 
        'meta_query' => array(
            array(
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS',
            ),
        ),
    );

    $random_query = new WP_Query($args);

    if ($random_query->have_posts()) :
        while ($random_query->have_posts()) : $random_query->the_post();
            ?>
            <!-- Afficher l'image à la une en grand format -->
            <?php the_post_thumbnail('full', array('class' => 'photo-full')); ?>

            <h1 class="sr-only">
                <?php 
                $title = get_the_title();
                echo esc_html($title);
                ?>
            </h1>

            <div id="photo-data" style="display: none;">
                <?php 
                // Récupération des informations photo
                $reference = get_field('reference') ?: 'Non défini';
                $formats = get_field('formats');
                $format_name = 'Non défini';
                if ($formats && !is_wp_error($formats)) {
                    $format_term = get_term($formats[0], 'format'); 
                    if (!is_wp_error($format_term) && $format_term) {
                        $format_name = $format_term->name; 
                    }
                }
                $type = get_field('type') ?: 'Non défini';
                $year = get_the_date('Y');

                $photo_info = array(
                    'Titre' => $title,
                    'Référence' => $reference,
                    'Catégorie' => $category_name,
                    'Format' => $format_name,
                    'Type' => $type,
                    'Année' => $year,
                    'Image URL' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                );

                // Affichage dans la console
                $photo_info_json = json_encode($photo_info);
                echo '<script>console.log(' . $photo_info_json . ');</script>';
                ?>
            </div>
        <?php endwhile;
        wp_reset_postdata();
    else :
        echo '<img src="http://nathaliemota.local/wp-content/uploads/2024/11/Header.png" alt="Image d\'en-tête">';
    endif;
    ?>
</div>

<!-- Section pour les photos liées -->
<?php 

// Inclure le contenu principal de la page d'accueil
 get_template_part('page', 'home'); // Appelle page-home.php

 ?> 

<?php get_footer(); ?>

