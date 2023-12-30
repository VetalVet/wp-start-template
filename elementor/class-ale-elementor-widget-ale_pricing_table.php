<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Pricing_Table extends \Elementor\Widget_Base {

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
					'type' => $this->get_title() .'<br />'. esc_html__( "Plan Title", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'currency',
					'type' => $this->get_title() .'<br />'. esc_html__( "Currency", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'price',
					'type' => $this->get_title() .'<br />'. esc_html__( "Price", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'preion',
					'type' => $this->get_title() .'<br />'. esc_html__( "Period", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'description',
					'type' => $this->get_title() .'<br />'. esc_html__( "Description field", "ale" ),
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
		return 'ale_pricing_table';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Pricing Table', 'ale' );
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
				'label' => esc_html__( "Plan Title", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

        $this->add_control(
			'currency',
			[
				'label' =>  esc_html__( "Currency", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );
        
        $this->add_control(
			'price',
			[
				'label' =>  esc_html__( "Price", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );
        
        $this->add_control(
			'preion',
			[
				'label' =>  esc_html__( "Period", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );
        
        $this->add_control(
			'description',
			[
				'label' =>  esc_html__( "Description field", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

        $this->add_control(
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
                     'ospedale' => 'Ospedale', 
                     'smoothie' => 'Smoothie', 
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

        
            <?php if($settings['style'] == 'ospedale'){ ?>
                <div class="olins_ospedale_table">
                    <div class="item">
                        <h4><?php echo esc_attr($settings['title']); ?></h4>
                        <span class="period"><?php echo esc_attr($settings['preion']); ?></span>
                        <div class="price_holder font_three">
                            <?php echo esc_attr($settings['currency']) . esc_attr($settings['price']); ?>
                        </div>
                        <div class="description">
                            <?php echo vet_wp_kses(($settings['description'])); ?>
                        </div>
                        <div class="button_table">
                        <a class="ale_button font_two" href="<?php echo esc_url($settings['link']['url']); ?>" <?php if($settings['link']['is_external'] == 1){ echo 'target="_blank"';}  if ($settings['link']['nofollow']) { echo 'rel="nofollow"'; } ?> >
                            <?php echo esc_html_e('Details','ale'); ?>
                        </a>
                        </div>
                    </div>
                </div>
            <?php } else if($settings['style'] == 'smoothie') { ?>
                <div class="smoothie_pricing_table">
                    <div class="data_holder">
                        <?php if($settings['title']){
                            echo '<h4 class="title">'.esc_attr($settings['title']).'</h4>';
                        } ?>

                        <?php if($settings['price']){ ?>
                            <div class="price font_two">
                                <?php if($settings['currency']){
                                    echo '<span class="currency">'.esc_attr($settings['currency']).'</span>';
                                }
                                echo '<span class="the_price">'.esc_attr($settings['price']).'</span>'; ?>
                            </div>
                        <?php } ?>

                        <?php if($settings['preion']){
                            echo '<div class="period">'.esc_attr($settings['preion']).'</div>';
                        } ?>

                        <?php if($settings['description']){
                            echo '<p class="description">'.esc_attr($settings['description']).'</p>';
                        } ?>

                        <?php if($settings['link']['url']){ ?>
                            <div class="one_button">
                            <a class="ale_button font_one" href="<?php echo esc_url($settings['link']['url']); ?>" <?php if($settings['link']['is_external'] == 1){ echo 'target="_blank"';}  if ($settings['link']['nofollow']) { echo 'rel="nofollow"'; } ?> >
                                <?php echo esc_html_e('View More','ale');?>
                            </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } else { ?>
            <div class="olins_pricing_table">
                <div class="data_holder">
                    <?php if($settings['title']){
                        echo '<div class="title font_two">'.esc_attr($settings['title']).'</div>';
                    } ?>

                    <?php if($settings['price']){ ?>
                        <div class="price font_two">
                            <?php if($settings['currency']){
                                echo '<span class="currency">'.esc_attr($settings['currency']).'</span>';
                            }
                            echo '<span class="the_price">'.esc_attr($settings['price']).'</span>'; ?>
                        </div>
                    <?php } ?>

                    <?php if($settings['preion']){
                        echo '<div class="period">'.esc_attr($settings['preion']).'</div>';
                    } ?>

                    <?php if($settings['description']){
                        echo '<p class="description">'.esc_attr($settings['description']).'</p>';
                    } ?>

                    <?php if($settings['link']['url']){ ?>
                        <div class="one_button">
                        <a class="ale_button font_two" href="<?php echo esc_url($settings['link']['url']); ?>" <?php if($settings['link']['is_external'] == 1){ echo 'target="_blank"';}  if ($settings['link']['nofollow']) { echo 'rel="nofollow"'; } ?> >
                            <?php echo esc_html_e('Details','ale'); ?>
                        </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>

        <?php

	}

}
