<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'WPML_Elementor_Module_With_Items' ) )
{
	class Ale_WPML_Elementor_Widget_Timeline extends WPML_Elementor_Module_With_Items {

		public function get_items_field() {
			return 'tabs';
		}

		public function get_fields() {
			return array( 'title', 'text', 'date' );
		}

		protected function get_title( $field ) {
			switch( $field ) {
				case 'title':
					return esc_html__( "Title", "ale" );
				case 'text':
					return esc_html__( "Text", "ale" );
				case 'date':
					return esc_html__( "Date", "ale" );
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
				case 'date':
					return 'LINE';
				default:
					return '';
			}
		}

	}
}

class Ale_Elementor_Widget_Ale_Timeline extends \Elementor\Widget_Base {

    

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
			'integration-class' => 'Ale_WPML_Elementor_Widget_Timeline',
	  ];

	  return $widgets;
	}

	/**
	 * Get widget name
	 */

	public function get_name() {
		return 'ale_timeline';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Timeline', 'ale' );
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
				'label' => esc_html__( "Image", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
                'label_block' => true,
                
			]
        );
        
		$repeater->add_control(
			'date',
			[
				'label' => esc_html__( "Date", "ale" ),
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
				'title_field' => '{{{ title }}}',
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
                    'donation' => 'Donation Style',
                    'nunta' => 'Nunta Style',
                    'cafeteria' => 'Cafeteria Style',
                    'organic' =>'Organic Style'
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
        
        <?php if($settings['style'] == 'donation'){ 
            wp_enqueue_script('slick');
            ?>
            <div class="donation_timeline_shortcoe">
                <?php foreach($settings['tabs'] as $item){?>
                    <div class="timeline_item">
                        <div class="col-6 text">
                            <p><?php if ($item['text']) echo esc_attr( $item['text'] );  ?></p>
                        </div>

                        <div class="col-6 date">
                            <h2><?php if($item['date']) echo esc_attr( $item['date'] ); ?></h2>
                        </div>
                        <div class="vert-line-1"></div>
                        <div class="vert-line-2"></div>
                    </div>
                <?php } ?>
            </div>
        <?php } elseif($settings['style'] == 'nunta'){?>
            <div class="nunta_lenta">
                <?php foreach($settings['tabs'] as $item){?>
                    <div class="coloritem">
                        <div class="leftpart">
                            <div class="roundbox">
                            
                                <?php if(!empty($item['image']['id'])){
                                    echo vet_wp_kses(wp_get_attachment_image($item['image']['id'], 'full'));
                                } ?>
                                <div class="maskcolor">
                                    <span class="mainfont font_one">
                                        <?php echo esc_attr($item['title']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="rightpart">
                            <div class="datebox mainfont font_one"><?php echo esc_attr($item['date']); ?></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } elseif($settings['style'] == 'organic'){?>
            <div class="organic_lenta">
                <?php foreach($settings['tabs'] as $item){?>
                    <div class="organic_timeline_item">
                        <div class="image_holder">
                            <?php if(!empty($item['image']['id'])){
                                echo vet_wp_kses(wp_get_attachment_image($item['image']['id'], 'full'));
                            } ?>
                        </div>
                        <div class="data_holder">
                            <h2><?php echo esc_attr($item['title']); ?></h2>
                            <span><?php if($item['date']) echo esc_attr( $item['date'] ); ?></span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } elseif($settings['style'] == 'cafeteria'){ ?>
            <div class="nunta_event_timeline events-time-line">
                <div class="center-align content">
                    <div class="back-line"></div>
                    <div class="cub-top"></div>
                    <div class="cub-bot"></div>

                    <?php foreach($settings['tabs'] as $item){?>
                        <div class="item cf">
                            <div class="text">
                                <h2 class="caption firstfont font_one colormain"><?php echo esc_attr($item['title']); ?></h2>
                                <?php if ($item['text']) echo esc_attr( $item['text'] );  ?>
                                <div class="info">
                                    <h3 class="firstfont font_one"><?php if($item['date']) echo esc_attr( $item['date'] ); ?></h3>
                                </div>
                            </div>
                            <div class="circle">
                                <div class="circ"></div>
                                <div class="line"></div>
                            </div>
                            <div class="img">
                                <?php if(!empty($item['image']['id'])){
                                    echo vet_wp_kses(wp_get_attachment_image($item['image']['id'], 'full'));
                                } ?>
                                <div class="shadow"></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="olins_timeline">
                <?php foreach($settings['tabs'] as $item){?>
                    <div class="olins_timeline_item">
                        <?php if($item['date']){
                            echo '<div class="date_field">'.esc_attr($item['date']).'</div>';
                        } ?>
                        <?php if($item['title']){
                            echo '<div class="title_field">'.esc_attr($item['title']).'</div>';
                        } ?>
                        <?php if($item['text']){
                            echo '<div class="text_field">'.esc_attr($item['text']).'</div>';
                        } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <?php

	}

}
