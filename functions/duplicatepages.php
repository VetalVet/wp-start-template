<?php
// Функция создает дубликат поста в виде черновика и редиректит на его страницу редактирования
function duplicate_page()
{

    if (empty($_GET['post'])) {
        wp_die('Нечего дублировать!');
    }

    // проверка nonce
    if (!isset($_GET['true_duplicate_nonce']) || !wp_verify_nonce($_GET['true_duplicate_nonce'], basename(__FILE__))) {
        return;
    }

    // получаем ID оригинального поста
    $post_id = absint($_GET['post']);

    // затем получили объект поста
    $post = get_post($post_id);

    /*
	 * если вы не хотите, чтобы текущий автор был автором нового поста
	 * тогда замените следующие две строчки на: $new_post_author = $post->post_author;
	 * при замене этих строк автор будет копироваться из оригинального поста
	 */
    $current_user = wp_get_current_user();
    $new_post_author = $current_user->ID;

    /*
	 * если пост существует, создаем его дубликат
	 */
    if ($post) {

        // массив данных нового поста
        $args = array(
            'comment_status' => $post->comment_status,
            'ping_status'    => $post->ping_status,
            'post_author'    => $new_post_author,
            'post_content'   => $post->post_content,
            'post_excerpt'   => $post->post_excerpt,
            'post_parent'    => $post->post_parent,
            'post_name'      => $post->post_name,
            'post_password'  => $post->post_password,
            'post_status'    => 'draft', // черновик, если хотите сразу публиковать - замените на publish
            'post_title'     => $post->post_title,
            'post_type'      => $post->post_type,
            'to_ping'        => $post->to_ping,
            'menu_order'     => $post->menu_order
        );

        // создаем пост при помощи функции wp_insert_post()
        $new_post_id = wp_insert_post($args);

        // присваиваем новому посту все элементы таксономий (рубрики, метки и т.д.) старого
        $taxonomies = get_object_taxonomies($post->post_type); // возвращает массив названий таксономий, используемых для указанного типа поста, например array("category", "post_tag");
        foreach ($taxonomies as $taxonomy) {
            $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
            wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
        }

        // дублируем все произвольные поля
        $post_meta = get_post_meta( $post_id );
        // print_r($post_meta);
        if( $post_meta ) {
        	foreach ( $post_meta as $meta_key => $meta_values ) {
        		if( '_wp_old_slug' == $meta_key ) { // это лучше не трогать
        			continue;
        		}
        		foreach ( $meta_values as $meta_value ) {
                    // update_field($meta_key, $meta_value, [$new_post_id]);
        			add_post_meta( $new_post_id, $meta_key, $meta_value );
        		}
        	}
        }
    

        // перенаправляем пользователя на страницу редактирования нового поста
        wp_safe_redirect(add_query_arg(array('action' => 'edit', 'post' => $new_post_id), admin_url('post.php')));
        exit;
    } else {
        wp_die('Ошибка создания поста, не могу найти оригинальный пост с ID=: ' . $post_id);
    }
}

add_action('admin_action_duplicate_page', 'duplicate_page');

// Добавляем ссылку дублирования поста для post_row_actions
add_filter('post_row_actions', 'add_duplicate_btn', 10, 2);
function add_duplicate_btn($actions, $post)
{
    if (current_user_can('edit_posts')) {
        $actions['duplicate'] = '<a href="' . wp_nonce_url(add_query_arg(array('action' => 'duplicate_page', 'post' => $post->ID), 'admin.php'), basename(__FILE__), 'true_duplicate_nonce') . '">Duplicate</a>';
    }
    return $actions;
}

add_filter('page_row_actions', 'add_duplicate_btn', 10, 2);

add_filter('sx-services_row_actions', 'add_duplicate_btn', 10, 2);
