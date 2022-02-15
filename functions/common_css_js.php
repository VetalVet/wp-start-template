<?php 

add_action('wp_enqueue_scripts', '_scripts');

function _scripts(){
    // common styles
    // wp_enqueue_style('gallery', get_template_directory_uri() . '/assets/css/lightgallery-bundle.min.css');
    // wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css');
    wp_enqueue_style('-style', get_stylesheet_uri());
    // common styles
    //=====================================================================
    // common scripts
    // wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', array(), null, true);
    // wp_enqueue_script('select', get_template_directory_uri() . '/assets/js/select.js', array(), null, true);
    // wp_enqueue_script('gallery', get_template_directory_uri() . '/assets/js/lightgallery.min.js', array(), null, true);
    // wp_enqueue_script('da', get_template_directory_uri() . '/assets/js/dynamicAdapt.js', array(), null, true);
    // wp_enqueue_script('popup', get_template_directory_uri() . '/assets/js/popup.js', array(), null, true);

    wp_enqueue_script('-scripts', get_template_directory_uri() . '/assets/js/main.js', array(), null, true);
    
    
    // AJAX-поиск
    wp_enqueue_script('search', get_template_directory_uri() . '/assets/js/search.js', array(), null, true);
    wp_localize_script('search', 'search', [
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('search-nonce'),
    ]);

    // common scripts
    //=====================================================================
}

?>