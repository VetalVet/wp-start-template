<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Hover_Team extends \Elementor\Widget_Base {

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
					'field' => 'text',
					'type' => $this->get_title() .'<br />'. esc_html__( "Text field", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'text2',
					'type' => $this->get_title() .'<br />'. esc_html__( "Second Text field", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'link',
					'type' => $this->get_title() .'<br />'. esc_html__( "Link", "ale" ),
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
		return 'ale_hover_team';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Hover Team', 'ale' );
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
				'label' => esc_html__( "Image", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
        );

		$this->add_control(
			'text',
			[
				'label' => esc_html__( "Text field", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

        $this->add_control(
			'text2',
			[
				'label' =>  esc_html__( "Second Text field", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

        $this->add_control(
			'link',
			[
				'label' => esc_html__( "Link", "ale" ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'ale' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'adcanced_section',
			[
				'label' => esc_html__( 'Advanced', 'ale' ),
			]
		);
        
        $this->add_control(
			'style',
			[
				'label' => esc_html__( "Style", "ale" ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
                     'default' => 'Default', 
                     'delizioso' => 'Delizioso', 
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {

		$settings = $this->get_settings_for_display();

        $image_src = $settings['image']['url'];

		?>

        
        <?php if($settings['style'] == 'delizioso') { ?>
            <div class="delizioso_hover_team">
                <figure class="image_holder">
                    <img src="<?php echo esc_url($image_src);?>" alt="<?php echo esc_attr($settings['text']); ?>"/>
                    <?php if($settings['text']){?>
                        <figcaption class="hover_mask">
                            <div class="open">
                                <?php
                                if(!empty($settings['link']['url'])){?>
                                    <a href="<?php echo esc_url($settings['link']['url']); ?>" <?php if($settings['link']['is_external'] == 1){ echo 'target="_blank"';}  if ($settings['link']['nofollow']) { echo 'rel="nofollow"'; } ?>>
                                        <span>
                                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                <?php } ?>
                            </div>
                            <span class="text_one font_two"><?php echo esc_attr($settings['text']); ?></span>
                            <?php if($settings['text2']){ ?>
                                <span class="text_two"><?php echo esc_attr($settings['text2']); ?></span>
                            <?php } ?>
                        </figcaption>
                    <?php } ?>
                </figure>
            </div>
        <?php } else { ?>
            <?php if($image_src){ ?>
            <div class="olins_hover_team">
                <div class="image_holder">
                    <img src="<?php echo esc_url($image_src);?>" alt="<?php echo esc_attr($settings['text']); ?>"/>
                    <?php if($settings['text']){?>
                        <div class="hover_mask">
                            <span class="text_one font_two"><?php echo esc_attr($settings['text']); ?></span>
                            <?php if($settings['text2']){ ?>
                                <span class="text_two"><?php echo esc_attr($settings['text2']); ?></span>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        <?php } ?>

        <?php

	}

}
