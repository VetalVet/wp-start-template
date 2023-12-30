<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Left_Icon_Service extends \Elementor\Widget_Base {

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
					'field' => 'title',
					'type' => $this->get_title() .'<br />'. esc_html__( "Title field", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'description',
					'type' => $this->get_title() .'<br />'. esc_html__( "Description field", "ale" ),
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
		return 'ale_left_icon_service';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Left Icon Service', 'ale' );
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
			'image',
			[
				'label' => esc_html__( "Icon Image", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
        );

		$this->add_control(
			'title',
			[
				'label' => esc_html__( "Title field", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

        $this->add_control(
			'description',
			[
				'label' =>  esc_html__( "Description field", "ale" ),
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
		?>
            <div class="olins_left_icon_service cf">
                <div class="icon_holder">
                    <img src="<?php echo esc_url(wp_get_attachment_url($settings['image']['id']));?>" alt="<?php echo esc_attr($settings['title']); ?>"/>
                </div>
                <div class="data_holder">
                    <?php if($settings['title']){
                        echo '<span class="title font_two">'.esc_attr($settings['title']).'</span>';
                    }
                    if($settings['description']){
                        echo '<span class="description">'.esc_attr($settings['description']).'</span>';
                    } ?>
                </div>
            </div>
        <?php
	}

}
