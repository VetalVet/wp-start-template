<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'WPML_Elementor_Module_With_Items' ) )
{
	class Ale_WPML_Elementor_Widget_Years_Tabs extends WPML_Elementor_Module_With_Items {

		public function get_items_field() {
			return 'tabs';
		}

		public function get_fields() {
			return array( 'title', 'text', 'tab' );
		}

		protected function get_title( $field ) {
			switch( $field ) {
				case 'title':
					return esc_html__( "Member Name", "ale" );
				case 'text':
					return esc_html__( "Description", "ale" );
				case 'tab':
					return esc_html__( "Member Position", "ale" );
				default:
					return '';
			}
		}

		protected function get_editor_type( $field ) {
			switch( $field ) {
				case 'title':
					return 'LINE';
				case 'text':
					return 'LINE';
				case 'tab':
					return 'LINE';
				default:
					return '';
			}
		}

	}
}

class Ale_Elementor_Widget_Ale_Years_Tabs extends \Elementor\Widget_Base {

    public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'ale-years_tabs', ALETHEME_THEME_URL. '/aletheme/elementor/js/widget-ale-years_tabs.js', [ 'elementor-frontend' ], ALETHEME_THEME_VERSION, true );
			return [ 'ale-years_tabs' ];
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
			'integration-class' => 'Ale_WPML_Elementor_Widget_Years_Tabs',
	  ];

	  return $widgets;
	}

	/**
	 * Get widget name
	 */

	public function get_name() {
		return 'ale_years_tabs';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Years Tabs', 'ale' );
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
			'bg_image',
			[
				'label' => esc_html__( "Box Background", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
        );
        

        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image',
			[
				'label' => esc_html__( "Tab Photo", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
        );
        
		$repeater->add_control(
			'tab',
			[
				'label' => esc_html__( "Tab Name", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
        );
        
		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( "Title", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
        );

		$repeater->add_control(
			'text',
			[
				'label' => esc_html__( "Text", "ale" ),
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
				'title_field' => '{{{ tab }}}',
			]
		);
		

		$this->end_controls_section();


	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {

        wp_enqueue_script( 'tabslet' );

        $settings = $this->get_settings_for_display();
        $bg_style = '';
        $bg_style = 'style="background-image:url('.esc_url($settings['bg_image']['url']).'); background-size:cover;"';
        ?>
        
        <div class="olins_years_tabs" <?php echo vet_wp_kses($bg_style); ?>>
            <div class='tabs'>
                <ul class="years_nav cf">
                    <?php foreach($settings['tabs'] as $item){ ?>
                        <li><a href="#tab-<?php echo esc_attr(str_replace(' ','-',$item['tab'])); ?>"><?php echo esc_attr($item['tab']); ?></a></li>
                    <?php } ?>
                </ul>

                <?php foreach($settings['tabs'] as $tabitem){ ?>
                    <div id='tab-<?php echo esc_attr(str_replace(' ','-',$tabitem['tab'])); ?>' style="display: none;" class="olins-tab-container">
                        <div class="tab_content content_wrapper">
                            <?php if(!empty($tabitem['image']['url'])){ ?>
                                <div class="image">
                                    <img src="<?php echo esc_url($tabitem['image']['url']); ?>" alt="<?php echo esc_attr($tabitem['title']); ?>" />
                                </div>
                            <?php } ?>
                            <div class="text cf">
                                <div class="tab_name">
                                    <span class="separator"></span>
                                    <span class="tab_title"><?php echo esc_attr($tabitem['tab']); ?></span>
                                </div>
                                <?php if(!empty($tabitem['title'])){ ?>
                                    <div class="title font_two">
                                        <?php echo esc_attr($tabitem['title']); ?>
                                    </div>
                                <?php } ?>
                                <?php if(!empty($tabitem['text'])){ ?>
                                    <p>
                                        <?php echo vet_wp_kses($tabitem['text']); ?>
                                    </p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <?php

	}

}
