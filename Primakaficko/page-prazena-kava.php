<?php get_header(); ?>

    <?php
        /* header pro podstránku se načítá ze souboru sub-header.php */
        require 'prazena-kava-header.php';
    ?>

        <?php while ( have_posts() ) : the_post(); ?>
            <div class="nadpis white">
                <div class="container">
                    <p>NÁŠE JEDINEČNÁ</p>
                    <div class="nadpisStranky">
                        <h1><?php the_title(); ?></h1>
                        <div class="line"></div>
                        <p class="nadpisText">I když je naše vlastní pražená káva dost virtuální, stejně Vám ji pošleme, alespoň na e-mail. A nebojte, žádné osobní údaje nehromadíme :D.</p>
                    </div>
                </div>
            </div>

            <div class="rezervace">
                <div class="container">

                    <?php echo do_shortcode( '[contact-form-7 id="66046cf" title="Pražená káva"]' ); ?>

                </div>
            </div>

            <div class="white small">

            </div>

            <?php require 'info.php'; ?>

        <?php endwhile; ?>


<?php get_footer(); ?>