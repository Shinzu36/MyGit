<?php get_header(); ?>

    <?php
        /* header pro podstránku se načítá ze souboru sub-header.php */
        require 'prazena-kava-header.php';
    ?>

        <?php while ( have_posts() ) : the_post(); ?>
            <div class="nadpis white" id="text">
                <div class="container">
                    <p>NÁŠE JEDINEČNÉ</p>
                    <div class="nadpisStranky">
                        <h1><?php the_title(); ?></h1>
                        <div class="line"></div>
                        <?php dynamic_sidebar( 'widget_novinky' ); ?>
                    </div>
                </div>
            </div>

            <div class="novinky">
                <div class="container">

                    <div class="novinkyFlex">
                                <?php 
                        $temp = $wp_query; $wp_query= null;
                        $wp_query = new WP_Query(); $wp_query->query('' . '&paged='.$paged);
                        while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                            
                            <a  class="obr-blog" href="<?php the_permalink(); ?>"><?php if (has_post_thumbnail() ) { the_post_thumbnail('full');} else {echo '<img src="'.get_template_directory_uri().'/img/no.jpeg" alt="obrazek"/>';} ?>
                
                            <?php the_title(); ?></a>
                                    
                            <?php endwhile; ?>
                                
                    </div>

                    <div class="tlacitka">
                        <span class="newer"><?php previous_posts_link('<i class="fa-solid fa-arrow-left"></i> Novější'); ?></span>
                        <span class="older"><?php next_posts_link('Starší <i class="fa-solid fa-arrow-right"></i>'); ?></span>
                    </div>

                    <?php wp_reset_query(); ?>
                </div>
            </div>

            <div class="white small">

            </div>

            <?php require 'info.php'; ?>

        <?php endwhile; ?>


<?php get_footer(); ?>