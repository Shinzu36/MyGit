<?php
//Vytvoření menu pro WP
function register_my_menus() {
register_nav_menus(
    array(
    'header-menu' => __( 'Hlavní Menu' )
    )
);
}
add_action( 'init', 'register_my_menus' );



//Do souboru functions.php /*vypnutí p a br  v CF7*/ 
add_filter('wpcf7_autop_or_not', '__return_false');

add_theme_support( 'post-thumbnails' );



// registrace sidebaru "Novinky"
register_sidebar(array(
    'name'=> 'Novinky',
    'id' => 'widget_novinky',
'before_widget' => '<div class="widget">',
'after_widget' => '</div>'

));



//Vyhledávání pouze v příspěvcích
function ScanWPostFilter($query) {
    if ($query->is_search) {
        $query->set('post_type', 'post');
    }
    return $query;
}
add_filter('pre_get_posts','ScanWPostFilter');



add_action( 'wp_footer', 'redirect_cf7' );
function redirect_cf7() {
?>
<script>
document.addEventListener( 'wpcf7mailsent', function( event ) {
      location = 'http://student14.primawebovky.cz/dekujeme/';
}, false );
</script>
<?php
}

