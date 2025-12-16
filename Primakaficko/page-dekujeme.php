<?php get_header(); ?>

    <?php
        /* header pro podstránku se načítá ze souboru sub-header.php */
        require 'dekujeme-header.php';
    ?>

        <?php while ( have_posts() ) : the_post(); ?>
            <div class="nadpis white center">
                <div class="container">
                    <p>OBJEDNÁVKA</p>
                    <div class="nadpisStranky">
                        <h1>Odeslána</h1>
                    </div>
                </div>
            </div>

            <div class="dekujeme">
                <h2 class="bigText">
                    Děkujeme!
                </h2>
                <p><b>Na e-mail Vám právě posíláme potvrzení odeslání formuláře.</b></p>
                <p>Pokračujte prosím <a href="<?php echo get_home_url("home"); ?>/">zde</a>...</p>
            </div>
            

            <div class="white small">

            </div>

            <?php require 'info.php'; ?>

        <?php endwhile; ?>


<?php get_footer(); ?>