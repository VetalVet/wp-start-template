<?php

// ajax поиск по сайту 
add_action('wp_ajax_nopriv_search_ajax', 'search_ajax');
add_action('wp_ajax_search_ajax', 'search_ajax');

function search_ajax(){
    if(!wp_verify_nonce($_POST['nonce'], 'search-nonce')){
        wp_die('Данные отправлены с левого адреса');
    }


    $args = array(
        'cat'            => 10, 
        'post_type'      => 'any', // Тип записи: post, page, кастомный тип записи 
        'post_status'    => 'publish',
        's'              => $_POST['s'],
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); ?>

            <li class="ajax-search__item">
                <a href="<?php the_permalink(); ?>" class="ajax-search__link"><?php the_title(); ?></a>
                <div class="ajax-search__excerpt"><?php the_excerpt(); ?></div>
            </li>

        <?php }
    } else { ?>
        <li class="ajax-search__item">
            <div class="ajax-search__not-found">Ничего не найдено</div>
        </li>


<?php }
    exit;
}