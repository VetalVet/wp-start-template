<?php

/**
 * Register Blocks
 * @see https://www.billerickson.net/building-gutenberg-block-acf/#register-block
 *
 */
function register_gutenberg_blocks()
{
    if (!function_exists('acf_register_block')) {
        return;
    }
    
    acf_register_block(array(
        'name'            => 'take-ndas',
        'title'           => __('Take NDAs off your to-do list', 'Take NDAs off your to-do list'),
        'render_template' => '/gutenberg/template.php',
        'category'        => 'formatting',
        'icon'            => 'admin-users',
        'mode'            => 'auto',
        'keywords'        => array('acf block', 'nda', 'form')
    ));

    acf_register_block(array(
        'name'            => 'Guide',
        'title'           => __('Guide', 'Guide'),
        'render_template' => '/gutenberg/guide.php',
        'category'        => 'formatting',
        'icon'            => 'admin-users',
        'mode'            => 'auto',
        'keywords'        => array('Guide', 'Guide', 'acf block'),
    ));
}

add_action('acf/init', 'register_gutenberg_blocks');