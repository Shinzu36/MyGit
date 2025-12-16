<?php get_header(); ?>

<?php
	/* header pro podstránku se načítá ze souboru sub-header.php */
	require 'hp-header.php';
?>


<section>
    <div class="info">
        <div class="container">

            <a href="#" class="infoSloupec">
                <img alt="Snídaně v Prima kafíčku" srcset="<?php echo get_template_directory_uri(); ?>/img/main1.jpg, <?php echo get_template_directory_uri(); ?>/img/main1@2.jpg 2x" width="324" height="342">
                <div class="infoText">
                    <h2>Snídaně v Prima kafíčku</h2>                            <p>Každý den od 6:00 do 9:00.</p>                            <span class="btn">Menu</span>
                </div>
            </a>
            <a href="<?php echo get_home_url("home"); ?>/prazena-kava/" class="infoSloupec">
                <img alt="Vlastní pražená káva" srcset= "<?php echo get_template_directory_uri(); ?>/img/main2.jpg, <?php echo get_template_directory_uri(); ?>/img/main2@2.jpg 2x" width="324" height="342">
                <div class="infoText">
                    <h2>Vlastní pražená káva</h2>
                    <p>Již od 99 Kč za 150 g.</p>
                    <span class="btn">Koupit</span>
                </div>
            </a>
            <a href="#" class="infoSloupec">
                <img alt="Lehká večeře" srcset="<?php echo get_template_directory_uri(); ?>/img/main3.jpg, <?php echo get_template_directory_uri(); ?>/img/main3@2.jpg 2x" width="324" height="342">
                <div class="infoText">
                    <h2>Lehká večeře</h2>
                    <p>V našem bistru.</p>
                    <span class="btn">Zobrazit menu</span>
                </div>
            </a>

        </div>
    </div>

    <div class="promo white">
        <div class="container">
            <h1>Primakafíčko Holešovice, Praha&nbsp;7</h1>
            <p>Líbí se vám Primakafíčko.cz? Udělali jsme jej s láskou ke kávě a k tvorbě webů. Kafíčko vám tedy rádi uděláme u nás při kurzu <a href="https://www.primakurzy.cz/kurz-tvorba-webovych-stranek/" target="_blank">Tvorba webových stránek</a>, kde se naučíte vytvářet weby jako je tento. Rádi Vás uvidíme. Tým PrimaKurzy.cz</p>
        </div>
     </div>
</section>

<?php get_footer(); ?>