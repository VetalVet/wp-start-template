<?php
// Регистрация таксономий
add_action( 'init', 'tax1' );
function tax1(){

	// список параметров: wp-kama.ru/function/get_taxonomy_labels
	register_taxonomy( 'taxonomy', [ 'post' ], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => 'tax1',
			'singular_name'     => 'tax1',
			'search_items'      => 'Search tax1',
			'all_items'         => 'All tax1',
			'view_item '        => 'View tax1',
			'parent_item'       => 'Parent tax1',
			'parent_item_colon' => 'Parent tax1:',
			'edit_item'         => 'Edit tax1',
			'update_item'       => 'Update tax1',
			'add_new_item'      => 'Add New tax1',
			'new_item_name'     => 'New tax1 Name',
			'menu_name'         => 'tax1',
			'back_to_items'     => '← Back to tax1',
		],
		'description'           => '', // описание таксономии
		'public'                => true,
		// 'publicly_queryable'    => null, // равен аргументу public
		// 'show_in_nav_menus'     => true, // равен аргументу public
		// 'show_ui'               => true, // равен аргументу public
		// 'show_in_menu'          => true, // равен аргументу show_ui
		// 'show_tagcloud'         => true, // равен аргументу show_ui
		// 'show_in_quick_edit'    => null, // равен аргументу show_ui
		'hierarchical'          => false,

		'rewrite'               => true,
		//'query_var'             => $taxonomy, // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
		'show_admin_column'     => false, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
		'show_in_rest'          => null, // добавить в REST API
		'rest_base'             => null, // $taxonomy
		// '_builtin'              => false,
		//'update_count_callback' => '_update_post_term_count',
	] );
}



// Регистрация типов постов
function some() {
	$labels = array(
		'name'                  => _x( 'some', 'Post Type General Name', 'some' ),
		'singular_name'         => _x( 'some', 'Post Type Singular Name', 'some' ),
		'menu_name'             => __( 'some', 'some' ),
		'name_admin_bar'        => __( 'some', 'some' ),
		'archives'              => __( 'Item Archives', 'some' ),
		'attributes'            => __( 'Item Attributes', 'some' ),
		'parent_item_colon'     => __( 'Parent Item:', 'some' ),
		'all_items'             => __( 'All Items', 'some' ),
		'add_new_item'          => __( 'Add New Item', 'some' ),
		'add_new'               => __( 'Add New', 'some' ),
		'new_item'              => __( 'New Item', 'some' ),
		'edit_item'             => __( 'Edit Item', 'some' ),
		'update_item'           => __( 'Update Item', 'some' ),
		'view_item'             => __( 'View Item', 'some' ),
		'view_items'            => __( 'View Items', 'some' ),
		'search_items'          => __( 'Search Item', 'some' ),
		'not_found'             => __( 'Not found', 'some' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'some' ),
		'featured_image'        => __( 'Featured Image', 'some' ),
		'set_featured_image'    => __( 'Set featured image', 'some' ),
		'remove_featured_image' => __( 'Remove featured image', 'some' ),
		'use_featured_image'    => __( 'Use as featured image', 'some' ),
		'insert_into_item'      => __( 'Insert into item', 'some' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'some' ),
		'items_list'            => __( 'Items list', 'some' ),
		'items_list_navigation' => __( 'Items list navigation', 'some' ),
		'filter_items_list'     => __( 'Filter items list', 'some' ),
	);
	$args = array(
		'label'                 => __( 'some', 'some' ),
		'description'           => __( 'some', 'some' ),
		'labels'                => $labels,
		'supports'              => array( 'author', 'title', 'custom-fields', 'editor' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
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
	register_post_type( 'some', $args );
}
add_action( 'init', 'some', 0 );

function some2() {

	$labels = array(
		'name'                  => _x( 'some2', 'Post Type General Name', 'some2' ),
		'singular_name'         => _x( 'some2', 'Post Type Singular Name', 'some2' ),
		'menu_name'             => __( 'some2', 'some2' ),
		'name_admin_bar'        => __( 'some2', 'some2' ),
		'archives'              => __( 'Item Archives', 'some2' ),
		'attributes'            => __( 'Item Attributes', 'some2' ),
		'parent_item_colon'     => __( 'Parent Item:', 'some2' ),
		'all_items'             => __( 'All Items', 'some2' ),
		'add_new_item'          => __( 'Add New Item', 'some2' ),
		'add_new'               => __( 'Add New', 'some2' ),
		'new_item'              => __( 'New Item', 'some2' ),
		'edit_item'             => __( 'Edit Item', 'some2' ),
		'update_item'           => __( 'Update Item', 'some2' ),
		'view_item'             => __( 'View Item', 'some2' ),
		'view_items'            => __( 'View Items', 'some2' ),
		'search_items'          => __( 'Search Item', 'some2' ),
		'not_found'             => __( 'Not found', 'some2' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'some2' ),
		'featured_image'        => __( 'Featured Image', 'some2' ),
		'set_featured_image'    => __( 'Set featured image', 'some2' ),
		'remove_featured_image' => __( 'Remove featured image', 'some2' ),
		'use_featured_image'    => __( 'Use as featured image', 'some2' ),
		'insert_into_item'      => __( 'Insert into item', 'some2' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'some2' ),
		'items_list'            => __( 'Items list', 'some2' ),
		'items_list_navigation' => __( 'Items list navigation', 'some2' ),
		'filter_items_list'     => __( 'Filter items list', 'some2' ),
	);
	$args = array(
		'label'                 => __( 'some2', 'some2' ),
		'description'           => __( 'some2', 'some2' ),
		'labels'                => $labels,
		'supports'              => array( 'author', 'title', 'custom-fields', 'editor'),
		'taxonomies'            => array( 'category', 'post_tag' ),
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
	register_post_type( 'some2', $args );
}
add_action( 'init', 'some2', 1 );
?>