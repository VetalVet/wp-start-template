<?php
// Общие стили и скрипты для ВСЕХ страниц
require get_template_directory_uri() . 'functions/common_css_js.php';




// Подключение своих php скриптов
// AJAX поиск
require get_template_directory_uri() . 'functions/ajax-search.php';

// Подключение стилей и скриптов для ОТДЕЛЬНЫХ страниц
require get_template_directory_uri() . 'functions/styles_and_scripts.php';

// Регистрация таксономий и типов постов
require get_template_directory_uri() . 'functions/taxonomies_and_posttypes.php';

    





add_theme_support('menus');             // поддержка меню
add_theme_support('custom-logo');       // поддержка логотипа
add_theme_support('post-thumbnails');   // поддержка миниатюр поста






// Подключение меню
add_action( 'after_setup_theme', function(){
	register_nav_menus( [
		'header_menu' => 'Меню в шапке',
		'footer_menu' => 'Меню в подвале',
	] );
} );

// Подключение и регистрация сайдбаров
add_action( 'widgets_init', 'register_sidebars' );
function register_sidebars(){

	register_sidebar( array(
		'name'          => "sidebar-1",
		'id'            => "sidebar-1",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => "</li>\n",
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => "</h2>\n",
		'before_sidebar' => '', // WP 5.6
		'after_sidebar'  => '', // WP 5.6
	) );

    register_sidebar( array(
		'name'          => "sidebar-2",
		'id'            => "sidebar-2",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => "</li>\n",
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => "</h2>\n",
		'before_sidebar' => '', // WP 5.6
		'after_sidebar'  => '', // WP 5.6
	) );
}

// Подключение и регистрация кастомных виджетов - ДОПОЛНИТЬ!!!
// https://misha.agency/wordpress/widgets.html
// https://wp-kama.ru/function/register_widget
// Курс по вордпрессу + вукомерсу 10-11 урок


?>









<!-- Сниппеты
<?php the_field(''); ?>

<?php 
    $mainr6 = get_field('main-r6');
if( $mainr6 ): 
    $mainr6_url = $mainr6['url'];
    $mainr6_title = $mainr6['title'];
    $mainr6_target = $mainr6['target'] ? $mainr6['target'] : '_self';
?>

    <a class="" href="<?php echo esc_url( $mainr6_url ); ?>" target="<?php echo esc_attr( $mainr6_target ); ?>"><?php echo esc_html( $mainr6_title ); ?></a>
    
<?php endif ?>

<?php if( have_rows('') ): ?>
    <?php while ( have_rows('') ) : the_row(); 
        $photo = get_sub_field('');
    ?>

        <div>
            <img src="<?php echo $photo ?>" alt=''>
        </div>  

    <?php endwhile ?>
<?php endif ?>

<?php get_template_part('templates/bottom-video') ?>
<?php do_shortcode('templates/bottom-video') ?>


-->