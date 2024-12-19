<?php
/*
Template Name: Default page
*/
?>

<?php get_header(); ?>
<main>
    <section class="about-page">
        <h1><?php the_title(); ?></h1>
        <div class="about-content">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div>
    </section>
</main>
<?php get_footer(); ?>
