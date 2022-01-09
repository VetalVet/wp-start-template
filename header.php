<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php wp_head(); ?>
</head>

<body>
    <div class="wrapper">
        <header>
            <div class="container">
                <div class="head-logo">
                    <?php the_custom_logo(); ?>
                </div>

                <nav class="head-menu">
                    <?php wp_nav_menu( [
                        'theme_location'  => 'Меню в шапке',
                        'menu'            => 'Меню в шапке',
                        'container'       => false,
                        'echo'            => true,
                        'menu_class'      => '',
                        'fallback_cb'     => 'wp_page_menu',
                        'items_wrap'      => '<ul>%3$s</ul>',
                        'depth'           => 3,
                        'walker'          => '',
                    ] ); ?>
                    <div class="header-contacts">

                    </div>
                </nav>
                <?php get_template_part('templates/header-form') ?>


                <div class="head-search">
                    <!-- <?php get_search_form(); ?> -->
                    <form role="search" method="get" action="<?php echo home_url('/') ?>">
                        <div><input autocomplete="off" class="search-input" value="<?php echo get_search_query() ?>" name="s" type="text" placeholder="Leita"></div>
                        <button id="searchsubmit" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19.856" height="20.848" viewBox="0 0 19.856 20.848">
                                <path d="M91.119,310.567l-4.713-4.713a8.8,8.8,0,0,0,2.51-6.147,8.708,8.708,0,1,0-8.708,8.708,8.983,8.983,0,0,0,5.02-1.588l4.815,4.815a.877.877,0,0,0,1.127,0A.792.792,0,0,0,91.119,310.567ZM73.037,299.708a7.171,7.171,0,1,1,7.171,7.171A7.192,7.192,0,0,1,73.037,299.708Z" transform="translate(-71.5 -291)" fill="#fff" />
                            </svg>
                        </button>
                        <ul class="ajax-search"></ul>
                    </form>
                </div>

                <div class="burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </header>