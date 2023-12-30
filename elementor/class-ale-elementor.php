<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Core_Elementor
{
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
	const MINIMUM_PHP_VERSION = '7.4';
	private static $_instance = null;

	/**
	 * Instance
	 * Ensures only one instance of the class is loaded or can be loaded.
	 */

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 */

	public function __construct()
	{

		add_action( 'after_setup_theme', [ $this, 'init' ] );

	}

	/**
	 * Initialize
	 */

	public function init(){

		// Check if Elementor installed and activated

		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		// Check for required Elementor version

		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version

		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Add actions

		require_once( get_template_directory_uri() . '/elementor/class-ale-elementor-helper.php' );

		add_action( 'elementor/elements/categories_registered', 'Ale_Elementor_Helper::categories_registered' );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

	}


	/**
	 * Admin notice
	 * Warning when the site doesn't have a minimum required Elementor version.
	 */

	public function admin_notice_minimum_elementor_version() {

		$message = esc_html__('Theme requires Elementor version','ale').' <strong>'. self::MINIMUM_ELEMENTOR_VERSION .'</strong> '.esc_html__('or greater.','ale');
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 * Warning when the site doesn't have a minimum required PHP version.
	 */

	public function admin_notice_minimum_php_version() {

		$message = esc_html__('Theme requires PHP version','ale') . ' <strong>'. self::MINIMUM_PHP_VERSION .'</strong> '. esc_html__('or greater.','ale');
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Init Widgets
	 * Include widgets files and register them
	 */

	public function init_widgets() {

		$widgets = [
			'ale_contact_form',
			'ale_simple_form',
			'ale_hover_team',
			'ale_simple_team',
			'ale_works_masonry_grid',
			'ale_recent_blog_posts',
			'ale_recent_products',
			'ale_counter',
			'ale_creative_title',
			'ale_service_block',
			'ale_left_icon_service',
			'ale_price_item',
			'ale_video_box',
			'ale_shop_categories',
			'ale_skill_bar',
			'ale_team_tabs',
			'ale_years_tabs',
			'ale_corporate_team',
			'ale_shop_products',
			'ale_simple_testimonials_slider',
			'ale_works_vertical_slider',
			'ale_pricing_table',
			'ale_testimonials_slider',
			'ale_search_box',
			'ale_timeline',
			'ale_centered_slider',
			'ale_fashion_slider',
		];

		foreach( $widgets as $widget ){

			require_once( get_template_directory_uri() . '/elementor/class-ale-elementor-widget-'. $widget .'.php' );

			$class = '\Ale_Elementor_Widget_'. str_replace( ' ', '_', ucfirst(str_replace( '-', ' ', $widget )));
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new $class() );

		}

	}

}

Core_Elementor::instance();
