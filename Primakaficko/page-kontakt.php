<?php get_header(); ?>


    <?php while ( have_posts() ) : the_post(); ?>

        <?php
	    /* header pro podstránku se načítá ze souboru sub-header.php */
	    require 'kontakt-header.php';
        ?>

            <section>

                <div class="nadpis white">
                    <div class="container">
                        <p>ZDE JE NÁŠ</p>
                        <div class="nadpisStranky">
                            <h1><?php the_title(); ?></h1>
                            <div class="line"></div>
                            <a href="<?php echo get_home_url("home"); ?>/rezervace/" class="btn">Rezervovat místo</a>
                        </div>
                    </div>
                </div>

                <div class="kontakt">
                    <div class="container">

                        <div class="kontaktFlex">
                            <div class="kontaktText">
                                <p><b>Virtuální bistro PrimaKaficko.cz od PrimaKurzy.cz</b></p>
                                <p>
                                    <i class="fa-regular fa-envelope"></i>
                                    info@primakaficko.cz
                                </p>
                            </div>
                            <a class="headerTel" href="tel:+420773348790">
                                <i class="fa-solid fa-phone"></i>
                                773 348 790
                            </a>
                        </div>    
                        <p>
                            <b><i class="fa-solid fa-location-dot"></i>Jablonského 2, Praha 7</b>

                            <span>
                            <i class="fa-regular fa-clock"></i>
                            <b>PO-NE:</b> 7:00 - 21:00
                            </span>
                            Přijímáme stravenky, ledviny i platební karty.
                        </p>
                        
                    </div>
                </div>

                <div class="white big">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2558.8954906605863!2d14.441053599999998!3d50.106963099999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470b94b58406182b%3A0x1f35b827dff20972!2sJablonsk%C3%A9ho%20640%2F2%2C%20170%2000%20Praha%207-Hole%C5%A1ovice!5e0!3m2!1scs!2scz!4v1723638702614!5m2!1scs!2scz" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <?php require 'info.php'; ?>

            </section>


    <?php endwhile; ?>


<?php get_footer(); ?>