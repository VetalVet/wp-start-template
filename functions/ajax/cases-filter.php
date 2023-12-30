<?php
// ajax поиск по сайту 
add_action('wp_ajax_nopriv_filter_cases', 'filterCases');
add_action('wp_ajax_filter_cases', 'filterCases');



function filterCases()
{
    if (!wp_verify_nonce($_POST['nonce'], 'project-nonce')) {
        wp_die('Данные отправлены с левого адреса');
    }

    // var_dump($_POST);

    $cases_type = $_POST['cases_type'] ? explode(',', $_POST['cases_type']) : false;
    $cases_country = $_POST['cases_country'] ? explode(',', $_POST['cases_country']) : false;

    $current = absint(max(1, get_query_var('paged') ? get_query_var('paged') : get_query_var('page')));
    $args = array(
        'post_type'      => 'project', // Тип записи: post, page, кастомный тип записи 
        'post_status'    => 'publish',
        'numberposts' => 9,    // кол-во постов на странице
        'posts_per_page' => 9, // кол-во постов на странице
        'nopaging' => false,                // если нужна пагинация
        // 'paged'  => $_POST['page'] ? $_POST['page'] : $current,              // если нужна пагинация
        'paged'  => $current,              // если нужна пагинация
    );


    // Сортировка по характеристикам
    if ($cases_type || $cases_country) {
        $tax_query = array();
        // tax_query takes an array of arrays.
        if (!array_key_exists('relation', $tax_query)) {
            $tax_query['relation'] = 'AND'; // Use 'AND' for a strict search.
        }

        if ($cases_type) {
            array_push(
                $tax_query,
                array(
                    'taxonomy' => 'cases_type', // Taxonomy.
                    'field' => 'term_id', // Select by 'id' or 'slug'
                    'terms' => $cases_type, // Taxonomy term(s).
                )
            );
        }

        if ($cases_country) {
            array_push(
                $tax_query,
                array(
                    'taxonomy' => 'cases_country', // Taxonomy.
                    'field' => 'term_id', // Select by 'id' or 'slug'
                    'terms' => $cases_country, // Taxonomy term(s).
                )
            );
        }
    }

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    // var_dump($cases_type);

    $query = new WP_Query($args);

    $text_found = '';
    if (pll_current_language() == 'ru') {
        $text_found = myPluralsFunc($query->found_posts, ['кейс', 'кейса', 'кейсов', 'кейса']);
    } else if (pll_current_language() == 'uk') {
        $text_found = $query->found_posts . ' ' . myPluralsFunc($query->found_posts, ['кейс', 'кейси', 'кейсів', 'кейси']);
    } else {
        $text_found = $query->found_posts . ' ' . pll__('кейси');
    } ?>

    <?php if ($query->have_posts()) { ?>
        <div class="item-grid" data-posts="<?php echo pll__('Найдено') . ' ' . $text_found; ?>">
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

        <div class="catalog-item-footer center">
            <div class="pagination catalog-item-pagination">
                <?php
                $query_args = [];
                if ($cases_type) {
                    $query_args['type'] = implode(',', $cases_type);
                }
                if ($cases_country) {
                    $query_args['country'] = implode(',', $cases_country);
                }

                echo wp_kses_post(
                    paginate_links(
                        [
                            'base'   => get_post_type_archive_link('project') . '?page=%#%',
                            // 'format' => '?page=%#%',
                            'total'   => $query->max_num_pages,
                            'current' => $current,
                            'prev_text' => '',
                            'next_text' => '',
                            'mid_size'  => 3,
                            'add_args'  => $query_args,
                        ]
                    )
                );
                ?>
            </div>

            <?php //echo build_query($query_args); ?>

            <div class="pagination-mob catalog-item-pagination">
                <?php if ($current == 1) { ?>
                    <a class="pagination-btn prev <?php echo $current == 1 ? 'disabled' : '' ?>" href="#"></a>
                <?php } ?>

                <?php
                echo wp_kses_post(
                    paginate_links(
                        [
                            'base' => get_post_type_archive_link('project') . '?page=%#%',
                            'total'   => $query->max_num_pages,
                            'current' => $current,
                            'prev_text' => '',
                            'next_text' => '',
                            'mid_size'  => 0,
                            'end_size'  => 0,
                            'add_args'  => $query_args,
                        ]
                    )
                );
                ?>

                <div class="pagination-val">
                    <span class="pagination-val-cur"><?php echo $current; ?></span>
                    <span class="pagination-val-all"><?php echo $query->max_num_pages; ?></span>
                </div>

                <?php if ($query->max_num_pages == $current) { ?>
                    <a class="pagination-btn next <?php echo $query->max_num_pages == $current ? 'disabled' : '' ?>" href="#"></a>
                <?php } ?>
            </div>
        </div>
<?php } else { ?>
    <h2 data-posts="<?php echo pll__('Найдено') . ' ' . $text_found; ?>"><?php pll_e('Кейсов не найдено') ?></h2>
<?php }
    wp_die();
}
