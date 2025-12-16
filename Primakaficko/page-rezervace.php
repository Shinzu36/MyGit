<?php get_header(); ?>

    <?php
        /* header pro podstránku se načítá ze souboru sub-header.php */
        require 'rezervace-header.php';
    ?>

        <?php while ( have_posts() ) : the_post(); ?>
            <div class="nadpis white">
                <div class="container">
                    <p>NÁŠE</p>
                    <div class="nadpisStranky">
                        <h1><?php the_title(); ?></h1>
                        <div class="line"></div>
                        <a class="headerTel" href="tel:+420773348790">
                            <i class="fa-solid fa-phone"></i>
                            773 348 790
                        </a>
                    </div>
                </div>
            </div>

            <div class="rezervace">
                <div class="container">

                    <?php echo do_shortcode( '[contact-form-7 id="fbcccaa" title="Rezervace"]' ); ?>

                </div>
            </div>

            <div class="white small">

            </div>

            <?php require 'info.php'; ?>

        <?php endwhile; ?>


<?php get_footer(); ?>