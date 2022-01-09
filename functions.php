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

// Подключение своих php скриптов
require get_template_directory_uri() . 'functions/ajax-search.php';



//=====================================================================
// index.php
if(is_page_template('index.php')){
    wp_enqueue_style('index-style', get_template_directory_uri() . '/assets/css/index.css');

    wp_enqueue_script('index-scripts', get_template_directory_uri() . '/assets/js/index.js', array(), null, true);
}
//=====================================================================

    

add_theme_support('menus');
add_theme_support('custom-logo');




# Подсветка результатов поиска 
add_filter('the_content', 'search_results_hightlight');
add_filter('the_excerpt', 'search_results_hightlight');
add_filter('the_title', 'search_results_hightlight');

function search_results_hightlight($text){
    // цвета 
    $styles = [
        '',
        'color: #000; background: #98fd65;',
        'color: #000; background: #ffcc56;',
        'color: #000; background: #98cefa;',
        'color: #000; background: #fd9897;',
        'color: #000; background: #df7dca;',
    ];

    // только для страницы поиска 
    if (!is_search())
        return $text;

    $query_terms = get_query_var('search_terms');

    if (empty($query_terms))
        $query_terms = array_filter([get_query_var('s')]);

    if (empty($query_terms))
        return $text;

    $n = 0;
    foreach ($query_terms as $term) {
        $n++;

        $term = preg_quote($term, '/');
        $text = preg_replace_callback("/$term/iu", function ($match) use ($styles, $n) {
            return '<span style="' . $styles[$n] . '">' . $match[0] . '</span>';
        }, $text);
    }

    return $text;
}



// Подключение меню
add_action( 'after_setup_theme', function(){
	register_nav_menus( [
		'header_menu' => 'Меню в шапке',
		'footer_menu' => 'Меню в подвале',
	] );
} );


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



<?php 
    $my_posts = get_posts( array(
        'numberposts' => 1,
        'category'    => 10,
        'orderby'     => 'date',
        'order'       => 'DESC',
        'post_type'   => 'post',
        'suppress_filters' => true,
    ) );
    
    foreach( $my_posts as $post ){
        setup_postdata( $post );
        ?>
            <div>
                
            </div>
        <?php
    }
    wp_reset_postdata(); 
?> 



<?php
    $current = absint( max( 1, 
        get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' )) ); // текущая страница
    $category = get_field(''); // номер рубрики
    $quantity = get_field(''); // кол-во постов на странице

    $query = new WP_Query( array(
        'post_type'      => 'post',
        'numberposts' => $quantity,
        'posts_per_page' => $quantity,
        'cat' => $category,
        'nopaging' => false,
        'paged'  => $current
    ));
    if( $query->have_posts() ){
        while( $query->have_posts() ){
            $query->the_post();
            ?>

                <div>
                    
                </div>
                    
            <?php
        }
        wp_reset_postdata(); // сбрасываем переменную $post
    }
?>

<div class="pagination">
    <?php
        echo wp_kses_post(
            paginate_links(
            [
                'total'   => $query->max_num_pages,
                'current' => $current,
            ]
            )
        );
    ?>
</div>





-->