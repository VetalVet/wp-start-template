<?php get_header(); ?>

<!-- Для секции с заголовком -->
<!-- <?php get_template_part('templates/title') ?> -->


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
        
        <div <?php post_class(); ?>>
            <!-- 
                Вёрстка поста с post type: some
            -->
        </div>
<?php
    // Для комментариев
    if ( comments_open() || get_comments_number() ) :
        comments_template();
    endif;
?>

<?php get_footer(); ?>