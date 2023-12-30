<?php 
// // Для SEO-оптимизации
// // время последнего изменения страницы
// $lastModified = strtotime(date('d.m.Y H:i:s'));

// // дата последней загрузки, отправляемая клиентом
// $ifModified = strtotime(substr($_SERVER['HTTP_IF_MODIFIED_SINCE'] ?? '', 5));

// if ($ifModified && $ifModified >= $lastModified) {
//     // страница не изменилась, отдача http статуса 304
//     header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
//     exit;
// }

// header('Last-Modified: ' . gmdate("D, d M Y H:i:s \G\M\T", $lastModified));

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>

    <?php wp_head(); ?>

    <link rel="alternate" href="https://wtechnew.devbrainlab.com.ua/en/" hreflang="en-GB" />
    <link rel="alternate" href="https://wtechnew.devbrainlab.com.ua/" hreflang="uk-UA" />

    <?php if(pll_current_language() == 'en'){ ?>
        <link rel="alternate" href="https://wtechnew.devbrainlab.com.ua/en/" hreflang="x-default" />
    <?php } else { ?>
        <link rel="alternate" href="https://wtechnew.devbrainlab.com.ua/" hreflang="x-default" />
    <?php } ?>
</head>

<body <?php body_class(); ?>>
    <div class="wrapper">
        <header>
            <div class="container">
                <a href="#" class="custom-logo-link" rel="home" aria-current="page">
                    <img width="" height="" src="" class="custom-logo" alt="" decoding="async">
                </a>
                <!-- <?php the_custom_logo(); ?> -->


                <nav>
                    <ul>
                        <li class="menu-item menu-item-has-children">
                            <a href=""></a>
                            <!-- для многоуровневого меню -->
                            <ul class="sub-menu">
                                <li class="menu-item-has-children">
                                    <a href=""></a>
                                    <ul class="sub-menu">
                                        <li class="menu-item"><a href=""></a></li>
                                        <li class="menu-item"><a href=""></a></li>
                                        <li class="menu-item"><a href=""></a></li>
                                        <li class="menu-item"><a href=""></a></li>
                                        <li class="menu-item"><a href=""></a></li>
                                    </ul>
                                </li>
                                <li class="menu-item"><a href=""></a></li>
                                <li class="menu-item"><a href=""></a></li>
                                <li class="menu-item"><a href=""></a></li>
                                <li class="menu-item"><a href=""></a></li>
                            </ul>
                        </li>
                        <li class="menu-item"><a href=""></a></li>
                        <li class="menu-item"><a href=""></a></li>
                        <li class="menu-item"><a href=""></a></li>
                        <li class="menu-item"><a href=""></a></li>
                    </ul>
                    <!-- <?php wp_nav_menu( [
                        'theme_location'  => 'Меню в шапке',
                        'menu'            => 'Меню в шапке',
                        'container'       => false,
                        'echo'            => true,
                        'menu_class'      => '',
                        'fallback_cb'     => 'wp_page_menu',
                        'items_wrap'      => '<ul>%3$s</ul>',
                        'depth'           => 3,
                        'walker'          => '',
                    ] ); ?> -->
                </nav>

                <!-- если есть форма в шапке, опционально -->
                <!-- <?php get_template_part('templates/header-form') ?> -->

                <div class="burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <!-- если нужна форма поиска, опционально -->
                <!-- <div class="head-search">
                    <form role="search" method="get" action="<?php echo home_url('/') ?>">
                        <div>
                            <input
                                class="search-input" 
                                value="<?php echo get_search_query() ?>" 
                                name="s" 
                                type="text" 
                                placeholder="Leita">
                        </div>
                        <button id="searchsubmit" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19.856" height="20.848" viewBox="0 0 19.856 20.848">
                                <path d="M91.119,310.567l-4.713-4.713a8.8,8.8,0,0,0,2.51-6.147,8.708,8.708,0,1,0-8.708,8.708,8.983,8.983,0,0,0,5.02-1.588l4.815,4.815a.877.877,0,0,0,1.127,0A.792.792,0,0,0,91.119,310.567ZM73.037,299.708a7.171,7.171,0,1,1,7.171,7.171A7.192,7.192,0,0,1,73.037,299.708Z" transform="translate(-71.5 -291)" fill="#fff" />
                            </svg>
                        </button>

                        результаты поиска
                        <ul class="ajax-search"></ul>
                    </form>
                </div> -->


                <!-- Кастомная форма подписки на рассылку плагина Newsletter(опционально) -->
                <!-- <div class="tnp tnp-subscription">
                    <form method="post" action="/?na=s">
                        <input type="hidden" name="nlang" value="">
                        <div class="tnp-field tnp-field-email">
                            <label for="tnp-1">Email</label>
                            <input class="tnp-email" type="email" name="ne" id="tnp-1" value="" required>
                        </div>
                        <div class="tnp-field tnp-field-button">
                            <input class="tnp-submit" type="submit" value="Подписаться">
                        </div>
                    </form>
                </div> -->

                <!-- Переключатель языков в виде списка -->
                <ul>
                    <li class="lang-item current-lang"><a href="#">Українська</a></li>
                    <li class="lang-item"><a href="#">Русский</a></li>
                </ul>

                <!-- Переключатель языков в виде селекта -->
                <select name="lang_choice_1" id="lang_choice_1">
                    <option value="uk" selected="selected">Українська</option>
                    <option value="ru">Русский</option>
                </select>
            </div>
        </header>
        
        <?php
            // Если зашли с Internet explorera, то редиректим на заглушку 
            $ua = htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8');
            if (preg_match('~MSIE|Internet Explorer~i', $ua) || (strpos($ua, 'Trident/7.0') !== false && strpos($ua, 'rv:11.0') !== false)) {
                wp_redirect('/ie-thumb', 301);
            }
        ?>