<header>
    <div class="headerMenu">
        <div class="container">
            
            <a href="<?php echo get_home_url("home"); ?>/" class="logo">
                <img src="<?php echo get_template_directory_uri(); ?>/img/primakaficko-logo3.svg" alt="PrimaKafíčko">
            </a>

            <div class="menu">
                <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
            </div>
                <!--<ul>
                    <li><a href="#">domů</a></li>
                    <li><a href="#">o nás</a></li>
                    <li><a href="#">menu</a></li>
                    <li><a href="#">rezervace</a></li>
                    <li><a href="#">novinky</a></li>
                    <li><a href="#">kontakt</a></li>
                </ul>-->

            <div class="headerInfo">
                
                <a class="headerTel" href="tel:+420773348790">
                    <i class="fa-solid fa-phone"></i>
                    773 348 790
                </a>

                <p><b>PO-NE:</b> 7:00 - 21:00</p>
                
                <a href="https://maps.app.goo.gl/qVsQZ8rXKdMmdC5R7" target="_blank">Jablonského 2, Praha 7</a>

            </div>

        </div>
    </div>

    <div class="container">
        <a href="#" class="headerSleva">
            <img alt="PrimaKafíčko"
            srcset="<?php echo get_template_directory_uri(); ?>/img/primakaficko.jpg, 
            <?php echo get_template_directory_uri(); ?>/img/primakaficko@2.jpg 2x" 
            width="302" height="302">

            <div class="slevaText">
                <span>SUPER NABÍDKA</span>
                <h2>Každé ráno káva s sebou s&nbsp;50% SLEVOU!</h2>
                <p>Každý den mezi 7 a 9 hodinou ráno. Stavte se.</p>
            </div>

        </a>
    </div>
</header>