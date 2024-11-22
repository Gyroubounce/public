<div class="related-photos">
    <h3 class="propose">Vous aimerez aussi</h3>
    <div class="related-grid">
        <?php
        // Récupérer la catégorie liée à la taxonomie 'categorie' via ACF
        $categories = get_field('categories'); 
        $category_name = 'Non classé'; // Valeur par défaut

        // Si des catégories sont assignées
        if ($categories && !is_wp_error($categories)) {
            // Récupérer le terme de la catégorie en utilisant le premier élément du tableau
            $category_term = get_term($categories[0], 'categorie'); // Récupérer le terme par son ID
            if (!is_wp_error($category_term) && $category_term) {
                $category_name = $category_term->name; // Nom de la catégorie
            }
        }

        // Vérifier que la catégorie existe
        if ($category_name !== 'Non classé') {
            // Nouvelle requête WP pour récupérer des articles liés dans la même catégorie
            $related_query = new WP_Query(array(
                'post_type' => 'photos', // Le type de contenu, ici "photos"
                'posts_per_page' => 2,    // Limiter à 2 articles
                'post__not_in' => array(get_the_ID()), // Exclure l'article actuel
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categorie', // Taxonomie à utiliser
                        'field'    => 'id',
                        'terms'    => $categories, // Termes issus du champ ACF
                        'operator' => 'IN', // Inclure les articles ayant l'une de ces catégories
                    ),
                ),
                'orderby' => 'rand', // Trier de manière aléatoire pour varier les articles liés
            ));

            // Boucle pour afficher les articles liés
            while ($related_query->have_posts()) : $related_query->the_post(); ?>
                <div class="related-item">
                    <a href="<?php the_permalink(); ?>">
                        <!-- Affichage de l'image à la une en taille pleine -->
                        <?php the_post_thumbnail('large', array('class' => 'photo-full')); ?>
                    </a>
                    <div class="related-overlay">
                        <!-- Icônes de liens -->
                        <a href="<?php the_permalink(); ?>" class="icon eye">👁️</a>
                    
                   
    <!-- Icônes de liens -->
    <a href="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ); ?>" 
       data-lightbox="image-<?php the_ID(); ?>" class="icon fullscreen">⛶</a>
    <!--
        Lien pour ouvrir la modale 
<a href="javascript:void(0);" id="openModal" class="icon fullscreen">⛶</a>

 -->
                        <!-- Texte en bas -->
                        <div class="text-bottom">
                            <div class="text-bottom-flex">
                                <div><?php the_field('reference'); ?></div>
                                <div><?php
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
                                ?></div>
                            </div>
                        </div>
                    </div>


                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        <?php } else { ?>
            <p>Aucune photo liée dans cette catégorie.</p>
        <?php } ?>
    </div>
</div>
