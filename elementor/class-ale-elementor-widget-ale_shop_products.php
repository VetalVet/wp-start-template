<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Shop_Products extends \Elementor\Widget_Base {

    public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'ale-shop_products', ALETHEME_THEME_URL. '/aletheme/elementor/js/widget-ale-shop_products.js', [ 'elementor-frontend' ], ALETHEME_THEME_VERSION, true );
			return [ 'ale-shop_products' ];
		}

		return [];
	}

	/**
	 * Widget base constructor
	 */

	public function __construct( $data = [], $args = null ) {

		parent::__construct( $data, $args );
	}



	/**
	 * Get widget name
	 */

	public function get_name() {
		return 'ale_shop_products';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Shop Products', 'ale' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'fas fa-horse-head';
	}

	/**
	 * Get widget categories
	 */

	public function get_categories() {
		return [ 'ale_builder' ];
	}

	/**
	 * Register widget controls
	 */

	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'ale' ),
			]
		);


		$this->add_control(
			'grid',
			[
				'label' =>  esc_html__( "Grid Layout", "ale" ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'rossigrid',
				'options' => [
                    'rossigrid' => 'Rosi Grid',
                    'burgergrid' => 'Burger Grid'
				],
			]
        );
        
        $this->add_control(
			'count',
			[
				'label' => esc_html__( "Products count", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
			]
        );

        $this->end_controls_section();


	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {

        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script("jquery-ui-tabs");
        wp_enqueue_script("jquery-effects-core");
        wp_enqueue_script("jquery-effects-slide");
        
		$settings = $this->get_settings_for_display();
        
        
        $cats = get_terms('product_cat');

        echo '<div class="olins_shop_products_box cf">';

        echo '<ul class="filter_categories font_one">';
        foreach ( $cats as $cat ) {

            $shop_category = get_term($cat->term_id, 'product_cat');
            echo '<li><a href="#'.esc_attr($shop_category->slug).'"><span>';
            echo esc_attr($shop_category->name);
            echo '</span></a></li>';
        }
        echo '</ul>';


        echo '<div class="contents filter_products_per_category">';
        foreach ( $cats as $cat ) {
            $shop_category = get_term($cat->term_id, 'product_cat');

            echo '<div class="last_products_in_category cf" id="'.esc_attr($shop_category->slug).'">';

            echo do_shortcode('[product_category per_page="'.esc_attr($settings['count']).'" category="'.esc_attr($shop_category->slug).'"]');

            echo '</div>';
        }
        echo '</div>';
        echo '</div>';


	}

}
