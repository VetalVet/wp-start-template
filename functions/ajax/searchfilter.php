<?php
// ajax поиск по сайту 
add_action('wp_ajax_nopriv_searchajax', 'filtertags');
add_action('wp_ajax_searchajax', 'filtertags');



function filtertags()
{
    if (!wp_verify_nonce($_POST['nonce'], 'searchtags-nonce')) {
        wp_die('Данные отправлены с левого адреса');
    }

    // print_r($_POST);

    $current = absint(max(1, get_query_var('paged') ? get_query_var('paged') : get_query_var('page')));
    $args = array(
        'post_type'      => 'blog', // Тип записи: post, page, кастомный тип записи 
        'post_status'    => 'publish',
        'numberposts' => 1,    // кол-во постов на странице
        'posts_per_page' => 1, // кол-во постов на странице
        'nopaging' => false,                // если нужна пагинация
        'paged'  => $current                // если нужна пагинация
    );

    if($_POST['tag'] != 'all'){
        $args += ['tag' => $_POST['tag']];
    }
    if($_POST['s']){
        $args += ['s' => $_POST['s']];
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); ?>

            <div class="blog__post post">
                <a href="<?php the_permalink(); ?>" class="post__image"><?php the_post_thumbnail(); ?></a>
                <div class="post__card">
                    <div class="post__info">
                        <div class="post__info-time">
                            <div class="post__date"><?php echo get_the_date('Y M'); ?></div>
                            <div class="post__readingtime">5 min read</div>
                        </div>
                        <div class="post__category"><?php the_tags(''); ?></div>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="post__title"><?php the_title(); ?></a>
                    <div class="post__excerpt"><?php the_excerpt(); ?></div>
                    <a href="<?php the_permalink(); ?>" class="post__link more-link">READ MORE <span class="arrow"></span></a>
                </div>
            </div>

        <?php } ?>
        
        <?php 
        $tag = $_POST['tag'] ? '?tag=' . $_POST['tag'] : ''
        ?>
        <div class="posts-navigation">
            <?php
            echo wp_kses_post(
                paginate_links(
                    [
                        // 'format'  => '',
                        'base'    => 'http://v112943.hostnl4.fornex.host/genense.com/blog/%_%' . $tag,
                        'total'   => $query->max_num_pages,
                        'current' => $current,
                    ]
                )
            );
            ?>
        </div> 
    <?php } else { ?>
        No articles
<?php }
    wp_die();
}
