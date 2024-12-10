<?php
/**
 * Template for displaying single photos (Custom Post Type: Photos).
 *
 * @package NATHALIE_MOTA
 */

get_header();
?>
<div class="photo">
    <div class="photo-contenair">
        <div class="photo-content-wrapper">
            <!-- Zone de contenu principale -->
            <div class="photo-main">
                <!-- Bloc gauche -->
                <div class="photo-info">
                <h2>
                    <?php 
                        $title = get_the_title();
                        // Ajoute un <br> uniquement entre les mots tout en conservant la ponctuation attachée au mot précédent
                        $formattedTitle = preg_replace('/\s+([^\s.,!?]+)/', '<br>$1', $title);
                        echo $formattedTitle;
                    ?>
                </h2>
                    <ul>
                        <!-- Référence -->
                        <li>Référence : <?php the_field('reference'); ?></li>

                        <!-- Catégorie -->
                        <li>Catégorie : 
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
                        </li>

                        <!-- Format -->
                        <li>Format : 
                            <?php
                            // Récupérer le format lié à la taxonomie 'format'
                            $formats = get_field('formats');
                            $format_name = 'Non défini'; // Valeur par défaut

                            if ($formats && !is_wp_error($formats)) {
                                $format_term = get_term($formats[0], 'format'); // Récupérer le terme
                                if (!is_wp_error($format_term) && $format_term) {
                                    $format_name = $format_term->name; // Nom du format
                                }
                            }
                            echo esc_html($format_name);
                            ?>
                        </li>

                        <!-- Type -->
                        <li>Type : <?php the_field('type'); ?></li>

                        <!-- Année -->
                        <li>Année : <?php echo get_the_date('Y'); ?></li>
                    </ul>
                </div>
                <!-- Bloc droit -->
                <div class="photo-display">
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('large', array('class' => 'photo-full'));
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="photo-interactions-wrapper">
        <!-- Bloc bas -->
        <div class="photo-interactions">
            <div class="contact">
                <div class="contact-text">
                <!-- Lien de contact -->
                    <p>Cette photo vous intéresse ?</p>            
                </div>
                <div class="contact-btn">
                    <!-- Lien pour ouvrir la modale -->
                    <a href="javascript:void(0);" class="contact-link btn" data-ref="<?php the_field('reference'); ?>">
                    Contact
                    </a>
                </div>
            </div>
            <!-- Miniature et flèches de navigation -->
            <div class="photo-navigation">
                <!-- Miniature -->
                <div class="thumbnail-container">
                    <?php 
                    $next_post = get_post(); 
                    ?>
                    <?php if ($next_post) : ?>
                        <a id="thumbnail-link" data-next="<?php echo get_permalink($next_post->ID); ?>">
                            <?php
                                // Affiche la miniature de la photo suivante
                                echo get_the_post_thumbnail($next_post->ID, 'thumbnail', ['class' => 'next-thumbnail']);
                            ?>
                        </a>
                    <?php else : ?>
                        <p>Aucun post suivant trouvé.</p> <!-- Optionnel : message si aucun post suivant -->
                    <?php endif; ?>
                </div>


                <!-- Flèches sous la miniature -->
                <div class="arrows-navigation">
                    <?php $prev_post = get_previous_post(); ?>
                    <?php if ($prev_post) : ?>
                        <a href="#" class="nav-link prev-photo" data-url="<?php echo get_permalink($prev_post->ID); ?>" data-id="<?php echo $prev_post->ID; ?>">
                            &#10229; <!-- Flèche gauche -->
                        </a>
                    <?php endif; ?>

                    <?php $next_post = get_next_post(); ?>
                    <?php if ($next_post) : ?>
                        <a href="#" class="nav-link next-photo" data-url="<?php echo get_permalink($next_post->ID); ?>" data-id="<?php echo $next_post->ID; ?>">
                            &#10230; <!-- Flèche droite -->
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <div class="related-photos-wrapper">
        <div class="related-photos">
            <h3 class="propose">Vous aimerez aussi</h3>
            <?php get_template_part('template-parts/related-photos'); ?>
        </div>
    </div>

</div>
<?php get_footer(); ?>


