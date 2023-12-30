<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'WPML_Elementor_Module_With_Items' ) )
{
	class Ale_WPML_Elementor_Widget_Simple_Testimonials_Slider extends WPML_Elementor_Module_With_Items {

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

class Ale_Elementor_Widget_Ale_Simple_Testimonials_Slider extends \Elementor\Widget_Base {

    public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'ale-simple_testimonials_slider', ALETHEME_THEME_URL. '/aletheme/elementor/js/widget-ale-simple_testimonials_slider.js', [ 'elementor-frontend' ], ALETHEME_THEME_VERSION, true );
			return [ 'ale-simple_testimonials_slider' ];
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
			'integration-class' => 'Ale_WPML_Elementor_Widget_Simple_Testimonials_Slider',
	  ];

	  return $widgets;
	}

	/**
	 * Get widget name
	 */

	public function get_name() {
		return 'ale_simple_testimonials_slider';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Simple Testimonials Slider', 'ale' );
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
				'default' => 'default',
				'options' => [
                    'default' => 'Default',
                    'prestigio' => 'Prestigio Style',
                    'organic' => 'Organic Style',
                    'enforcement' => 'Enforcement Style',
                    'burger' => 'Burger Style',
                    'cosushi' => 'coSushi Style'
				],
			]
        );
        
        

        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image',
			[
				'label' => esc_html__( "Testimonial Photo", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
        );
        
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

        

        $settings = $this->get_settings_for_display();
        

         if($settings['grid'] == 'prestigio'){
            wp_enqueue_script( 'ale-slider' ); ?>
        
            <section class="olins_prestigio_testimonials">
                <div class="center cf">
                    <h2><?php esc_html_e('Testimonials','ale'); ?><span class="prev"></span><span class="next"></span></h2>
        
                    <div class="olins_prestigio_testimonials-slider">
                        <ul class="slides">
                        <?php foreach($settings['tabs'] as $slide){ ?>
                        <li class="col-4">
                            <?php echo wp_get_attachment_image($slide['image']['id'], 'full') ?>
                            <h3><?php echo esc_attr($slide['name']); ?> <span>|</span> <span><?php if ($slide['link']['url']) { ?>
                                                <a href="<?php echo esc_url($settings['link']['url']); ?>" <?php if ($slide['link']['is_external']) {
                                                    echo 'target="_blank"';
                                                }
                                                if ($slide['link']['nofollow']) {
                                                    echo 'rel="nofollow"';
                                                } ?> >
                                                    <?php echo esc_html_e('Details', 'ale'); ?>
                                                </a>
                                            <?php }  ?></span></h3>
                            <div class="line"></div>
                            <p>
                                <?php echo esc_attr($slide['testimonial']); ?>
                            </p>
                        </li>
                        <?php } ?>
                        </ul>
                    </div>
        
                </div>
            </section>
        
        <?php } elseif($settings['grid'] == 'enforcement'){ 
        
            wp_enqueue_script( 'slick' );?>
        
            <div class="enforcement_about_slider">
            <?php foreach($settings['tabs'] as $slide){ ?>
            <div class="slide_item_about">
                <div class="item_testimonial">
                    <div class="top_divider">
                        <div class="left"></div>
                        <div class="icon"><i class="fa fa-quote-left" aria-hidden="true"></i></div>
                        <div class="right"></div>
                    </div>
                    <div class="testy_top">
                        <div class="avatar">
                            <?php echo wp_get_attachment_image($slide['image']['id'], 'full') ?>
                        </div>
                        <div class="name_box">
                            <span class="name"><?php echo esc_attr($slide['name']); ?></span>
                            <span class="link">
                                    <?php if ($slide['link']['url']) { ?>
                                        <a href="<?php echo esc_url($slide['link']['url']); ?>" <?php if ($slide['link']['is_external']) {
                                            echo 'target="_blank"';
                                        }
                                        if ($slide['link']['nofollow']) {
                                            echo 'rel="nofollow"';
                                        } ?> >
                                            <?php echo esc_html_e('Details', 'ale'); ?>
                                        </a>
                                    <?php }  ?>
                            </span>
                        </div>
                    </div>
                    <div class="testimonial_text">
                        <?php echo esc_attr($slide['testimonial']); ?>
                    </div>
                </div>
            </div>
            <?php } ?>
            </div>
        <?php } elseif($settings['grid'] == 'organic'){
            wp_enqueue_script( 'slick' ); ?>
        
            <div class="organic_testimonials_slider">
            <?php foreach($settings['tabs'] as $slide){ ?>
            <div class="testy_item">
                <div class="image"><?php echo wp_get_attachment_image($slide['image']['id'], 'full') ?></div>
                <h3><?php echo esc_attr($slide['name']); ?></h3>
                <span class="link">
                <?php if ($slide['link']['url']) { ?>
                        <a href="<?php echo esc_url($slide['link']['url']); ?>" <?php if ($slide['link']['is_external']) {
                            echo 'target="_blank"';
                        }
                        if ($slide['link']['nofollow']) {
                            echo 'rel="nofollow"';
                        } ?> >
                            <?php echo esc_html_e('Details', 'ale'); ?>
                        </a>
                    <?php }  ?>
                </span>
                <div class="description">
                    <?php echo esc_attr($slide['testimonial']); ?>
                </div>
            </div>
                    <?php } ?>
            </div>
        <?php } elseif($settings['grid'] == 'burger'){
        
            wp_enqueue_script( 'slick' ); ?>
        
            <div class="burger_testimonials_slider">
            <?php foreach($settings['tabs'] as $slide){ ?>
                <div class="testy_item">
                    <div class="slide_container">
                        <div class="image"><?php echo wp_get_attachment_image($slide['image']['id'], 'full') ?></div>
                        <div class="slide_data">
                            <i class="fa fa-quote-left" aria-hidden="true"></i>
                            <div class="description">
                                <?php echo esc_attr($slide['testimonial']); ?>
                            </div>
                            <h3><?php echo esc_attr($slide['name']); ?></h3>
                            <span class="link">
                                <?php if ($slide['link']['url']) { ?>
                                    <a href="<?php echo esc_url($slide['link']['url']); ?>" <?php if ($slide['link']['is_external']) {
                                        echo 'target="_blank"';
                                    }
                                    if ($slide['link']['nofollow']) {
                                        echo 'rel="nofollow"';
                                    } ?> >
                                        <?php echo esc_html_e('Details', 'ale'); ?>
                                    </a>
                                <?php }  ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div>
        
        <?php }elseif($settings['grid'] == 'cosushi'){?>

            <div class="flexslider olins_simple_testimonials_slider cosushi_testy_slider">
                <ul class="slides">
                    <?php foreach($settings['tabs'] as $slide){ ?>
                        <li class="cosushi_testimonial">
                            <div class="item_cosushi">
                                <div class="image_holder"><?php echo wp_get_attachment_image($slide['image']['id'], 'full') ?></div>
                                <div class="testy_data">
                                    <?php if (esc_attr($slide['testimonial'])) { ?><p class="member_position font_three"><?php echo esc_attr($slide['testimonial']); ?></p><?php } ?>
                                    <?php if (esc_attr($slide['name'])) { ?><div class="member_name font_one"><?php echo esc_attr($slide['name']); ?></div><?php } ?>
                                    <?php if ($slide['link']['url']) { ?>
                                        <a href="<?php echo esc_url($slide['link']['url']); ?>" class="post_member" <?php if ($slide['link']['is_external']) {
                                            echo 'target="_blank"';
                                        }
                                        if ($slide['link']['nofollow']) {
                                            echo 'rel="nofollow"';
                                        } ?> >
                                            <?php echo esc_html_e('Details', 'ale'); ?>
                                        </a>
                                    <?php }  ?>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>

        <?php } else { ?>
            <div class="olins_testimonials_slider_container">
                <div class="flexslider olins_simple_testimonials_slider">
                    <ul class="slides">
                    <?php foreach($settings['tabs'] as $slide){ ?>
                        <li class="cf">
                            <div class="testimonial_item">
                                <div class="testimonial font_one">
                                    <?php if ($slide['testimonial']) { ?><span class="member_position"><?php echo esc_attr($slide['testimonial']); ?></span><?php } ?>
                                </div>
                                <div class="name font_two">
                                    <?php if ($slide['name']) { ?><span class="member_name"><?php echo esc_attr($slide['name']); ?></span><?php } ?>
                                </div>
                                <div class="photo">
                                    <div class="image_holder">
                                        <?php if ($slide['link']['url']) { ?>
                                            <a href="<?php echo esc_url($slide['link']['url']); ?>" <?php if ($slide['link']['is_external']) {
                                                echo 'target="_blank"';
                                            }
                                            if ($slide['link']['nofollow']) {
                                                echo 'rel="nofollow"';
                                            } ?> >
                                                <?php echo wp_get_attachment_image($slide['image']['id'], 'full') ?>
                                            </a>
                                        <?php } else { ?>
                                            <?php echo wp_get_attachment_image($slide['image']['id'], 'full') ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } 


	}

}
