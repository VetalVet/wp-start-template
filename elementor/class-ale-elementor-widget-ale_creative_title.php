<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Creative_Title extends \Elementor\Widget_Base {


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
		return 'ale_creative_title';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Creative Title', 'ale' );
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
				'label' =>  esc_html__( "Icon Image", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
        );

		$this->add_control(
			'title',
			[
				'label' =>  esc_html__( "Title", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
			'adcanced_section',
			[
				'label' => esc_html__( 'Ospedale Demo', 'ale' ),
			]
		);

        $this->add_control(
			'button_link',
			[
				'label' =>  esc_html__( "Button Link.", "ale" ),
				'type' => \Elementor\Controls_Manager::URL,
			]
        );
        
    
		$this->end_controls_section();


	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {

		$settings = $this->get_settings_for_display();

        $image_src = $settings['icon']['url'];

		
        $separator_style = '';
        $font_family = 'font_two';


        if(!empty($settings['icon']['id'])){
            $attachment_meta = wp_get_attachment_metadata($settings['icon']['id']);
            $width = $attachment_meta['width'];
            $height = $attachment_meta['height'];
            $separator_style = 'width:'.esc_attr($width).'px; height: '.esc_attr($height).'px; background-image: url('.esc_url(wp_get_attachment_url($settings['icon']['id'])).');';
        }

        $button_link = ''; 
        $button_link =  $settings['button_link'];

        if(ALETHEME_DESIGN_STYLE == 'ospedale') {
            $font_family = 'font_one';
        }

        ?>
        <?php if(ALETHEME_DESIGN_STYLE == 'limpieza'){ ?>
            <div class="limpieza_title">
                <h2>
                    <?php echo vet_wp_kses($settings['title']); ?>
                </h2>
            </div>
        <?php } else { ?>
            <div class="creative_title_item">
                <h2 class="creative_title <?php echo esc_attr($font_family); ?>"><?php echo vet_wp_kses($settings['title']); ?></h2>

                <?php 
                
                if(!empty($button_link['url'])){ ?>
                    <div><a class="ospedale_button font_two" href="<?php echo esc_url($button_link['url']); ?>" <?php if(isset($button_link['is_external'])){ echo 'target="'.esc_attr($button_link['is_external']).'"';} if(isset($button_link['nofollow'])){ echo 'rel="'.esc_attr($button_link['nofollow']).'"';} ?> >
                        <?php if(isset($button_link['title'])){
                            echo esc_attr($button_link['title']);
                        } else {
                            echo esc_html_e('Details','ale');
                        } ?>
                    </a></div>
                <?php } ?>

            <?php if(ALETHEME_DESIGN_STYLE !== 'ospedale'){ ?><span class="separator" style="<?php echo esc_attr($separator_style); ?>"></span><?php } ?>
            </div>
        <?php } ?>

        <?php

	}

}
