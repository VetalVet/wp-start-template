<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Price_Item extends \Elementor\Widget_Base {

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
					'field' => 'amount',
					'type' => $this->get_title() .'<br />'. esc_html__( "The Amount (Price)", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'title',
					'type' => $this->get_title() .'<br />'.  esc_html__( "Price Title", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'description',
					'type' => $this->get_title() .'<br />'. esc_html__( "Price Description", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'category',
					'type' => $this->get_title() .'<br />'. esc_html__( "Category", "ale" ),
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
		return 'ale_price_item';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Price Item', 'ale' );
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
			'image',
			[
				'label' => esc_html__( "Pricing Image", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
        );

        $this->add_control(
			'images',
			[
				'label' => esc_html__( "Slider Images", "ale" ),
				'type' => \Elementor\Controls_Manager::GALLERY,
                'default' => [],
                'conditions' => array(
                    'relation' => 'or',
                    'terms'    => array(
                      array(
                        'name'     => 'style',
                        'operator' => '==',
                         'value'   => 'default',
                      ),
                    )
                  ),
			]
		);

		$this->add_control(
			'amount',
			[
				'label' => esc_html__( "The Amount (Price)", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );
        
		$this->add_control(
			'title',
			[
				'label' => esc_html__( "Price Title", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

        $this->add_control(
			'description',
			[
				'label' =>  esc_html__( "Price Description", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );

        $this->add_control(
			'badge',
			[
				'label' => esc_html__( "Badge Image", "ale" ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'conditions' => array(
                    'relation' => 'or',
                    'terms'    => array(
                      array(
                        'name'     => 'style',
                        'operator' => '==',
                         'value'   => 'cafeteria',
                      ),
                    )
                  ),
			]
        );

        $this->add_control(
			'category',
			[
				'label' =>  esc_html__( "Category", "ale" ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'conditions' => array(
                    'relation' => 'or',
                    'terms'    => array(
                      array(
                        'name'     => 'style',
                        'operator' => '==',
                         'value'   => 'cafeteria',
                      ),
                    )
                  ),
			]
        );
        

        $this->add_control(
			'blockstyle',
			[
				'label' => esc_html__( "Style", "ale" ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
                    'border' => 'Border',
                    'colored' => 'Colored',
                ],
                'conditions' => array(
                    'relation' => 'or',
                    'terms'    => array(
                      array(
                        'name'     => 'style',
                        'operator' => '==',
                         'value'   => 'kitty',
                      ),
                    )
                  ),
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
                    'cafeteria' =>'Cafeteria Style',
                    'smoothie' => 'Smoothie Style',
                    'kitty' => 'Kitty Style',
                    'cosushi' => 'coSushi Style',
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

        $image_src = $settings['image']['url'];

        
        
        if(!empty($settings['images'])){
            $slider_images =  $settings['images'];
        }

        ?>
        <?php if($settings['style'] == 'cafeteria'){ ?>
            <div class="cafeteria_pricing_element">
                <div class="item-top">
                    <div class="item-logo" <?php if(!empty($settings['badge']['url'])){ echo 'style="background-image:url('.esc_url(wp_get_attachment_url($settings['badge']['id'])).');"';} ?>></div>
                    <span class="font_two"><?php echo esc_attr($settings['category']); ?></span>
                </div>
                <img src="<?php echo esc_attr($image_src); ?>" alt="<?php echo esc_attr($settings['title']); ?>"/>
                <div class="item-info">
                    <h2 class="firstfont font_one caption colormain"><?php echo esc_attr($settings['title']); ?></h2>
                    <p class="text">
                        <?php echo esc_attr($settings['description']); ?>
                    </p>
                </div>
                <div class="item-price">
                    <h3 class="firstfont font_one"><?php echo esc_attr($settings['amount']); ?></h3>
                </div>
                <div class="item-rombs"></div>
            </div>
        <?php } else if($settings['style'] == 'smoothie'){ ?>
            <div class="smoothie_pricing_element">
                <div class="image">
                    <img src="<?php echo esc_attr($image_src); ?>" alt="<?php echo esc_attr($settings['title']); ?>"/>
                </div>
                <div class="title_desc">
                    <h3><?php echo esc_attr($settings['title']); ?></h3>
                    <p class="text">
                        <?php echo esc_attr($settings['description']); ?>
                    </p>
                </div>
                <div class="price font_two">
                    <?php echo esc_attr($settings['amount']); ?>
                </div>
            </div>
        <?php } else if($settings['style'] == 'kitty'){ ?>
            <div class="kitty_pricing_element <?php echo esc_attr($settings['blockstyle']); ?>">
                <h3 class="font_one"><?php echo vet_wp_kses($settings['title']); ?></h3>
                <div class="image">
                    <img src="<?php echo esc_attr($image_src); ?>" alt="<?php echo esc_attr($settings['title']); ?>"/>
                </div>
                <div class="desc">
                    <p class="text">
                        <?php echo vet_wp_kses($settings['description']); ?>
                    </p>
                </div>
                <div class="price font_one">
                    <?php echo vet_wp_kses($settings['amount']); ?>
                </div>
            </div>
        <?php } else if($settings['style'] == 'cosushi'){ ?>
            <div class="cosushi_pricing_element">
                <div class="titleprice">
                    <h3 class="font_one"><?php echo vet_wp_kses($settings['title']); ?></h3>
                    <div class="separator"></div>
                    <div class="price">
                    <?php echo vet_wp_kses($settings['amount']); ?>
                    </div>
                </div>
                <p class="text">
                <?php echo vet_wp_kses($settings['description']); ?>
                </p>
            </div>
        <?php } else { ?>
            <div class="olins_pricing_element">

                <?php

                if(!empty($slider_images)) {
                    echo "<div class='destination_viaje_slider'>";
                    foreach($slider_images as $slide_image){
                        
                        echo '<div><img src="'.$slide_image['url'].'" alt="'.$settings['title'].'"></div>';
                    }
                    echo "</div>";
                } elseif($image_src){ ?>
                    <div class="image_holder">
                        <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($settings['title']); ?>" title="<?php echo esc_attr($settings['title']); ?>" />
                    </div>
                <?php } ?>
                <div class="data_holder">
                    <?php if($settings['amount']){?>
                        <div class="price_holder font_one">
                            <?php echo esc_attr($settings['amount']); ?>
                        </div>
                    <?php } ?>

                    <?php if($settings['title']){ ?>
                        <div class="title_holder">
                            <?php echo esc_attr($settings['title']); ?>
                        </div>
                    <?php } ?>

                    <?php if($settings['description']){
                        echo '<div class="description_holder">'.vet_wp_kses($settings['description']).'</div>';
                    } ?>
                </div>
            </div>
        <?php } ?>





        <?php

	}

}
