<?php
// ajax поиск по сайту 
add_action('wp_ajax_nopriv_gamesaction', 'loadMorePosts');
add_action('wp_ajax_gamesaction', 'loadMorePosts');



function loadMorePosts()
{
    if (!wp_verify_nonce($_POST['nonce'], 'gamesnonce')) {
        wp_die('Данные отправлены с левого адреса');
    }

    // print_r($_POST);

    $current = absint(max(1, get_query_var('paged') ? get_query_var('paged') : get_query_var('page')));
    $args = array(
        'post_type'      => 'evogames', // Тип записи: post, page, кастомный тип записи 
        'post_status'    => 'publish',
        'meta_key' => 'gamequestion',
        'meta_value' => 'All games',
        'numberposts' => 1,    // кол-во постов на странице
        'posts_per_page' => 1, // кол-во постов на странице
        'nopaging' => false,                // если нужна пагинация
        'paged'  => $current,              // если нужна пагинация
    );


    $allcats = [];
    $allgames = get_terms('Game categories', [
        'hide_empty' => false,
    ]);
    foreach ($allgames as $cat) {
        array_push($allcats, $cat->term_id);
    }


    if ($_POST['tag'] !== 'all') {
        $args += [
            'tax_query' => array(
                array (
                    'taxonomy' => 'Game categories',
                    'field' => 'id',
                    'terms' => ($_POST['tag'] != 'all') ? $_POST['tag'] : $allcats,
                )
            ),
        ];
    }
    if ($_POST['s']) {
        $args += ['s' => $_POST['s']];
    }


    // echo '<pre>';
    // print_r($args);
    // echo '</pre>';


    $newgames = new WP_Query($args);

    if ($newgames->have_posts()) {
        while ($newgames->have_posts()) {
            $newgames->the_post(); ?>


        <?php } ?>

        <div class="posts-navigation">
            <?php
            echo wp_kses_post(
                paginate_links(
                    [
                        // 'format'  => '',
                        // 'base'    => 'http://evoplay/games/%_%' . $tag,
                        'total'   => $newgames->max_num_pages,
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
