<?php get_header(); ?>

<?php
	/* header pro podstránku se načítá ze souboru hp-header.php */
	require 'prazena-kava-header.php';
?>

<?php if ( have_posts() && strlen( trim(get_search_query()) ) != 0 ) : ?>

    <div class="nadpis white center">
        <div class="container">
            <p>Našli jsme pro vás</p>
            <div class="nadpisStranky cat">
                <h1><?php printf( __( 'Výsledky hledání pro dotaz: %s' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
            </div>
            <a class="nadpisPrispevek cat" href="<?php echo get_home_url("home"); ?>/novinky#text">ZPĚT DO VÝPISU NOVINEK</a>
        </div>
    </div>

    <div class="novinky">
        <div class="container">

            <div class="novinkyFlex">
                <?php while ( have_posts() ) : the_post(); ?>

                <a class="obr-blog" href="<?php the_permalink(); ?>"><?php if (has_post_thumbnail() ) { the_post_thumbnail('full');} else {echo '<img src="'.get_template_directory_uri().'/img/no.jpeg" alt="obrazek"/>';} ?>

                <?php the_title(); ?></a>

                <?php endwhile; ?>
            </div>

            <div class="tlacitka">
                <span class="newer"><?php previous_posts_link('<i class="fa-solid fa-angles-left"></i> Novější'); ?></span>
                <span class="older"><?php next_posts_link('Starší <i class="fa-solid fa-angles-right"></i>'); ?></span>
            </div>

        </div>
    </div>

    <div class="white small">

    </div>

    <?php
    /* header pro podstránku se načítá ze souboru hp-header.php */
    require 'info.php';
    ?>

<?php else : ?>

    <div class="nadpis white center">
        <div class="container">

            <p>Našli jsme pro vás</p>
            <div class="nadpisStranky cat">
                <h1><?php printf( __( 'Výsledky hledání pro dotaz: %s' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
            </div>
            <a class="nadpisPrispevek" href="<?php echo get_home_url("home"); ?>/novinky#text">ZPĚT DO VÝPISU NOVINEK</a>

        </div>
    </div>

    <div class="nenalezeno">
        <h2>Nic nenalezeno</h2>
        <p>Zdá se, že se hledaný dotaz na webu nenachází. Pokuste se hledání opakovat s jiným dotazem.</p>
        <?php dynamic_sidebar( 'widget_novinky' ); ?>
    </div>

    <div class="white small"></div>

    <?php
    /* header pro podstránku se načítá ze souboru hp-header.php */
    require 'info.php';
    ?>
        
<?php endif ;?>

<?php get_footer(); ?>