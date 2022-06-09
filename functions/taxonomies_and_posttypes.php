<?php
// Регистрация таксономий
// add_action('init', 'tax1');
// function tax1()
// {
// 	// список параметров: wp-kama.ru/function/get_taxonomy_labels
// 	register_taxonomy('taxonomy', ['post'], [
// 		'label'                 => '', // определяется параметром $labels->name
// 		'labels'                => [
// 			'name'              => 'tax1',
// 			'singular_name'     => 'tax1',
// 			'search_items'      => 'Search tax1',
// 			'all_items'         => 'All tax1',
// 			'view_item '        => 'View tax1',
// 			'parent_item'       => 'Parent tax1',
// 			'parent_item_colon' => 'Parent tax1:',
// 			'edit_item'         => 'Edit tax1',
// 			'update_item'       => 'Update tax1',
// 			'add_new_item'      => 'Add New tax1',
// 			'new_item_name'     => 'New tax1 Name',
// 			'menu_name'         => 'tax1',
// 			'back_to_items'     => '← Back to tax1',
// 		],
// 		'description'           => '', // описание таксономии
// 		'public'                => true,
// 		// 'publicly_queryable'    => null, // равен аргументу public
// 		// 'show_in_nav_menus'     => true, // равен аргументу public
// 		// 'show_ui'               => true, // равен аргументу public
// 		// 'show_in_menu'          => true, // равен аргументу show_ui
// 		// 'show_tagcloud'         => true, // равен аргументу show_ui
// 		// 'show_in_quick_edit'    => null, // равен аргументу show_ui
// 		'hierarchical'          => false,

// 		'rewrite'               => true,
// 		//'query_var'             => $taxonomy, // название параметра запроса
// 		'capabilities'          => array(),
// 		'meta_box_cb'           => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
// 		'show_admin_column'     => false, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
// 		'show_in_rest'          => null, // добавить в REST API
// 		'rest_base'             => null, // $taxonomy
// 		// '_builtin'              => false,
// 		//'update_count_callback' => '_update_post_term_count',
// 	]);
// }



