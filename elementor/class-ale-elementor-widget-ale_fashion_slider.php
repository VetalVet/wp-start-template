<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'WPML_Elementor_Module_With_Items' ) )
{
	class Ale_WPML_Elementor_Widget_Fashion_Slider extends WPML_Elementor_Module_With_Items {

		public function get_items_field() {
			return 'tabs';
		}

		public function get_fields() {
			return array( 'title', 'text', 'date' );
		}

		protected function get_title( $field ) {
			switch( $field ) {
				case 'slide_title':
					return esc_html__( "Title", "ale" );
				case 'slide_subtitle':
					return esc_html__( "Sub Title", "ale" );
				case 'slide_desc':
					return esc_html__( "Description", "ale" );
				default:
					return '';
			}
		}

		protected function get_editor_type( $field ) {
			switch( $field ) {
				case 'slide_title':
					return 'LINE';
				case 'slide_subtitle':
					return 'LINE';
				case 'slide_desc':
					return 'LINE';
				default:
					return '';
			}
		}

	}
}

class Ale_Elementor_Widget_Ale_Fashion_Slider extends \Elementor\Widget_Base {

    public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'ale-fashion_slider', ALETHEME_THEME_URL. '/aletheme/elementor/js/widget-ale-fashion_slider.js', [ 'elementor-frontend' ], ALETHEME_THEME_VERSION, true );
			return [ 'ale-fashion_slider' ];
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
			'integration-class' => 'Ale_WPML_Elementor_Widget_Fashion_Slider',
	  ];

	  return $widgets;
	}

	/**
	 * Get widget name
	 */

	public function get_name() {
		return 'ale_fashion_slider';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Fashion Slider', 'ale' );
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

        

        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'slide_image',
			[
				'label' => esc_html__( "Slide Image", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
                'label_block' => true,
                
			]
        );
    
        
		$repeater->add_control(
			'slide_title',
			[
				'label' => esc_html__( "Slide Title", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
        );
		$repeater->add_control(
			'slide_subtitle',
			[
				'label' => esc_html__( "Slide Sub Title", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
        );

		$repeater->add_control(
			'slide_desc',
			[
				'label' => esc_html__( "Slide Descriptions", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
        );
        
        $this->add_control(
			'tabs',
			[
				'label' => esc_html__( 'Items', 'ale' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [],
				'title_field' => '{{{ slide_title }}}',
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
                    'default' => 'Defaul Style',
                    'cafeteria' => 'Cafeteria Style'
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
        
        
        if($settings['style']=='cafeteria'){ ?>
            <div class="cafeteria_events_slider">
                <ul class="slides">
                    <?php foreach($settings['tabs'] as $item){ ?>
                        <li>
                            <?php if(!empty($item['slide_image']['url'])){
                                echo '<img src="'.esc_url($item['slide_image']['url']).'" alt="'.esc_attr($item['slide_title']).'" />';
                            } ?>
                            <h2 class="firstfont font_one caption"><?php echo esc_attr($item['slide_title']); ?></h2>
                            <span class="date"><?php echo esc_attr($item['slide_subtitle']); ?></span>
                            <p>
                                <?php echo esc_attr($item['slide_desc']); ?>
                            </p>
                        </li>
                    <?php } ?>
                </ul>
                <div class="outlines"></div>
                <div class="shadows"></div>
            </div>
        <?php } else { 
            wp_enqueue_script( 'slick' ); ?>
        
            <div class="olins_fashion_slider">
                <?php foreach($settings['tabs'] as $item){ ?>
                    <div class="item cf">
                        <div class="left_image_holder">
                            <?php if(!empty($item['slide_image']['url'])){
                                echo '<img src="'.esc_url($item['slide_image']['url']).'" alt="'.esc_attr($item['slide_title']).'" />';
                            } ?>
                        </div>
                        <div class="right_data_holder olins_do_fadein">
                            <?php if(!empty($item['slide_subtitle'])){ ?>
                                <div class="slide_subtitle font_two">
                                    <?php echo esc_attr($item['slide_subtitle']); ?>
                                </div>
                            <?php } ?>
                            <?php if(!empty($item['slide_title'])){ ?>
                                <div class="slide_title font_two">
                                    <?php echo esc_attr($item['slide_title']); ?>
                                </div>
                            <?php } ?>
                            <?php if(!empty($item['slide_desc'])){ ?>
                                <div class="slide_desc">
                                    <?php echo esc_attr($item['slide_desc']); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php }


	}

}
