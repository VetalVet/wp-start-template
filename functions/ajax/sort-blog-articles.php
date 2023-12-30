<?php
// ajax поиск по сайту 
add_action('wp_ajax_nopriv_sort_articles', 'sortArticles');
add_action('wp_ajax_sort_articles', 'sortArticles');

function sortArticles(){
    if (!wp_verify_nonce($_POST['nonce'], 'articles-nonce')) {
        wp_die('Данные отправлены с левого адреса');
    }

    $current = absint(max(1, get_query_var('paged') ? get_query_var('paged') : get_query_var('page')));
    $args = array(
        'post_type'      => 'post',         // тип поста
        'post_status'    => 'publish',
        'numberposts' => 9,    // кол-во постов на странице
        'posts_per_page' => 9, // кол-во постов на странице
        'nopaging' => false,                // если нужна пагинация
        'paged'  => $current,                // если нужна пагинация 
    );

    // var_dump($_POST);

    if($_POST['popular'] == '1'){
        $args['meta_key'] = 'post_views_count';
        $args['orderby'] = 'meta_value';
        $args['order'] = 'DESC';
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) { ?>
        <div class="item-grid">
            <?php while ($query->have_posts()) {
                $query->the_post();
            ?>
                <article class="item-card-v1">
                    <span class="item-card-v1-photo">
                        <img class="item-card-v1-photo-content lazy" src="<?php the_post_thumbnail_url('product-thumb'); ?>" loading="lazy" aria-hidden="true" alt="">
                    </span>
                    <div class="item-card-v1-info">
                        <a class="item-card-v1-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </div>
                    <!-- кол-во просмотров: <?php //echo getPostViews(get_the_ID()); ?> -->
                    <span class="item-card-v1-footer">
                        <span class="item-card-v1-footer-text"><?php echo get_the_date('d F Y'); ?></span>
                        <a class="item-card-v1-btn" href="<?php the_permalink(); ?>">
                            <svg class="item-card-v1-btn-icon">
                                <use href="<?php echo get_template_directory_uri(); ?>/assets/images/svg-sprite/svg-sprite.svg#arrow-r-sm-icon"></use>
                            </svg>
                        </a>
                    </span>
                </article>
            <?php
                }
                wp_reset_postdata(); // сбрасываем переменную $post
            ?>
        </div>
        <div class="catalog-item-footer">
            <div class="pagination catalog-item-pagination"> 
                <?php
                echo wp_kses_post(
                    paginate_links(
                        [
                            'base'   => get_the_permalink() . '?page=%#%',
                            'format' => '?page=%#%',
                            'total'   => $query->max_num_pages,
                            'current' => $current,
                            'prev_text' => '',
                            'next_text' => '',
                            'mid_size'  => 3,
                        ]
                    )
                );
                ?>
            </div>

            <div class="pagination-mob catalog-item-pagination">
                <a class="pagination-btn prev <?php echo $current == 1 ? 'disabled' : '' ?>" href="<?php echo get_term_link(pll_get_term(get_queried_object()->term_id)) . '?page=' . absint($current - 1); ?>">
                    <!-- <svg class="pagination-btn-icon">
                        <use href="<?php //echo get_template_directory_uri(); ?>/assets/images/svg-sprite/svg-sprite.svg#arrow-l-pagination"></use>
                    </svg> -->
                </a>

                <div class="pagination-val">
                    <span class="pagination-val-cur"><?php echo $current; ?></span>
                    <span class="pagination-val-all"><?php echo $query->max_num_pages; ?></span>
                </div>

                <a class="pagination-btn next <?php echo $query->max_num_pages == $current ? 'disabled' : '' ?>" href="<?php echo get_term_link(pll_get_term(get_queried_object()->term_id)) . '?page=' . absint($current + 1); ?>">
                    <!-- <svg class="pagination-btn-icon">
                        <use href="<?php //echo get_template_directory_uri(); ?>/assets/images/svg-sprite/svg-sprite.svg#arrow-r-pagination"></use>
                    </svg> -->
                </a>
            </div>
        </div>
    <?php } 

    wp_die();
}