<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'WPML_Elementor_Module_With_Items' ) )
{
	class Ale_WPML_Elementor_Widget_Ale_Simple_Team extends WPML_Elementor_Module_With_Items {

		public function get_items_field() {
			return 'tabs';
		}

		public function get_fields() {
			return array( 'name', 'position' );
		}

		protected function get_title( $field ) {
			switch( $field ) {
				case 'name':
					return esc_html__( "Member Name", "ale" );
				case 'position':
					return esc_html__( "Member Position", "ale" );
				default:
					return '';
			}
		}

		protected function get_editor_type( $field ) {
			switch( $field ) {
				case 'name':
					return 'LINE';
				case 'position':
					return 'LINE';
				default:
					return '';
			}
		}

	}
}

class Ale_Elementor_Widget_Ale_Simple_Team extends \Elementor\Widget_Base {

    public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'ale-simple_team', ALETHEME_THEME_URL. '/aletheme/elementor/js/widget-ale-simple_team.js', [ 'elementor-frontend' ], ALETHEME_THEME_VERSION, true );
			return [ 'ale-simple_team' ];
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
			'integration-class' => 'Ale_WPML_Elementor_Widget_Simple_Team',
	  ];

	  return $widgets;
	}

	/**
	 * Get widget name
	 */

	public function get_name() {
		return 'ale_simple_team';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Simple Team', 'ale' );
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
				'label' => esc_html__( "Member Photo", "ale" ),
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
				'label' => esc_html__( "Member Name", "ale" ),
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
        
		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( "Link", "ale" ),
				'type' => \Elementor\Controls_Manager::URL,
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
				'title_field' => '{{{ name }}}',
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
                     'moka' => 'Moka', 
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
        
        ?>
        
        <div class="olins_simple_team_container">
            <div class="flexslider olins_simple_team">
                <ul class="slides">

                <?php foreach($settings['tabs'] as $slide){
                    $image_src = $slide['image']['url'];
                    ?>

                    <?php if($settings['style'] == 'moka'){ ?>
                        <li class="moka_simple_team">
                            <div class="image_holder">
                                <?php if(!empty($slide['link']['url'])){ ?>
                                    <a href="<?php echo esc_url($slide['link']['url']); ?>" <?php if($slide['link']['is_external'] == 1){ echo 'target="_blank"';}  if ($slide['link']['nofollow']) { echo 'rel="nofollow"'; } ?> >
                                        <img src="<?php echo esc_url($image_src);?>" alt="<?php echo esc_attr($slide['name']); ?>"/>
                                    </a>
                                <?php } else {?>
                                    <img src="<?php echo esc_url($image_src);?>" alt="<?php echo esc_attr($slide['name']); ?>"/>
                                <?php } ?>
                            </div>
                            <?php if($slide['name']){ ?><div class="member_name"><?php echo esc_attr($slide['name']); ?></div><?php } ?>
                            <?php if($slide['position']){ ?><div class="member_position"><?php echo esc_attr($slide['position']); ?></div><?php } ?>
                        </li>
                    <?php } else { ?>
                        <li class="cf">
                            <div class="team_member_item">
                                <div class="name font_two">
                                    <?php if($slide['name']){ ?><span class="member_name"><?php echo esc_attr($slide['name']); ?></span><?php } ?>
                                </div>
                                <div class="photo">
                                    <div class="image_holder">
                                        <?php if(!empty($slide['link']['url'])){ ?>
                                            <a href="<?php echo esc_url($slide['link']['url']); ?>" <?php if($slide['link']['is_external'] == 1){ echo 'target="_blank"';}  if ($slide['link']['nofollow']) { echo 'rel="nofollow"'; } ?> >
                                                <img src="<?php echo esc_url($image_src);?>" alt="<?php echo esc_attr($slide['name']); ?>"/>
                                            </a>
                                        <?php } else {?>
                                            <img src="<?php echo esc_url($image_src);?>" alt="<?php echo esc_attr($slide['name']); ?>"/>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="position font_two">
                                    <?php if($slide['position']){ ?><span class="member_position"><?php echo esc_attr($slide['position']); ?></span><?php } ?>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                <?php } ?>
                </ul>
            </div>
        </div>

        <?php

	}

}
