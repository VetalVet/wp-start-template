<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Skill_Bar extends \Elementor\Widget_Base {


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
					'field' => 'skill',
					'type' => $this->get_title() .'<br />'. esc_html__( "Skill", "ale" ),
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
		return 'ale_skill_bar';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Skill Bar', 'ale' );
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
			'skill',
			[
				'label' => esc_html__( "Skill", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );

		$this->add_control(
			'progress',
			[
				'label' => esc_html__( "Pregress in %", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );

        $this->end_controls_section();


	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {
        
		$settings = $this->get_settings_for_display();
        
        $value_position = '';
        if(ALETHEME_DESIGN_STYLE == 'laptica') {
            $value_position = ' style="position:absolute; bottom:0; left:'.esc_attr($settings['progress']).';" ';
        }

        ?>

        <div class="olins_progress_bar">
            <h3><?php echo esc_attr($settings['skill']); ?> <span <?php echo vet_wp_kses($value_position); ?> ><?php echo esc_attr($settings['progress']); ?></span></h3>
            <div class="bar">
                <div class="progress" style="width: <?php echo esc_attr($settings['progress']); ?>;"></div>
            </div>
        </div>

        <?php

	}

}
