<?php 
$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full" );
get_header();
?>    
   
 <header class="singleBlog" style="background-image: url(<?php echo $thumbnail[0]; ?>);">
        
        <div class="headerMenu">
            <div class="container">

                <a href="<?php echo get_home_url("home"); ?>/" class="logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/primakaficko-logo3.svg" alt="PrimaKafíčko">
                </a>

                <div class="menu">
    <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
                    
                </div>

                <div class="headerInfo">
                    <a class="headerTel" href="tel:+420606123456">
                        <i class="fa-solid fa-phone"></i>
                        606 123 456
                    </a>
                    <p><b>PO-NE</b> : 7:00 - 21:00</p>
                    <a href="https://maps.app.goo.gl/9Z3WGnruFnqYmU9X8" target="_blank">Jablonského 2, Praha 7</a>
                </div>

            </div>
        </div>

        

    </header>