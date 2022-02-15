<?php
//=====================================================================
// index.php
if(is_page_template('index.php')){
    wp_enqueue_style('index-style', get_template_directory_uri() . '/assets/css/index.css');

    wp_enqueue_script('index-scripts', get_template_directory_uri() . '/assets/js/index.js', array(), null, true);
}
//=====================================================================







?>