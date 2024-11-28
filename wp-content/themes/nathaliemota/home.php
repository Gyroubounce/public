<?php get_header(); ?>


<div class="header-image">
    <?php
    // Requête pour récupérer une publication aléatoire avec une image à la une
    $args = array(
        'post_type' => 'photos', // Ou remplacez 'post' par le type de publication personnalisé si nécessaire
        'posts_per_page' => 1, // Une seule publication
        'orderby' => 'rand', // Aléatoire
        'meta_query' => array( // Vérifier que l'image à la une existe
            array(
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS',
            ),
        ),
    );

    $random_query = new WP_Query($args);

    // Vérifier si la requête retourne une publication
    if ($random_query->have_posts()) :
        while ($random_query->have_posts()) : $random_query->the_post();
            // Afficher l'image à la une en grand format
            the_post_thumbnail('full', array('class' => 'photo-full'));
        endwhile;
        wp_reset_postdata(); // Réinitialiser les données de la requête
    else :
        // Fallback : afficher une image par défaut si aucune publication n'est trouvée
        echo '<img src="http://nathaliemota.local/wp-content/uploads/2024/11/Header.png" alt="Image d\'en-tête">';
    endif;
    ?>
</div>


<?php 

// Inclure le contenu principal de la page d'accueil
 get_template_part('page', 'home'); // Appelle page-home.php

 ?> 
<?php get_footer(); ?>