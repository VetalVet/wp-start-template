<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Search_Box extends \Elementor\Widget_Base {


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
					'type' => $this->get_title() .'<br />'. esc_html__( "Title #1", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'pretitle',
					'type' => $this->get_title() .'<br />'. esc_html__( "Pre Title", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'text',
					'type' => $this->get_title() .'<br />'. esc_html__( "Description #1", "ale" ),
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
		return 'ale_search_box';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Search Box', 'ale' );
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
			'title',
			[
				'label' => esc_html__( "Title #1", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );

		$this->add_control(
			'pretitle',
			[
				'label' =>esc_html__( "Pre Title", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );

		$this->add_control(
			'text',
			[
				'label' =>esc_html__( "Description #1", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
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
                    'default' => 'Default Style',
                    'hai' => 'Hai Style',
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

        <?php if($settings['style'] == 'hai'){?>
            <div class="hai_search_element">
                <form class="search" role="search" method="get" id="searchform" action="<?php echo site_url()?>" >
                    <i class="fa fa-compass" aria-hidden="true"></i>
                    <input  type="text" class="searchinput" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php esc_html_e('Where you want to go?', 'ale')?>">
                    <button type="submit" class="search_button"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>

        <?php } else {?>
            <div class="exotico_search_element">
                <div class="about">
                    <?php if($settings['title']){ ?><h1 class="about__title font_three"><?php echo esc_attr($settings['title']); ?></h1><?php } ?>

                    <?php if($settings['pretitle']){ ?><div class="about__sub-title"><?php echo esc_attr($settings['pretitle']); ?></div><?php } ?>

                    <?php if($settings['text']){ ?><p><?php echo esc_attr($settings['text']); ?></p><?php } ?>
                </div>
                <!-- end about-->


                <form class="search cf" role="search" method="get" id="searchform" action="<?php echo site_url()?>" >
                    <input  type="text" class="searchinput" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php esc_html_e('Find in catalog', 'ale')?>">
                    <button type="submit" class="font_three"><?php esc_html_e('Search','ale'); ?><i class="search__icon"></i></button>
                </form>
                <!-- end search -->
            </div>
        <?php } ?>

        <?php

	}

}
