<?php get_header(); ?>

<!-- <?php get_template_part('templates/title') ?> -->

<?php
    $postsQuantity = the_field('');
    $cat = get_the_category()->term_id;
    $authorID = get_post($id)->post_author;
    $current = absint( max( 1, get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' )) );
    $query = new WP_Query( array(
        'post_type'      => 'post',         // тип поста
        'numberposts' => $postsQuantity,    // кол-во постов на странице
        'posts_per_page' => $postsQuantity, // кол-во постов на странице
        'cat' => $cat,                      // ID рубрики
        'author' => $authorID,              // ID автора
        'nopaging' => false,                // если нужна пагинация
        'paged'  => $current                // если нужна пагинация
    ) );
    if( $query->have_posts() ){
        while( $query->have_posts() ){
            $query->the_post();
            ?>
                <!-- вывод категории -->
                <div class=""><?php echo get_the_category()[0]->name; ?></div>

                <!-- вывод ссылки на пост с заголовком -->
                <a class="" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

                <!-- вывод контента поста -->
                <?php the_content(); ?>

                <!-- вывод аватарки -->
                <?php
                    global $post;
                    $url = get_avatar_url( $post, "size=50");
                    $img = '<img alt="" src="'. $url .'">';
                    echo $img;
                ?>

                <!-- вывод автора поста -->
                <?php the_author(); ?>

                <!-- вывод даты публикации поста -->
                <?php echo get_the_date(); ?>



                <!-- Сама вёрстка страницы -->


                
            <?php
        }
        wp_reset_postdata(); // сбрасываем переменную $post
    }
?>

    <!-- пагинация -->
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

<?php get_footer(); ?>