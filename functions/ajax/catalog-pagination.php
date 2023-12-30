<?php

// ajax поиск по сайту 

add_action('wp_ajax_nopriv_catalogpagination', 'updatePagination');

add_action('wp_ajax_catalogpagination', 'updatePagination');







function updatePagination()

{

    if (!wp_verify_nonce($_POST['nonce'], 'catalogsearch-nonce')) {

        wp_die('Данные отправлены с левого адреса');
    }


    $taxonomy_id = isset($_POST['taxonomy']) ? intval($_POST['taxonomy']) : false;



    $product_common_checked = $_POST['product_common'] ? explode(',', $_POST['product_common']) : false;

    $product_marks_checked = $_POST['product_marks'] ? explode(',', $_POST['product_marks']) : false;

    $product_options_checked = $_POST['product_options'] ? explode(',', $_POST['product_options']) : false;

    $product_freon_checked = $_POST['product_freon'] ? explode(',', $_POST['product_freon']) : false;

    $product_powers_checked = $_POST['product_powers'] ? explode(',', $_POST['product_powers']) : false;




    $current = absint(max(1, get_query_var('paged') ? get_query_var('paged') : get_query_var('page')));

    $args = array(

        'post_type'      => 'catalog', // Тип записи: post, page, кастомный тип записи 

        'post_status'    => 'publish',

        'numberposts' => 12 - count(get_field('cat2autoprod', 'options')),    // кол-во постов на странице

        'posts_per_page' => 12 - count(get_field('cat2autoprod', 'options')), // кол-во постов на странице

        'nopaging' => false,                // если нужна пагинация

        'paged'  => $_POST['page'] ? $_POST['page'] : $current,              // если нужна пагинация



        'meta_key'  => 'power',

        'orderby' => 'meta_value_num',

        // 'meta_type' => 'NUMERIC',

        'order'   => $_POST['sort'] ? $_POST['sort'] : 'DESC',
        'offset' => (12 - count(get_field('cat2autoprod', 'options'))) * $_POST['page'],
        // 'offset' => 12 * $_POST['page'],
        's' => $_POST['s'],
    );


    // Сортировка по характеристикам
    $tax_query = array();

    // tax_query takes an array of arrays.
    if (!array_key_exists('relation', $tax_query)) {
        $tax_query['relation'] = 'AND'; // Use 'AND' for a strict search.
    }

    if($taxonomy_id){
        array_push(
            $tax_query,
            array(
                'taxonomy' => 'shop', // Taxonomy.
                'field' => 'term_id', // Select by 'id' or 'slug'
                'terms' => $taxonomy_id, // Taxonomy term(s).
            )
        );
    }

    // echo $_POST['page'];
    // echo $current;

    // Сортировка по характеристикам

    if ($product_common_checked || $product_marks_checked || $product_options_checked || $product_freon_checked || $product_powers_checked) {



        if ($product_common_checked) {

            array_push(

                $tax_query,

                array(

                    'taxonomy' => 'product_common', // Taxonomy.

                    'field' => 'term_id', // Select by 'id' or 'slug'

                    'terms' => $product_common_checked, // Taxonomy term(s).

                )

            );
        }



        if ($product_marks_checked) {

            array_push(

                $tax_query,

                array(

                    'taxonomy' => 'product_marks', // Taxonomy.

                    'field' => 'term_id', // Select by 'id' or 'slug'

                    'terms' => $product_marks_checked, // Taxonomy term(s).

                )

            );
        }



        if ($product_options_checked) {

            array_push(

                $tax_query,

                array(

                    'taxonomy' => 'product_options', // Taxonomy.

                    'field' => 'term_id', // Select by 'id' or 'slug'

                    'terms' => $product_options_checked, // Taxonomy term(s).

                )

            );
        }



        if ($product_freon_checked) {

            array_push(

                $tax_query,

                array(

                    'taxonomy' => 'product_freon', // Taxonomy.

                    'field' => 'term_id', // Select by 'id' or 'slug'

                    'terms' => $product_freon_checked, // Taxonomy term(s).

                )

            );
        }



        if ($product_powers_checked) {

            array_push(

                $tax_query,

                array(

                    'taxonomy' => 'product_power', // Taxonomy.

                    'field' => 'term_id', // Select by 'id' or 'slug'

                    'terms' => $product_powers_checked, // Taxonomy term(s).

                )

            );
        }
    }



    if (!empty($tax_query)) {

        $args['tax_query'] = $tax_query;
    }



    $products = new WP_Query($args);



    if ($products->have_posts()) {
        
        ob_start();
        $newProducts = '';

        // var_dump($products->max_num_pages);
        if ($products->max_num_pages > $_POST['page']) { ?>

            <div class="pagination catalog-item-pagination" data-filters="<?php echo intval($_POST['chosen_filters']) ?>" data-found="<?php echo $products->found_posts; ?>" data-cur="<?php echo $_POST['page'] + 1; ?>" data-max="<?php echo $products->max_num_pages; ?>">

                <?php
                $filterstr = '&filter=';
                if ($product_common_checked) {
                    $filterstr .= 'product_common:' . $_POST['product_common'] . '|';
                }
                if ($product_marks_checked) {
                    $filterstr .= 'product_marks:' . $_POST['product_marks'] . '|';
                }
                if ($product_options_checked) {
                    $filterstr .= 'product_options:' . $_POST['product_options'] . '|';
                }
                if ($product_freon_checked) {
                    $filterstr .= 'product_freon:' . $_POST['product_freon'] . '|';
                }
                if ($product_powers_checked) {
                    $filterstr .= 'product_power:' . $_POST['product_powers'] . '|';
                }
                $filterstr .= 'sort:' . $_POST['sort'];

                $baselink = get_post_type_archive_link( 'catalog' ) . '%_%';
                $formatlink = '?page=%#%' . $filterstr;
                if($_POST['s']){
                    $baselink = pll_home_url() . '?s=' . $_POST['s'] . '%_%';
                    $formatlink = '&page=%#%' . $filterstr;
                }
                if ($taxonomy_id) {
                    $baselink = get_term_link( $taxonomy_id, 'shop' ) . '%_%';
                    $formatlink = '&page=%#%' . $filterstr;
                }
                
                echo wp_kses_post(
                    paginate_links(
                        [
                            'base'   => $baselink,
                            'format' => $formatlink,
                            'total'   => $products->max_num_pages,
                            'current' => $_POST['page'] + 1,
                            'prev_text' => '',
                            'next_text' => '',
                            'mid_size' => 2,
                            'end_size' => 2,
                            'prev_next' => true,
                        ]
                    )
                );
                ?>
            </div>

            <?php
            $nextNum = $_POST['page'] + 2;
            $prevNum = $_POST['page'];

            $prevLinkMob = get_post_type_archive_link('catalog') . '?page=' . $prevNum . $filterstr;
            $nextLinkMob = get_post_type_archive_link('catalog') . '?page=' . $nextNum . $filterstr;
            if(isset($_POST['s'])){
                $prevLinkMob = pll_home_url() . '?s=' . $_POST['s'] . '&page=' . $prevNum . $filterstr;
                $nextLinkMob = pll_home_url() . '?s=' . $_POST['s'] . '&page=' . $nextNum . $filterstr;
            } 
            if ($taxonomy_id) {
                $prevLinkMob = get_term_link( $taxonomy_id, 'shop' ) . '?page=' . $prevNum . $filterstr;
                $nextLinkMob = get_term_link( $taxonomy_id, 'shop' ) . '?page=' . $nextNum . $filterstr;
            }
            ?>

            <div class="pagination-mob catalog-item-pagination">
                <a class="pagination-btn prev <?php echo $_POST['page'] == 1 ? 'disabled' : '' ?>" href="<?php echo $prevLinkMob; ?>"></a>
                <div class="pagination-val">
                    <span class="pagination-val-cur"><?php echo $_POST['page'] + 1; ?></span>
                    <span class="pagination-val-all"><?php echo $products->max_num_pages; ?></span>
                </div>
                <a class="pagination-btn next <?php echo $products->max_num_pages == $_POST['page'] + 1 ? 'disabled' : '' ?>" href="<?php echo $nextLinkMob; ?>"></a>
            </div>

        <?php } ?>
<?php }

    $newProducts = ob_get_clean();
    $state = '?page=' . ($_POST['page'] + 1) . $filterstr;
    echo json_encode(['code' => 200, 'msg' => 'success', 'products' => $newProducts, 'state' => $state]);
    wp_die();
}
