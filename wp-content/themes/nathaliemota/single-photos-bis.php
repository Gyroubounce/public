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
                <div id="photo-data" style="display: none;">
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


    <div class="related-photos-wrapper">
        <div class="related-photos">
    
            <?php get_template_part('template-parts/related-photos'); ?>
        </div>
    </div>


<?php get_footer(); ?>


