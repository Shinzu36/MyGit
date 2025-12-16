<?php get_header(); ?>

<?php
    /* header pro podstránku se načítá ze souboru sub-header.php */
    require 'sub-header.php';
?>

<div class="container">
    <?php while ( have_posts() ) : the_post(); ?>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>