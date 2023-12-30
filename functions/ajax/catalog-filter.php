<?php
// ajax поиск по сайту 
add_action('wp_ajax_nopriv_catalogaction', 'loadCatalogProducts');
add_action('wp_ajax_catalogaction', 'loadCatalogProducts');



function loadCatalogProducts()
{
    if (!wp_verify_nonce($_POST['nonce'], 'catalogsearch-nonce')) {
        wp_die('Данные отправлены с левого адреса');
    }

    $taxonomy_id = isset($_POST['taxonomy']) ? intval($_POST['taxonomy']) : false;
    // var_dump($taxonomy_id);

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
        // 'nopaging' => false,                // если нужна пагинация
        'paged'  => $_POST['page'] ? $_POST['page'] : $current,              // если нужна пагинация
        // 'paged'  => $current,              // если нужна пагинация

        'meta_key'  => 'power',
        'orderby' => 'meta_value_num',
        // 'meta_type' => 'NUMERIC',
        'order'   => $_POST['sort'],
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

    // print_r($args);

    $products = new WP_Query($args);

    if ($products->have_posts()) {
        $i = ($_POST['page'] * 12) + 1;
        $found_products = [];

        ob_start();
        $newProducts = '';
?>
        <div class="catalog-item" data-found="<?php echo $products->found_posts; ?>">

            <div class="item-grid catalog-grid">
                <?php
                $orders = [];
                print_r(is_tax( 'shop' ));
                if (have_rows('cat2autoprod', 'options')) : ?>
                    <?php while (have_rows('cat2autoprod', 'options')) :
                        the_row();

                        $link = get_sub_field('link');

                        if ($link) :
                            $link_url = $link['url'];
                            $link_title = $link['title'];
                            $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>
                            <a class="item-card-category <?php echo get_sub_field('color') == 'Белый' ? 'invert' : ''; ?>" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" style="order: <?php echo get_sub_field('order'); ?>;">
                                <h2 class="section-heading-m item-card-category-title"><?php echo esc_html($link_title); ?></h2>
                                <?php if ($descr = get_sub_field('descr')) : ?>
                                    <span class="item-card-category-footer">
                                        <span class="item-card-category-note"><?php echo wp_kses_post($descr); ?></span>

                                        <span class="item-card-category-btn">
                                            <svg class="item-card-category-btn-icon">
                                                <use href="<?php echo get_template_directory_uri(); ?>/assets/images/svg-sprite/svg-sprite.svg#arrow-r-big-icon"></use>
                                            </svg>
                                        </span>
                                    </span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                    <?php array_push($orders, get_sub_field('order'));
                    endwhile; ?>
                <?php endif;


                while ($products->have_posts()) :
                    $products->the_post();
                    array_push($found_products, get_the_ID());

                    if (in_array($i, $orders)) {
                        $i++;
                    }
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

                <?php $i++;
                endwhile;
                wp_reset_postdata(); ?>
            </div>

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
                $filterstr .= 'product_powers:' . $_POST['product_powers'] . '|';
            }
            $filterstr .= 'sort:' . $_POST['sort'];

            // echo $current;
            $baselink = get_post_type_archive_link('catalog') . '%_%';
            $formatlink = '?page=%#%' . $filterstr;
            if ($_POST['s']) {
                $baselink = pll_home_url() . '?s=' . $_POST['s'] . '%_%';
                $formatlink = '&page=%#%' . $filterstr;
            }
            if ($taxonomy_id) {
                $baselink = get_term_link( $taxonomy_id, 'shop' ) . '%_%';
                $formatlink = '&page=%#%' . $filterstr;
            }
            if ($products->max_num_pages > 1) { ?>
                <div class="catalog-item-footer">
                    <div class="pagination catalog-item-pagination" data-cur="<?php echo $current; ?>" data-max="<?php echo $products->max_num_pages; ?>">
                        <?php
                        echo wp_kses_post(
                            paginate_links(
                                [
                                    'base'   => $baselink,
                                    'format' => $formatlink,
                                    'total'   => $products->max_num_pages,
                                    'current' => $_POST['page'] ? $_POST['page'] : $current,
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
                    $prevLinkMob = get_post_type_archive_link('catalog') . '?page=' . absint($current - 1)  . $filterstr;
                    $nextLinkMob = get_post_type_archive_link('catalog') . '?page=' . absint($current + 1)  . $filterstr;
                    if (isset($_POST['s'])) {
                        $prevLinkMob = pll_home_url() . '?s=' . $_POST['s'] . '&page=' . absint($current - 1)  . $filterstr;
                        $nextLinkMob = pll_home_url() . '?s=' . $_POST['s'] . '&page=' . absint($current + 1)  . $filterstr;
                    } 
                    if ($taxonomy_id) {
                        $prevLinkMob = get_term_link( $taxonomy_id, 'shop' ) . '?page=' . absint($current - 1)  . $filterstr;
                        $nextLinkMob = get_term_link( $taxonomy_id, 'shop' ) . '?page=' . absint($current + 1)  . $filterstr;
                    }
                    ?>

                    <div class="pagination-mob catalog-item-pagination">
                        <a class="pagination-btn prev <?php echo $current - 1 == 1 ? 'disabled' : '' ?>" href="<?php echo $prevLinkMob; ?>"></a>
                        <div class="pagination-val">
                            <span class="pagination-val-cur"><?php echo $current; ?></span>
                            <span class="pagination-val-all"><?php echo $products->max_num_pages; ?></span>
                        </div>
                        <a class="pagination-btn next <?php echo $products->max_num_pages == $current ? 'disabled' : '' ?>" href="<?php echo $nextLinkMob; ?>"></a>
                    </div>

                    <?php if ($products->max_num_pages > 1) { ?>
                        <button class="btn-acc catalog-item-more"><?php pll_e('Показать еще'); ?></button>
                    <?php } ?>
                </div>
            <?php } ?>

        </div>

        <sidebar class="catalog-filter">

            <div class="catalog-filter-container">
                <div class="catalog-filter-heading"><?php pll_e('Фильтр'); ?></div>

                <?php
                $product_common_active = [];
                $product_marks_active = [];
                $product_options_active = [];
                $product_freon_active = [];
                // print_r($found_products);

                foreach ($found_products as $product) {
                    // echo '<pre>';
                    // print_r(wp_get_post_terms($product, 'product_common'));
                    // print_r(wp_get_post_terms($product, 'product_marks'));
                    // print_r(wp_get_post_terms($product, 'product_options'));
                    // print_r(wp_get_post_terms($product, 'product_freon'));
                    // echo '</pre>';


                    foreach (wp_get_post_terms($product, 'product_common') as $common) {
                        array_push($product_common_active, $common);
                    }

                    foreach (wp_get_post_terms($product, 'product_marks') as $marks) {
                        array_push($product_marks_active, $common);
                    }

                    foreach (wp_get_post_terms($product, 'product_options') as $options) {
                        array_push($product_options_active, $common);
                    }

                    foreach (wp_get_post_terms($product, 'product_freon') as $freon) {
                        array_push($product_freon_active, $common);
                    }
                }

                // echo '<pre>';
                // print_r($product_common_active);
                // echo '</pre>';
                ?>
                <form class="catalog-filter-form" method="post" action="<?php echo get_post_type_archive_link('catalog'); ?>">
                    <!-- <input type="hidden" name="page" value="<?php //echo $current + 1; 
                                                                    ?>"> -->

                    <!-- Характеристики товара -->
                    <?php
                    $common_filters = get_terms(array(
                        'taxonomy' => 'product_common',
                    ));

                    // echo '<pre>';
                    // print_r($common_filters);
                    // echo '</pre>';

                    ?>

                    <?php if ($common_filters) { ?>
                        <section class="catalog-filter-elem product_common">
                            <div class="catalog-filter-elem-body">
                                <?php foreach ($common_filters as $filter) { ?>
                                    <label class="filter-checkbox">
                                        <input <?php echo in_array($filter->term_id, $product_common_checked) ? 'checked' : ''; ?> class="filter-checkbox-input visually-hidden" data-filter-id="<?php echo $filter->term_id; ?>" type="checkbox" name="product_common[]" value="<?php echo $filter->term_id; ?>">
                                        <span class="filter-checkbox-btn"></span>
                                        <span class="filter-checkbox-text"><?php echo $filter->name; ?></span>
                                    </label>
                                <?php } ?>
                            </div>
                        </section>
                    <?php } ?>


                    <!-- Марки -->
                    <?php
                    $product_marks = get_terms(array(
                        'taxonomy' => 'product_marks',
                    ));

                    ?>

                    <?php if ($product_marks) { ?>
                        <section class="catalog-filter-elem product_marks <?php echo $product_marks_checked ? 'active' : ''; ?>">
                            <div class="catalog-filter-elem-head" onclick="toggleFilterDd(this)">
                                <h2 class="catalog-filter-elem-heading"><?php echo get_taxonomy('product_marks')->label; ?> <span class="catalog-filter-elem-heading-val">[<?php echo count($product_marks); ?>]</span></h2>
                            </div>
                            <div class="catalog-filter-elem-body catalog-filter-elem-dd">
                                <?php foreach ($product_marks as $filter) { ?>
                                    <label class="filter-checkbox">
                                        <input <?php echo in_array($filter->term_id, $product_marks_checked) ? 'checked' : ''; ?> class="filter-checkbox-input visually-hidden" data-filter-id="<?php echo $filter->term_id; ?>" type="checkbox" name="product_marks[]" value="<?php echo $filter->term_id; ?>">
                                        <span class="filter-checkbox-btn"></span>
                                        <span class="filter-checkbox-text"><?php echo $filter->name; ?></span>
                                    </label>
                                <?php } ?>
                            </div>
                        </section>
                    <?php } ?>



                    <!-- Мощности -->
                    <?php
                    $product_power = get_terms(array(
                        'taxonomy' => 'product_power',
                        // 'hide_empty' => false
                    ));

                    if ($product_power) { ?>
                        <section class="catalog-filter-elem power_filter <?php echo $product_powers_checked ? 'active' : ''; ?>">
                            <div class="catalog-filter-elem-head" onclick="toggleFilterDd(this)">
                                <h2 class="catalog-filter-elem-heading"><?php echo get_taxonomy('product_power')->label; ?> <span class="catalog-filter-elem-heading-val">[<?php echo count($product_power); ?>]</span></h2>
                            </div>
                            <div class="catalog-filter-elem-body catalog-filter-elem-dd">
                                <?php foreach ($product_power as $filter) { ?>
                                    <label class="filter-checkbox">
                                        <input <?php echo in_array($filter->term_id, $product_powers_checked) ? 'checked' : ''; ?> class="filter-checkbox-input visually-hidden" data-filter-id="<?php echo $filter->term_id; ?>" type="checkbox" name="product_power[]" value="<?php echo $filter->term_id; ?>">
                                        <span class="filter-checkbox-btn"></span>
                                        <span class="filter-checkbox-text"><?php echo $filter->name; ?></span>
                                    </label>
                                <?php } ?>
                            </div>
                        </section>
                    <?php } ?>




                    <!-- Опции -->
                    <?php
                    $product_options = get_terms(array(
                        'taxonomy' => 'product_options',
                        'hide_empty' => false
                    ));

                    ?>
                    <?php if ($product_options) { ?>
                        <section class="catalog-filter-elem product_options <?php echo $product_options_checked ? 'active' : ''; ?>">
                            <div class="catalog-filter-elem-head" onclick="toggleFilterDd(this)">
                                <h2 class="catalog-filter-elem-heading"><?php echo get_taxonomy('product_options')->label; ?> <span class="catalog-filter-elem-heading-val">[<?php echo count($product_options); ?>]</span></h2>
                            </div>
                            <div class="catalog-filter-elem-body catalog-filter-elem-dd">
                                <?php foreach ($product_options as $filter) { ?>
                                    <label class="filter-checkbox">
                                        <input <?php echo in_array($filter->term_id, $product_options_checked) ? 'checked' : ''; ?> class="filter-checkbox-input visually-hidden" data-filter-id="<?php echo $filter->term_id; ?>" type="checkbox" name="product_options[]" value="<?php echo $filter->term_id; ?>">
                                        <span class="filter-checkbox-btn"></span>
                                        <span class="filter-checkbox-text"><?php echo $filter->name; ?></span>
                                    </label>
                                <?php } ?>
                            </div>
                        </section>
                    <?php } ?>


                    <!-- Фреон -->
                    <?php
                    $product_freon = get_terms(array(
                        'taxonomy' => 'product_freon',
                        // 'hide_empty' => false
                    ));
                    ?>
                    <?php if ($product_freon) { ?>
                        <section class="catalog-filter-elem product_freon <?php echo $product_freon_checked ? 'active' : ''; ?>">
                            <div class="catalog-filter-elem-head" onclick="toggleFilterDd(this)">
                                <h2 class="catalog-filter-elem-heading"><?php echo get_taxonomy('product_freon')->label; ?> <span class="catalog-filter-elem-heading-val">[<?php echo count($product_freon); ?>]</span></h2>
                            </div>
                            <div class="catalog-filter-elem-body catalog-filter-elem-dd">
                                <?php foreach ($product_freon as $filter) { ?>
                                    <label class="filter-checkbox">
                                        <input <?php echo in_array($filter->term_id, $product_freon_checked) ? 'checked' : ''; ?> class="filter-checkbox-input visually-hidden" data-filter-id="<?php echo $filter->term_id; ?>" type="checkbox" name="product_freon[]" value="<?php echo $filter->term_id; ?>">
                                        <span class="filter-checkbox-btn"></span>
                                        <span class="filter-checkbox-text"><?php echo $filter->name; ?></span>
                                    </label>
                                <?php } ?>
                            </div>
                        </section>
                    <?php } ?>
                    <button class="hidden_submit" type="submit" style="display:none;"></button>

                    <button class="catalog-filter-reset" type="reset"><?php pll_e('Сбросить фильтр') ?> [<?php echo intval($_POST['chosen_filters']) ?>]</button>
                </form>
            </div>
        </sidebar>

    <?php } else { 
        ob_start();
        $newProducts = '';
        ?>
        <div class="catalog-item" data-found="<?php echo $products->found_posts; ?>">
            <?php pll_e('Товаров не найдено'); ?>
        </div>

        <sidebar class="catalog-filter">

            <div class="catalog-filter-container">
                <div class="catalog-filter-heading"><?php pll_e('Фильтр'); ?></div>

                <?php
                $product_common_active = [];
                $product_marks_active = [];
                $product_options_active = [];
                $product_freon_active = [];
                // print_r($found_products);

                foreach ($found_products as $product) {
                    // echo '<pre>';
                    // print_r(wp_get_post_terms($product, 'product_common'));
                    // print_r(wp_get_post_terms($product, 'product_marks'));
                    // print_r(wp_get_post_terms($product, 'product_options'));
                    // print_r(wp_get_post_terms($product, 'product_freon'));
                    // echo '</pre>';


                    foreach (wp_get_post_terms($product, 'product_common') as $common) {
                        array_push($product_common_active, $common);
                    }

                    foreach (wp_get_post_terms($product, 'product_marks') as $marks) {
                        array_push($product_marks_active, $common);
                    }

                    foreach (wp_get_post_terms($product, 'product_options') as $options) {
                        array_push($product_options_active, $common);
                    }

                    foreach (wp_get_post_terms($product, 'product_freon') as $freon) {
                        array_push($product_freon_active, $common);
                    }
                }

                // echo '<pre>';
                // print_r($product_common_active);
                // echo '</pre>';
                ?>
                <form class="catalog-filter-form" method="post" action="<?php echo get_post_type_archive_link('catalog'); ?>">
                    <!-- <input type="hidden" name="page" value="<?php //echo $current + 1; 
                                                                    ?>"> -->

                    <!-- Характеристики товара -->
                    <?php
                    $common_filters = get_terms(array(
                        'taxonomy' => 'product_common',
                    ));

                    // echo '<pre>';
                    // print_r($common_filters);
                    // echo '</pre>';

                    ?>

                    <?php if ($common_filters) { ?>
                        <section class="catalog-filter-elem product_common">
                            <div class="catalog-filter-elem-body">
                                <?php foreach ($common_filters as $filter) { ?>
                                    <label class="filter-checkbox">
                                        <input <?php echo in_array($filter->term_id, $product_common_checked) ? 'checked' : ''; ?> class="filter-checkbox-input visually-hidden" data-filter-id="<?php echo $filter->term_id; ?>" type="checkbox" name="product_common[]" value="<?php echo $filter->term_id; ?>">
                                        <span class="filter-checkbox-btn"></span>
                                        <span class="filter-checkbox-text"><?php echo $filter->name; ?></span>
                                    </label>
                                <?php } ?>
                            </div>
                        </section>
                    <?php } ?>


                    <!-- Марки -->
                    <?php
                    $product_marks = get_terms(array(
                        'taxonomy' => 'product_marks',
                    ));

                    ?>

                    <?php if ($product_marks) { ?>
                        <section class="catalog-filter-elem product_marks <?php echo $product_marks_checked ? 'active' : ''; ?>">
                            <div class="catalog-filter-elem-head" onclick="toggleFilterDd(this)">
                                <h2 class="catalog-filter-elem-heading"><?php echo get_taxonomy('product_marks')->label; ?> <span class="catalog-filter-elem-heading-val">[<?php echo count($product_marks); ?>]</span></h2>
                            </div>
                            <div class="catalog-filter-elem-body catalog-filter-elem-dd">
                                <?php foreach ($product_marks as $filter) { ?>
                                    <label class="filter-checkbox">
                                        <input <?php echo in_array($filter->term_id, $product_marks_checked) ? 'checked' : ''; ?> class="filter-checkbox-input visually-hidden" data-filter-id="<?php echo $filter->term_id; ?>" type="checkbox" name="product_marks[]" value="<?php echo $filter->term_id; ?>">
                                        <span class="filter-checkbox-btn"></span>
                                        <span class="filter-checkbox-text"><?php echo $filter->name; ?></span>
                                    </label>
                                <?php } ?>
                            </div>
                        </section>
                    <?php } ?>



                    <!-- Мощности -->
                    <?php
                    $product_power = get_terms(array(
                        'taxonomy' => 'product_power',
                        // 'hide_empty' => false
                    ));

                    if ($product_power) { ?>
                        <section class="catalog-filter-elem power_filter <?php echo $product_powers_checked ? 'active' : ''; ?>">
                            <div class="catalog-filter-elem-head" onclick="toggleFilterDd(this)">
                                <h2 class="catalog-filter-elem-heading"><?php echo get_taxonomy('product_power')->label; ?> <span class="catalog-filter-elem-heading-val">[<?php echo count($product_power); ?>]</span></h2>
                            </div>
                            <div class="catalog-filter-elem-body catalog-filter-elem-dd">
                                <?php foreach ($product_power as $filter) { ?>
                                    <label class="filter-checkbox">
                                        <input <?php echo in_array($filter->term_id, $product_powers_checked) ? 'checked' : ''; ?> class="filter-checkbox-input visually-hidden" data-filter-id="<?php echo $filter->term_id; ?>" type="checkbox" name="product_power[]" value="<?php echo $filter->term_id; ?>">
                                        <span class="filter-checkbox-btn"></span>
                                        <span class="filter-checkbox-text"><?php echo $filter->name; ?></span>
                                    </label>
                                <?php } ?>
                            </div>
                        </section>
                    <?php } ?>




                    <!-- Опции -->
                    <?php
                    $product_options = get_terms(array(
                        'taxonomy' => 'product_options',
                        'hide_empty' => false
                    ));

                    ?>
                    <?php if ($product_options) { ?>
                        <section class="catalog-filter-elem product_options <?php echo $product_options_checked ? 'active' : ''; ?>">
                            <div class="catalog-filter-elem-head" onclick="toggleFilterDd(this)">
                                <h2 class="catalog-filter-elem-heading"><?php echo get_taxonomy('product_options')->label; ?> <span class="catalog-filter-elem-heading-val">[<?php echo count($product_options); ?>]</span></h2>
                            </div>
                            <div class="catalog-filter-elem-body catalog-filter-elem-dd">
                                <?php foreach ($product_options as $filter) { ?>
                                    <label class="filter-checkbox">
                                        <input <?php echo in_array($filter->term_id, $product_options_checked) ? 'checked' : ''; ?> class="filter-checkbox-input visually-hidden" data-filter-id="<?php echo $filter->term_id; ?>" type="checkbox" name="product_options[]" value="<?php echo $filter->term_id; ?>">
                                        <span class="filter-checkbox-btn"></span>
                                        <span class="filter-checkbox-text"><?php echo $filter->name; ?></span>
                                    </label>
                                <?php } ?>
                            </div>
                        </section>
                    <?php } ?>


                    <!-- Фреон -->
                    <?php
                    $product_freon = get_terms(array(
                        'taxonomy' => 'product_freon',
                        // 'hide_empty' => false
                    ));
                    ?>
                    <?php if ($product_freon) { ?>
                        <section class="catalog-filter-elem product_freon <?php echo $product_freon_checked ? 'active' : ''; ?>">
                            <div class="catalog-filter-elem-head" onclick="toggleFilterDd(this)">
                                <h2 class="catalog-filter-elem-heading"><?php echo get_taxonomy('product_freon')->label; ?> <span class="catalog-filter-elem-heading-val">[<?php echo count($product_freon); ?>]</span></h2>
                            </div>
                            <div class="catalog-filter-elem-body catalog-filter-elem-dd">
                                <?php foreach ($product_freon as $filter) { ?>
                                    <label class="filter-checkbox">
                                        <input <?php echo in_array($filter->term_id, $product_freon_checked) ? 'checked' : ''; ?> class="filter-checkbox-input visually-hidden" data-filter-id="<?php echo $filter->term_id; ?>" type="checkbox" name="product_freon[]" value="<?php echo $filter->term_id; ?>">
                                        <span class="filter-checkbox-btn"></span>
                                        <span class="filter-checkbox-text"><?php echo $filter->name; ?></span>
                                    </label>
                                <?php } ?>
                            </div>
                        </section>
                    <?php } ?>
                    <button class="hidden_submit" type="submit" style="display:none;"></button>

                    <button class="catalog-filter-reset" type="reset"><?php pll_e('Сбросить фильтр') ?> [<?php echo intval($_POST['chosen_filters']) ?>]</button>
                </form>
            </div>
        </sidebar>
<?php }
    $newProducts = ob_get_clean();
    $state = '?page=1' . $filterstr;
    echo json_encode(['code' => 200, 'msg' => 'success', 'products' => $newProducts, 'state' => $state]);
    wp_die();
}
