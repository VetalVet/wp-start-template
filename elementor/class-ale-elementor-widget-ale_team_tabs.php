<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'WPML_Elementor_Module_With_Items' ) )
{
	class Ale_WPML_Elementor_Widget_Team_Tabs extends WPML_Elementor_Module_With_Items {

		public function get_items_field() {
			return 'tabs';
		}

		public function get_fields() {
			return array( 'title', 'text', 'position' );
		}

		protected function get_title( $field ) {
			switch( $field ) {
				case 'title':
					return esc_html__( "Member Name", "ale" );
				case 'text':
					return esc_html__( "Description", "ale" );
				case 'position':
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
				case 'position':
					return 'LINE';
				default:
					return '';
			}
		}

	}
}

class Ale_Elementor_Widget_Ale_Team_Tabs extends \Elementor\Widget_Base {

    public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'ale-team_tabs', ALETHEME_THEME_URL. '/aletheme/elementor/js/widget-ale-team_tabs.js', [ 'elementor-frontend' ], ALETHEME_THEME_VERSION, true );
			return [ 'ale-team_tabs' ];
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
			'integration-class' => 'Ale_WPML_Elementor_Widget_Team_Tabs',
	  ];

	  return $widgets;
	}

	/**
	 * Get widget name
	 */

	public function get_name() {
		return 'ale_team_tabs';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Team Tabs', 'ale' );
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
			'title',
			[
				'label' => esc_html__( "Member Name", "ale" ),
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
				'label' => esc_html__( "Description", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
        );

		$repeater->add_control(
			'position',
			[
				'label' => esc_html__( "Member Position", "ale" ),
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
				'title_field' => '{{{ title }}}',
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
        
        ?>
        
        <div class="olins_team_tabs" >
            <div class='tabs'>
                <ul class="team_nav cf">
                    <?php foreach($settings['tabs'] as $slidenav) { ?>
                        <li><a href="#tab-<?php echo esc_attr(str_replace(' ','-',$slidenav['image']['id'])); ?>"><img class="team_tab_nav_item" src="<?php echo esc_url($slidenav['image']['url']); ?>" alt="<?php esc_html_e('Tab image','ale'); ?>" /></a></li>
                    <?php } ?>
                </ul>
                
                <?php foreach($settings['tabs'] as $slide) { ?>
                    <div id='tab-<?php echo esc_attr(str_replace(' ','-',$slide['image']['id'])); ?>' style="display: none;" class="olins-tab-container">
                            <div class="tab_content">

                                <div class="text cf">
                                    <?php if($slide['position']){ ?>
                                        <div class="tab_name">
                                            <span class="separator"></span>
                                            <span class="tab_title"><?php echo esc_attr($slide['position']); ?></span>
                                        </div>
                                    <?php } ?>
                                    <?php if(!empty($slide['title'])){ ?>
                                        <div class="title font_two">
                                            <?php echo esc_attr($slide['title']); ?>
                                        </div>
                                    <?php } ?>
                                    <?php if(!empty($slide['text'])){ ?>
                                        <p>
                                            <?php echo vet_wp_kses($slide['text']); ?>
                                        </p>
                                    <?php } ?>
                                </div>

                                <?php if(!empty($slide['image']['url'])){ ?>
                                    <div class="image">
                                        <img src="<?php echo esc_url($slide['image']['url']); ?>" alt="<?php echo esc_attr($slide['title']); ?>" />
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                <?php } ?>
                        

            </div>
        </div>

        <?php

	}

}
