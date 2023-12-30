<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'WPML_Elementor_Module_With_Items' ) )
{
	class Ale_WPML_Elementor_Widget_Testimonials_Slider extends WPML_Elementor_Module_With_Items {

		public function get_items_field() {
			return 'tabs';
		}

		public function get_fields() {
			return array( 'name', 'testimonial' );
		}

		protected function get_title( $field ) {
			switch( $field ) {
				case 'name':
					return esc_html__( "Author Name", "ale" );
				case 'testimonial':
					return esc_html__( "Testimonial Text", "ale" );
				default:
					return '';
			}
		}

		protected function get_editor_type( $field ) {
			switch( $field ) {
				case 'name':
					return 'LINE';
				case 'testimonial':
					return 'LINE';
				default:
					return '';
			}
		}

	}
}

class Ale_Elementor_Widget_Ale_Testimonials_Slider extends \Elementor\Widget_Base {

    public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'ale-testimonials_slider', ALETHEME_THEME_URL. '/aletheme/elementor/js/widget-ale-testimonials_slider.js', [ 'elementor-frontend' ], ALETHEME_THEME_VERSION, true );
			return [ 'ale-testimonials_slider' ];
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
			'integration-class' => 'Ale_WPML_Elementor_Widget_Testimonials_Slider',
	  ];

	  return $widgets;
	}

	/**
	 * Get widget name
	 */

	public function get_name() {
		return 'ale_testimonials_slider';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Testimonials Slider', 'ale' );
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
			'name',
			[
				'label' => esc_html__( "Author Name", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
        );
        
		$repeater->add_control(
			'testimonial',
			[
				'label' =>  esc_html__( "Testimonial Text", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
        );

		$repeater->add_control(
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
        
		
		
        
        $this->add_control(
			'tabs',
			[
				'label' => esc_html__( 'Items', 'ale' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [],
				'title_field' => '{{{ name }}}',
			]
		);
		

		$this->end_controls_section();


	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {

        $font = "";
        if(ALETHEME_DESIGN_STYLE == 'rosi'){$font = 'font_two';}

        $settings = $this->get_settings_for_display();
        

         ?>

            <div class="olins_testimonials_container">
                <div class="flexslider olins_testimonials_slider">
                    <ul class="slides">
                        <?php foreach($settings['tabs'] as $slide) { 

                        if($slide['name']) {
                            echo '<li class="font_one">';
                                echo '<div class="testimonial_name '.esc_attr($font).'">'.esc_attr($slide['name']).'</div>';
                                if($slide['testimonial']){
                                    echo '<div class="testimonial">'.vet_wp_kses($slide['testimonial']).'</div>';
                                }

                                if($slide['link']['url']){ ?>
                                    <div class="testimonial_link">
                                        <a href="<?php echo esc_url($slide['link']['url']); ?>" <?php if ($slide['link']['is_external']) {
                                                    echo 'target="_blank"';
                                                }
                                                if ($slide['link']['nofollow']) {
                                                    echo 'rel="nofollow"';
                                                } ?> >
                                            <?php  echo esc_html_e('Details','ale');
                                            ?>
                                        </a>
                                    </div>
                                <?php }

                            echo '</li>';
                        }

                         } ?>
                    </ul>
                </div>
            </div>

         <?php 
	}

}
