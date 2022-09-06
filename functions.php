<?php
// Общие стили и скрипты для ВСЕХ страниц
require get_template_directory() . '/functions/common_css_js.php';




// Подключение своих php скриптов
// AJAX поиск
// require get_template_directory() . '/functions/ajax-search.php';

// AJAX подписка на рассылку с плагином Newsletter
// require get_template_directory() . '/functions/ajax/newsletter.php';

// Хлебные крошки 
// require get_template_directory() . '/functions/breadcrumbs.php';

// Регистрация строк PolyLang
// require get_template_directory() . '/functions/polylang.php';

// Ссылки поделиться в соцсетях
// require get_template_directory() . '/functions/social.php';

// Регистрация таксономий и типов постов
// require get_template_directory() . '/functions/taxonomies_and_posttypes.php';

// Регистрация кастомных gutenberg блоков
// require get_template_directory() . '/functions/gutenberg_acf.php';



// Скрываем админпанель на сайте
show_admin_bar(false);

// Подключение кастомных виджетов
// require get_template_directory() . '/widgets/widgets.php';
// require get_template_directory() . '/widgets/widget-about.php';
// require get_template_directory() . '/widgets/widget-customcategory.php';
// require get_template_directory() . '/widgets/widget-subscribe.php';
// require get_template_directory() . '/widgets/widget-customsearch.php';
// require get_template_directory() . '/widgets/widget-filter.php';
// require get_template_directory() . '/widgets/widget-rating.php';



// Редактирование файлов WooCommerce
// require get_template_directory() . '/woocommerce/woo.php';



add_theme_support('menus');             // поддержка меню
add_theme_support('custom-logo');       // поддержка логотипа
add_theme_support('post-thumbnails');   // поддержка миниатюр поста
// add_theme_support('woocommerce');       // поддержка woocommerce(опционально)



add_filter( 'upload_mimes', 'upload_allow_types' );
function upload_allow_types( $mimes ) {
	// разрешаем новые типы
	$mimes['svg']  = 'image/svg+xml'; // image/svg+xml
	$mimes['webp']  = 'image/webp'; 
		
	return $mimes;
}

// Кастомные размеры миниатюр
// add_image_size('full_hd', 1920, 1080);


// ACF Options page, Добавляет страницу опций в панель управления «wp-admin».
// if( function_exists('acf_add_options_page') ) {
//     acf_add_options_page();
// }


// function remove_menus(){
//     remove_menu_page( 'edit.php' ); //Posts
//     remove_menu_page( 'edit-comments.php' ); //Comments
// }
// add_action( 'admin_menu', 'remove_menus' );



// Включение редактирования второго логотипа в кастомайзере
// function my_customize_register( $wp_customize ) {
//     $wp_customize->add_setting('header_logo', array(
//         'default' => '',
//         'sanitize_callback' => 'absint',
//     ));

//     $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'header_logo', array(
//         'section' => 'title_tagline',
//         'label' => 'Логотип в футере'
//     )));

//     $wp_customize->selective_refresh->add_partial('header_logo', array(
//         'selector' => '.footer-logo',
//         'render_callback' => function() {
//             $logo = get_theme_mod('header_logo');
//             $img = wp_get_attachment_image_src($logo, 'full');
//             if ($img) {
//                 return '<img src="' . $img[0] . '" alt="">';
//             } else {
//                 return '';
//             }
//         }
//     ));
// }
// add_action( 'customize_register', 'my_customize_register' );


// Подключение меню если нужно больше одного
// add_action( 'after_setup_theme', function(){
// 	register_nav_menus( [
// 		'header_menu' => 'Меню в шапке',
// 		'footer_menu' => 'Меню в подвале',
// 	] );
// } );



// Подключение и регистрация сайдбаров
// add_action( 'widgets_init', 'register_sidebars' );
// function register_sidebars(){

// 	register_sidebar( array(
// 		'name'          => "sidebar-1",
// 		'id'            => "sidebar-1",
// 		'description'   => '',
// 		'class'         => '',
// 		'before_widget' => '<li id="%1$s" class="widget %2$s">',
// 		'after_widget'  => "</li>\n",
// 		'before_title'  => '<h2 class="widgettitle">',
// 		'after_title'   => "</h2>\n",
// 		'before_sidebar' => '', // WP 5.6
// 		'after_sidebar'  => '', // WP 5.6
// 	) );

//     register_sidebar( array(
// 		'name'          => "sidebar-2",
// 		'id'            => "sidebar-2",
// 		'description'   => '',
// 		'class'         => '',
// 		'before_widget' => '<li id="%1$s" class="widget %2$s">',
// 		'after_widget'  => "</li>\n",
// 		'before_title'  => '<h2 class="widgettitle">',
// 		'after_title'   => "</h2>\n",
// 		'before_sidebar' => '', // WP 5.6
// 		'after_sidebar'  => '', // WP 5.6
// 	) );
// }



// Кастомное меню
// class description_walker extends Walker_Nav_Menu{
//     function start_el(&$output, $item, $depth, $args){
//         global $wp_query;
//         $indent = ($depth) ? str_repeat("\t", $depth) : '';

//         $class_names = $value = '';

//         $classes = empty($item->classes) ? array() : (array) $item->classes;

//         $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
//         $class_names = ' class="' . esc_attr($class_names) . '"';

//         $output .= $indent . '<li class="nav__item">';


//         $attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
//         $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
//         $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
//         $attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url) . '"' : '';

//         $prepend = '<strong>';
//         $append = '</strong>';


//         if ($depth != 0) {
//             $description = $append = $prepend = '';
//         }

//         $item_output = $args->before;
//         $item_output .= '<a class="nav__link"' . $attributes . '>';
//         $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID);
//         $item_output .= '</a>';
//         $item_output .= $args->after;

//         $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
//     }
// }



// Пример создания шорткода
// add_shortcode( 'download-file', 'shortcode' );
// function shortcode( $atts ){

//     $params = shortcode_atts( 
// 		array(
// 			'url' => null,
// 			'title' => esc_html('Download File'),
// 		), 
// 		$atts 
// 	);

//     if(!$params['url'] || !is_page()){
//         return;
//     } else{
//         if(!$params['title']){
//             $title = esc_html('Download File');
//         } 
//         return "<a href='" . $params['url'] . "' title='" . esc_html($params['title']) . "'>" . esc_html($params['title']) . "</a>";
//     }
// }


// Вызов шаблона 404 при заходе на нужную страницу без редиректов
// function my_parse_query( $wp_query ) { 
//     if (is_author() || is_category() || is_tag() || is_date() || is_tax('country', 'country')) { 
//         $wp_query->set_404(); 
//         status_header( 404 ); 
//     } 
// } 
// add_action( 'parse_query', 'my_parse_query' ); 


// Подключение и регистрация кастомных виджетов - ДОПОЛНИТЬ!!!
// https://misha.agency/wordpress/widgets.html
// https://wp-kama.ru/function/register_widget
// Курс по вордпрессу + вукомерсу 10-11 урок


?>