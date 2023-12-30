<?php
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    //Интеграция WooCommerce Шаблона

    // Здесь писать свои функции вывода вёрстки для WooCommerce хуков
    function get_filtered_price()
    {
        global $wpdb;

        $args       = wc()->query->get_main_query();

        $tax_query  = isset($args->tax_query->queries) ? $args->tax_query->queries : array();
        $meta_query = isset($args->query_vars['meta_query']) ? $args->query_vars['meta_query'] : array();

        foreach ($meta_query + $tax_query as $key => $query) {
            if (!empty($query['price_filter']) || !empty($query['rating_filter'])) {
                unset($meta_query[$key]);
            }
        }

        $meta_query = new \WP_Meta_Query($meta_query);
        $tax_query  = new \WP_Tax_Query($tax_query);

        $meta_query_sql = $meta_query->get_sql('post', $wpdb->posts, 'ID');
        $tax_query_sql  = $tax_query->get_sql($wpdb->posts, 'ID');

        $sql  = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
        $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
        $sql .= " 	WHERE {$wpdb->posts}.post_type IN ('product')
                AND {$wpdb->posts}.post_status = 'publish'
                AND price_meta.meta_key IN ('_price')
                AND price_meta.meta_value > '' ";
        $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

        $search = \WC_Query::get_main_search_query_sql();
        if ($search) {
            $sql .= ' AND ' . $search;
        }

        $prices = $wpdb->get_row($sql); // WPCS: unprepared SQL ok.

        return [
            'min' => floor($prices->min_price),
            'max' => ceil($prices->max_price)
        ];
    }

    function display_shop_filters()
    {
        ob_start(); ?>

        <aside class="catalog__aside">
            <div class="catalog__filters" data-spollers="992,max" data-one-spoller="">
                <div class="catalog__filters-trigger" tabindex="-1" type="button" data-spoller="">
                    <svg width="30" height="30">
                        <use href='<?php echo get_template_directory_uri(); ?>/assets/build/img/sprite/sprite.svg#filter'>
                    </svg>
                    Products Filter
                </div>

                <ul class="catalog__filters-content filters">
                    <li class="filters__item">
                        <span class="filters__head">Price</span>

                        <div class="filters__range range">
                            <div class="range__inputs">
                                <label class="range__label">
                                    <input class="range__input" type="number" min="<?php echo get_filtered_price()['min']; ?>" max="<?php echo get_filtered_price()['max']; ?>" value="<?php echo get_filtered_price()['min']; ?>" id="range-min">
                                </label>

                                <div class="range__separator">-</div>

                                <label class="range__label">
                                    <input class="range__input" type="number" min="<?php echo get_filtered_price()['min']; ?>" max="<?php echo get_filtered_price()['max']; ?>" value="<?php echo get_filtered_price()['max']; ?>" id="range-max">
                                </label>
                            </div>

                            <div class="range__slider" id="range-slider"></div>
                        </div>
                    </li>

                    <?php
                    $taxonomies = get_taxonomies(['object_type' => ['product']]);

                    foreach ($taxonomies as $attr) {
                        if ($attr == 'product_type' || $attr == 'product_cat' || $attr == 'product_tag') continue;

                        $attrs = get_terms(array(
                            'taxonomy' => $attr,
                            'hide_empty' => false,
                        ));

                        if ($attrs) { ?>
                            <li class="filters__item">
                                <span class="filters__head"><?php print_r(get_taxonomy($attr)->labels->name_admin_bar); ?></span>
                                <ul class="filters__list <?php echo $attr; ?>">
                                    <?php foreach ($attrs as $attribute) { ?>
                                        <li class="filters__list-item">
                                            <label>
                                                <input class="filters__input" data-id="<?php echo $attribute->term_id; ?>" type="checkbox" name="pa_lamp-intensity[]">
                                                <span class="filters__checkbox"><?php echo $attribute->name . '(' . $attribute->count . ')'; ?></span>
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                    <?php }
                    } ?>
                </ul>
            </div>
        </aside>

    <?php
        echo ob_get_clean();
    }

    function get_product_title()
    {
        ob_start(); ?>
        <div class="card__title"><?php echo get_the_title(); ?></div>
    <?php
        echo ob_get_clean();
    }

    // вывести звёздный рейтинг 
    function get_star_rating()
    {
        global $post, $product;
        $rating_count = $product->get_rating_count(); // кол-во комментов
        $review_count = $product->get_review_count(); // 
        $average      = $product->get_average_rating();

        if ($rating_count > 0) {
            $title = sprintf(__('Оценка %s из 5', 'woocommerce'), $average);
        } else {
            $title = 'No reviews';
            $rating = 0;
        }

        echo '<div class="star-rating">';
        echo '<span style="width:' . (($rating_count / 5) * 100) . '%"><strong class="rating">' . $average . '</strong> ' . __('из 5', 'woocommerce') . '</span>';
        echo '</div>';
        echo '<div class="rate" style="background: url(http://wayup/wp-content/uploads/2022/06/star-fill.svg) left center; width:' . (($average / 5) * 95) . 'px !important; max-width: 95px !important;"></div>';
    }

    // вывести % скидки товара
    // function show_discount()
    // {
    //     if (!defined('ABSPATH')) {
    //         exit; // Exit if accessed directly
    //     }

    //     global $post, $product;

    //     if ($product->is_on_sale()) :
    //         $price = get_post_meta(get_the_ID(), '_regular_price', true);
    //         $sale = get_post_meta(get_the_ID(), '_price', true);
    //         $discount = floor(100 - (($sale / $price) * 100)) . '%';

    //         echo '<span class="discount">' . $discount . '</span>';
    //     endif;
    // }
    function display_price()
    {
        ob_start();
        global $product;
        //if ($product->is_on_sale()) :
            // $price = get_post_meta(get_the_ID(), '_regular_price', true);
            // $sale = get_post_meta(get_the_ID(), '_price', true);
            // $discount = floor(100 - (($sale / $price) * 100)) . '%';


            if ($product->get_regular_price()) {
                if ($product->get_sale_price()) { ?>
                    <div class="card__pricing">
                        <span class="card__pricing-before"><?php echo get_woocommerce_currency_symbol() . $product->get_regular_price(); ?></span>
                        <span class="card__pricing-current"><?php echo get_woocommerce_currency_symbol() . $product->get_sale_price(); ?></span>
                    </div>
                <?php } else { ?>
                    <div class="card__pricing">
                        <span class="card__pricing-current"><?php echo get_woocommerce_currency_symbol() . $product->get_regular_price(); ?></span>
                    </div>
                <?php } ?>
            <?php }
            // echo '<div class="card__pricing">';
            // echo '<span class="card__pricing-before">' . get_woocommerce_currency_symbol() . $price . '</span>';
            // echo '<span class="card__pricing-current">' . get_woocommerce_currency_symbol() . $sale . '</span>';
            // echo '</div>';
        //endif;

        return ob_get_contents();
    }

    function display_rating()
    {
        global $product;
        // $rating_count = $product->get_rating_count(); // кол-во комментов
        $review_count = $product->get_review_count(); // 
        $average      = ceil($product->get_average_rating()); // кол-во звёзд
    ?>
        <div class="card__rating">
            <?php for ($i = 0; $i < $average; $i++) { ?>
                <svg width="14" height="14" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 0L13.4697 7.60081H21.4616L14.996 12.2984L17.4656 19.8992L11 15.2016L4.53436 19.8992L7.00402 12.2984L0.538379 7.60081H8.53035L11 0Z" fill="#FFA200"></path>
                </svg>
            <?php } ?>

            <?php for ($i = 0; $i < 5 - $average; $i++) { ?>
                <svg width="14" height="14" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 0L13.4697 7.60081H21.4616L14.996 12.2984L17.4656 19.8992L11 15.2016L4.53436 19.8992L7.00402 12.2984L0.538379 7.60081H8.53035L11 0Z" fill="#000"></path>
                </svg>
            <?php } ?>
        </div>

        <div class="card__reviews">(<?php echo $review_count; ?>) reviews</div>
<?php }



    // Удаление/Подключение/Переподключение хуков
    // archive-product.php
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
    add_action('woocommerce_before_main_content', 'get_breadcrumbs', 20);

    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);



    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    add_action('woocommerce_sidebar', 'display_shop_filters', 10);

    // content-product.php
    remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);

    remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
    add_action('woocommerce_shop_loop_item_title', 'get_product_title', 10);

    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);

    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
    add_action('woocommerce_after_shop_loop_item_title', 'display_price', 10);
    add_action('woocommerce_after_shop_loop_item_title', 'display_rating', 15);

    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);


    // single-product.php
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
    add_action('woocommerce_before_main_content', 'get_breadcrumbs', 20);



    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

    // remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);



    // content-single-product.php
    remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);



    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
    remove_action('woocommerce_single_product_summary', 'generate_product_data', 60);
    // add_action( 'woocommerce_single_product_summary', 'get_star_rating', 10);


    // remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);



    add_action('woocommerce_before_checkout_form', 'open_checkout_div', 1);
    add_action('woocommerce_after_checkout_form', 'close_checkout_div', 1);
    
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 ); 


    function open_checkout_div() {
        echo '<div class="open_checkout">';
    }
    function close_checkout_div() {
        echo '</div>';
    }

    
}