// Регистрация типов постов
function testimonials()
{
	$labels = array(
		'name'                  => _x('testimonials', 'Post Type General Name', 'testimonials'),
		'singular_name'         => _x('testimonials', 'Post Type Singular Name', 'testimonials'),
		'menu_name'             => __('testimonials', 'testimonials'),
		'name_admin_bar'        => __('testimonials', 'testimonials'),
		'archives'              => __('Item Archives', 'testimonials'),
		'attributes'            => __('Item Attributes', 'testimonials'),
		'parent_item_colon'     => __('Parent Item:', 'testimonials'),
		'all_items'             => __('All Items', 'testimonials'),
		'add_new_item'          => __('Add New Item', 'testimonials'),
		'add_new'               => __('Add New', 'testimonials'),
		'new_item'              => __('New Item', 'testimonials'),
		'edit_item'             => __('Edit Item', 'testimonials'),
		'update_item'           => __('Update Item', 'testimonials'),
		'view_item'             => __('View Item', 'testimonials'),
		'view_items'            => __('View Items', 'testimonials'),
		'search_items'          => __('Search Item', 'testimonials'),
		'not_found'             => __('Not found', 'testimonials'),
		'not_found_in_trash'    => __('Not found in Trash', 'testimonials'),
		'featured_image'        => __('Featured Image', 'testimonials'),
		'set_featured_image'    => __('Set featured image', 'testimonials'),
		'remove_featured_image' => __('Remove featured image', 'testimonials'),
		'use_featured_image'    => __('Use as featured image', 'testimonials'),
		'insert_into_item'      => __('Insert into item', 'testimonials'),
		'uploaded_to_this_item' => __('Uploaded to this item', 'testimonials'),
		'items_list'            => __('Items list', 'testimonials'),
		'items_list_navigation' => __('Items list navigation', 'testimonials'),
		'filter_items_list'     => __('Filter items list', 'testimonials'),
	);
	$args = array(
		'label'                 => __('testimonials', 'testimonials'),
		'description'           => __('testimonials', 'testimonials'),
		'labels'                => $labels,
		'supports'              => array('author', 'title', 'custom-fields', 'editor'),
		'taxonomies'            => array('category', 'post_tag'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-text-page',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type('testimonials', $args);
}
add_action('init', 'testimonials', 0);

function articles()
{

	$labels = array(
		'name'                  => _x('articles', 'Post Type General Name', 'articles'),
		'singular_name'         => _x('articles', 'Post Type Singular Name', 'articles'),
		'menu_name'             => __('articles', 'articles'),
		'name_admin_bar'        => __('articles', 'articles'),
		'archives'              => __('Item Archives', 'articles'),
		'attributes'            => __('Item Attributes', 'articles'),
		'parent_item_colon'     => __('Parent Item:', 'articles'),
		'all_items'             => __('All Items', 'articles'),
		'add_new_item'          => __('Add New Item', 'articles'),
		'add_new'               => __('Add New', 'articles'),
		'new_item'              => __('New Item', 'articles'),
		'edit_item'             => __('Edit Item', 'articles'),
		'update_item'           => __('Update Item', 'articles'),
		'view_item'             => __('View Item', 'articles'),
		'view_items'            => __('View Items', 'articles'),
		'search_items'          => __('Search Item', 'articles'),
		'not_found'             => __('Not found', 'articles'),
		'not_found_in_trash'    => __('Not found in Trash', 'articles'),
		'featured_image'        => __('Featured Image', 'articles'),
		'set_featured_image'    => __('Set featured image', 'articles'),
		'remove_featured_image' => __('Remove featured image', 'articles'),
		'use_featured_image'    => __('Use as featured image', 'articles'),
		'insert_into_item'      => __('Insert into item', 'articles'),
		'uploaded_to_this_item' => __('Uploaded to this item', 'articles'),
		'items_list'            => __('Items list', 'articles'),
		'items_list_navigation' => __('Items list navigation', 'articles'),
		'filter_items_list'     => __('Filter items list', 'articles'),
	);
	$args = array(
		'label'                 => __('articles', 'articles'),
		'description'           => __('articles', 'articles'),
		'labels'                => $labels,
		'supports'              => array('author', 'title', 'custom-fields', 'editor'),
		'taxonomies'            => array('category', 'post_tag'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-calendar-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type('articles', $args);
}
add_action('init', 'articles', 1);

function some2(){
	$labels = array(
		'name'                  => _x('some2', 'Post Type General Name', 'some2'),
		'singular_name'         => _x('some2', 'Post Type Singular Name', 'some2'),
		'menu_name'             => __('some2', 'some2'),
		'name_admin_bar'        => __('some2', 'some2'),
		'archives'              => __('Item Archives', 'some2'),
		'attributes'            => __('Item Attributes', 'some2'),
		'parent_item_colon'     => __('Parent Item:', 'some2'),
		'all_items'             => __('All Items', 'some2'),
		'add_new_item'          => __('Add New Item', 'some2'),
		'add_new'               => __('Add New', 'some2'),
		'new_item'              => __('New Item', 'some2'),
		'edit_item'             => __('Edit Item', 'some2'),
		'update_item'           => __('Update Item', 'some2'),
		'view_item'             => __('View Item', 'some2'),
		'view_items'            => __('View Items', 'some2'),
		'search_items'          => __('Search Item', 'some2'),
		'not_found'             => __('Not found', 'some2'),
		'not_found_in_trash'    => __('Not found in Trash', 'some2'),
		'featured_image'        => __('Featured Image', 'some2'),
		'set_featured_image'    => __('Set featured image', 'some2'),
		'remove_featured_image' => __('Remove featured image', 'some2'),
		'use_featured_image'    => __('Use as featured image', 'some2'),
		'insert_into_item'      => __('Insert into item', 'some2'),
		'uploaded_to_this_item' => __('Uploaded to this item', 'some2'),
		'items_list'            => __('Items list', 'some2'),
		'items_list_navigation' => __('Items list navigation', 'some2'),
		'filter_items_list'     => __('Filter items list', 'some2'),
	);
	$args = array(
		'label'                 => __('some2', 'some2'),
		'description'           => __('some2', 'some2'),
		'labels'                => $labels,
		'supports'              => array('author', 'title', 'custom-fields', 'editor'),
		'taxonomies'            => array('category', 'post_tag'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-calendar-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type('some2', $args);
}
add_action('init', 'some2', 1);