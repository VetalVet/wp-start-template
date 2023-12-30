<?php

// ajax поиск по сайту 

add_action('wp_ajax_nopriv_catalogloadmore', 'loadMoreProducts');

add_action('wp_ajax_catalogloadmore', 'loadMoreProducts');







function loadMoreProducts()

{

    if (!wp_verify_nonce($_POST['nonce'], 'catalogsearch-nonce')) {

        wp_die('Данные отправлены с левого адреса');

    }





    $product_common_checked = $_POST['product_common'] ? explode(',', $_POST['product_common']) : false;

    $product_marks_checked = $_POST['product_marks'] ? explode(',', $_POST['product_marks']) : false;

    $product_options_checked = $_POST['product_options'] ? explode(',', $_POST['product_options']) : false;

    $product_freon_checked = $_POST['product_freon'] ? explode(',', $_POST['product_freon']) : false;

    $product_powers_checked = $_POST['product_powers'] ? explode(',', $_POST['product_powers']) : false;





    // $current = absint(max(1, get_query_var('paged') ? get_query_var('paged') : get_query_var('page')));

    $args = array(

        'post_type'      => 'catalog', // Тип записи: post, page, кастомный тип записи 

        'post_status'    => 'publish',

        'numberposts' => 12 - count(get_field('cat2autoprod', 'options')),    // кол-во постов на странице

        'posts_per_page' => 12 - count(get_field('cat2autoprod', 'options')), // кол-во постов на странице

        // 'nopaging' => false,                // если нужна пагинация

        // 'paged'  => $_POST['page'],              // если нужна пагинация



        'meta_key'  => 'power',

        'orderby' => 'meta_value_num',

        // 'meta_type' => 'NUMERIC',

        'order'   => $_POST['sort'] ? $_POST['sort'] : 'DESC',

        // 'offset' => 12 * $_POST['page'],
        'offset' => (12 - count(get_field('cat2autoprod', 'options'))) * $_POST['page'],

        's' => $_POST['s'],

    );





    // Сортировка по характеристикам

    if ($product_common_checked || $product_marks_checked || $product_options_checked || $product_freon_checked || $product_powers_checked) {

        $tax_query = array();

        // tax_query takes an array of arrays.

        if (!array_key_exists('relation', $tax_query)) {

            $tax_query['relation'] = 'AND'; // Use 'AND' for a strict search.

        }



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
        $i = ($_POST['page'] * 12) + 1;

        ob_start();
        $newProducts = '';
        while ($products->have_posts()) :
            $products->the_post();
        ?>
            <article class="item-card-v1 sm" style="order: <?php echo $i; ?>;">
                <a href="<?php the_permalink(); ?>" class="item-card-v1-photo">
                    <?php $image_preview = get_field('image_preview'); ?>
                    <img class="item-card-v1-photo-content lazy" src="<?php echo esc_url($image_preview['url']); ?>" alt="<?php echo esc_attr($image_preview['alt']); ?>" loading="lazy" aria-hidden="true" title="<?php echo esc_attr($image_preview['title']); ?>" />
                </a>



                <div class="item-card-v1-info">

                    <a class="item-card-v1-category" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

                    <a class="item-card-v1-title" href="<?php the_permalink(); ?>">

                        <?php

                        $taxes = [];

                        foreach (wp_get_post_terms(get_the_ID(), 'product_marks') as $tax) {

                            array_push($taxes, $tax->name);

                        }

                        echo implode(', ', $taxes);

                        ?>

                    </a>

                </div>



                <span class="item-card-v1-footer">

                    <span class="item-card-v1-tag">

                        <?php if (get_field('prod_new')) { ?>

                            <span class="item-card-v1-tag-el"><?php pll_e('Новый'); ?></span>

                        <?php } ?>



                        <?php if ($power = get_field('power')) : ?>

                            <span class="item-card-v1-tag-el"><?php echo $power; ?> <?php pll_e('кВт'); ?></span>

                        <?php endif; ?>



                        <?php if ($year = get_field('year')) : ?>

                            <span class="item-card-v1-tag-el"><?php echo esc_html($year); ?> <?php pll_e('год') ?></span>

                        <?php endif; ?>

                    </span>

                    <a class="item-card-v1-btn" href="<?php the_permalink(); ?>">

                        <svg class="item-card-v1-btn-icon">

                            <use href="<?php echo get_template_directory_uri(); ?>/assets/images/svg-sprite/svg-sprite.svg#arrow-r-sm-icon"></use>

                        </svg>

                    </a>

                </span>

            </article>
        <?php $i++; endwhile;

        wp_reset_postdata(); ?>

<?php }
    $newProducts = ob_get_clean();
    $state = '';
    echo json_encode(['code' => 200, 'msg' => 'success', 'products' => $newProducts, 'state' => $state]);
    wp_die();
}

