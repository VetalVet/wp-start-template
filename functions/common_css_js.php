<?php 
// remove_head_scripts()
add_action('wp_enqueue_scripts', 'remove_head_scripts');
function remove_head_scripts(){
    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);
    remove_action('wp_head', 'wp_print_styles', 99);
    remove_action('wp_head', 'wp_enqueue_style', 99);

    add_action('wp_footer', 'wp_print_scripts', 5);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);
    add_action('wp_footer', 'wp_print_head_scripts', 5);
    add_action('wp_head', 'wp_print_styles', 30);
    add_action('wp_head', 'wp_enqueue_style', 30);
}


add_action('wp_enqueue_scripts', '_scripts');
function _scripts(){
    if (is_admin()) return; // don't dequeue on the backend
    wp_deregister_script( 'jquery' );


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


    // AJAX-фильтрация по меткам
    // wp_enqueue_script('searchtags', get_template_directory_uri() . '/assets/js/searchtags.js', array(), null, true);
    // wp_localize_script('searchtags', 'searchtags', [
    //     'url' => admin_url('admin-ajax.php'),
    //     'nonce' => wp_create_nonce('searchtags-nonce'),
    // ]);


    // AJAX-подписка на рассылку с плагином newsletter
    wp_enqueue_script('newsletter', get_template_directory_uri() . '/assets/js/newsletter.js', array(), null, true);
    wp_localize_script('newsletter', 'newsletter', [
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('newsletternonce'),
    ]);

    // common scripts
    //=====================================================================

    
    // Подключение стилей и скриптов для ОТДЕЛЬНЫХ страниц
    require get_template_directory() . '/styles_and_scripts.php';
}

?>