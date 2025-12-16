<?php get_header(); ?>

<?php
    /* header pro podstránku se načítá ze souboru sub-header.php */
    require 'single-header.php';
?>

    <?php while ( have_posts() ) : the_post(); ?>

        <div class="nadpis white">
            <div class="container">
                <a class="nadpisPrispevek" href="<?php echo get_home_url("home"); ?>/novinky#text">ZPĚT DO VÝPISU NOVINEK</a>
                <div class="nadpisStranky">
                    <h1><?php the_title(); ?></h1>
                    <div class="fb-share-button" data-href="<?php
function wp_get_current_url() {
return home_url( $_SERVER['REQUEST_URI'] );}
echo esc_url( wp_get_current_url());
?>
" data-layout="button" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fstudent20.primawebovky.cz%2Fnovinky&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Sdílet</a></div>
                </div>
            </div>
        </div>

        <div class="container prispevek">

            <div class="datumPrispevku">
                <span>
                    <i class="fa-regular fa-clock"></i><?php the_time(); ?> <?php the_time( get_option('date_format' ) ); ?>
                </span>
                <span>
                    <i class="fa-solid fa-tags"></i><?php the_category(', '); ?>
                </span>
            </div>

            <?php the_content(); ?>

            <div class="tlacitka">
                <?php next_post_link('%link', '<i class="fa-regular fa-hand-point-left"></i> %title'); ?>
                <?php previous_post_link('%link', '%title <i class="fa-regular fa-hand-point-right"></i>'); ?>
            </div>

        </div>

    <?php endwhile; ?>


<?php get_footer(); ?>