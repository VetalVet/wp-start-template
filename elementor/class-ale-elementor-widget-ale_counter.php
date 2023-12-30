<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Counter extends \Elementor\Widget_Base {

    public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'ale-counter_elementor', ALETHEME_THEME_URL. '/aletheme/elementor/js/widget-ale-counter_elementor.js', [ 'elementor-frontend' ], ALETHEME_THEME_VERSION, true );
			return [ 'ale-counter_elementor' ];
		}

		return [];
	}

	/**
	 * Widget base constructor
	 */

	public function __construct( $data = [], $args = null ) {

		add_filter( 'wpml_elementor_widgets_to_translate', [ $this, 'wpml_widgets_to_translate_filter' ] );

		parent::__construct( $data, $args );
	}

	/**
	 * WPML compatibility
	 */

	public function wpml_widgets_to_translate_filter( $widgets ) {

	  $widgets[ $this->get_name() ] = [
			'conditions' => [
				'widgetType' => $this->get_name(),
			],
			'fields' => [
			  [
					'field' => 'value',
					'type' => $this->get_title() .'<br />'. esc_html__( "Counter Value", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'title',
					'type' => $this->get_title() .'<br />'. esc_html__( "Counter Label", "ale" ),
					'editor_type' => 'LINE'
			  ],
			],
	  ];

	  return $widgets;
	}

	/**
	 * Get widget name
	 */

	public function get_name() {
		return 'ale_counter';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Counter', 'ale' );
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
			'icon',
			[
				'label' => esc_html__( "Counter Icon", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
        );

		$this->add_control(
			'value',
			[
				'label' => esc_html__( "Counter Value", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );
        
        $this->add_control(
			'value_color',
			[
				'label' => esc_html__( "Counter Value Color", "ale" ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'alpha' => true,
				'selectors' => [
					'{{WRAPPER}} .ale_counter .counter' => 'color: {{VALUE}}',
				],
			]
        );

        $this->add_control(
			'title',
			[
				'label' =>  esc_html__( "Counter Label", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );
        
        $this->add_control(
			'title_color',
			[
				'label' => esc_html__( "Counter Label Color", "ale" ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'alpha' => true,
				'selectors' => [
					'{{WRAPPER}} .ale_counter .counter_title' => 'color: {{VALUE}}',
				],
			]
        );


		$this->end_controls_section();


	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {

        wp_enqueue_script( 'ale-appear' );
        wp_enqueue_script( 'ale-counter' );
		$settings = $this->get_settings_for_display();

        $image_src = $settings['icon']['url'];

		?>

        
        <div class="ale_counter font_one">
            <span class="counter fromzero" style="color:<?php echo esc_attr($settings['value_color']); ?>"><?php echo esc_attr($settings['value']); ?></span>
            <?php if(!empty($settings['title'])){
                echo '<span class="counter_title" style="color:'.esc_attr($settings['title_color']).'">'.esc_attr($settings['title']).'</span>';
            }
            if(!empty($image_src)){
                echo '<span class="counter_icon"><img src="'.esc_url($image_src).'" alt="icon" /></span>';
            }
            ?>
        </div>

        <?php

	}

}
