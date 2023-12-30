<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'WPML_Elementor_Module_With_Items' ) )
{
	class Ale_WPML_Elementor_Widget_Centered_Slider extends WPML_Elementor_Module_With_Items {

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
				case 'slide_desc':
					return 'LINE';
				default:
					return '';
			}
		}

	}
}

class Ale_Elementor_Widget_Ale_Centered_Slider extends \Elementor\Widget_Base {

    public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'ale-centered_slider', ALETHEME_THEME_URL. '/aletheme/elementor/js/widget-ale-centered_slider.js', [ 'elementor-frontend' ], ALETHEME_THEME_VERSION, true );
			return [ 'ale-centered_slider' ];
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
			'integration-class' => 'Ale_WPML_Elementor_Widget_Centered_Slider',
	  ];

	  return $widgets;
	}

	/**
	 * Get widget name
	 */

	public function get_name() {
		return 'ale_centered_slider';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Centered Slider', 'ale' );
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

		$repeater->add_control(
			'slide_button_link',
			[
				'label' => esc_html__( "Button Link", "ale" ),
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
                    'default' => 'Default',
                    'donation' => 'Donation',
                    'orquidea' => 'Orquidea',
                    'cafeteria' => 'Cafeteria',
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
        
        if($settings['style'] == 'donation'){ ?>
            <div class="ale_donation_home-2-slider">
                <div class="wrapper2">
                    <ul class="slides">
                        <?php foreach($settings['tabs'] as $item){ ?>
                            <li>
                                <?php if(!empty($slide_image)){
                                    echo '<img src="'.esc_url(wp_get_attachment_url($item['slide_image']['id'])).'" alt="'.esc_attr($item['slide_title']).'" />';
                                } ?>
                                <div class="text">
                                    <span>
                                    <?php echo esc_attr($item['slide_desc']); ?>
                                    </span>
                                    <h2><a href="<?php echo esc_url($item['slide_button_link']['url']); ?>"><?php echo esc_html_e('Read More','ale'); ?></a></h2>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } else if($settings['style'] == 'orquidea'){ 
            
            wp_enqueue_script('scrollable'); ?>
            <div class="orquidea_sliderbox sliderbox cf cusstyle10">
                    <div class="items">
                        <?php foreach($settings['tabs'] as $item){ 
                            echo '<div><img src="'.esc_url(wp_get_attachment_url($item['slide_image']['id'])).'" alt="'.esc_attr($item['slide_title']).'" /></div>';
                         } ?>
                    </div>
                </div>
                <div class="sliderarrows font_two cf">
                    <div class="ltar cusstyle11">
                        <a class="prev browse left"><?php esc_html_e('Previous Photo','ale'); ?></a> / <a class="next browse right"><?php esc_html_e('Next Photo','ale'); ?></a>
                    </div>
                </div>
        <?php } else if($settings['style'] == 'cafeteria'){ ?>
            <div class="cafeteria_centered_slider cf">
                <div class="triang top"></div>
                <div class="triang bot"></div>
                <ul class="slides">
                    <?php foreach($settings['tabs'] as $item){ ?>
                        <li style="background-image: url('<?php echo esc_url(wp_get_attachment_url($item['slide_image']['id'])); ?>'); ">
                            <div class="box">
                                <h2 class="firstfont font_one caption colormain"><?php echo esc_attr($item['slide_title']); ?></h2>
                                <p class="text"><?php echo esc_attr($item['slide_desc']); ?></p>
                                <a href="<?php echo esc_url($item['slide_button_link']['url']); ?>" <?php if($item['slide_button_link']['is_external'] == 1){ echo 'target="_blank"';}  if ($item['slide_button_link']['nofollow']) { echo 'rel="nofollow"'; } ?> class="font_one"><?php echo esc_html_e('Read More','ale'); ?></a>
                            </div>
                        </li>
                    <?php } ?>
                    </ul>
            </div>
        <?php } else { ?>
            <?php wp_enqueue_script( 'slick' ); ?>
            <div class="olins_centered_slider">
                <?php foreach($settings['tabs'] as $item){ ?>
                    <div>
                        <?php if(!empty($item['slide_image']['id'])){
                            echo '<img src="'.esc_url(wp_get_attachment_url($item['slide_image']['id'])).'" alt="'.esc_attr($item['slide_title']).'" />';
                        } ?>
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
                <?php } ?>
            </div>
        <?php } 

	}

}
