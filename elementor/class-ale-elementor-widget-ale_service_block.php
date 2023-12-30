<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Service_Block extends \Elementor\Widget_Base {

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
					'type' => $this->get_title() .'<br />'. esc_html__( "Title", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'desc',
					'type' => $this->get_title() .'<br />'.  esc_html__( "Descriptions", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'price',
					'type' => $this->get_title() .'<br />'. esc_html__( "Price.", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'subtitle',
					'type' => $this->get_title() .'<br />'. esc_html__( "Sub title", "ale" ),
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
		return 'ale_service_block';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Service Block', 'ale' );
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
				'label' => esc_html__( "Icon Image", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
        );

		$this->add_control(
			'title',
			[
				'label' => esc_html__( "Title", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

        $this->add_control(
			'desc',
			[
				'label' =>  esc_html__( "Descriptions", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );
        
        $this->add_control(
			'price',
			[
				'label' =>  esc_html__( "Price.", "ale" ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'conditions' => array(
                    'relation' => 'or',
                    'terms'    => array(
                      array(
                        'name'     => 'style',
                        'operator' => '==',
                         'value'   => 'hai',
                      ),
                      array(
                        'name'     => 'style',
                        'operator' => '==',
                        'value'    => 'enforcement',
                      ),
                    )
                  ),
			]
        );
        

        $this->add_control(
			'button_link',
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
                'conditions' => array(
                    'relation' => 'or',
                    'terms'    => array(
                      array(
                        'name'     => 'style',
                        'operator' => '==',
                         'value'   => 'orquidea',
                      ),
                      array(
                        'name'     => 'style',
                        'operator' => '==',
                        'value'    => 'kitty',
                      ),
                    )
                  ),
			]
        );
        
        $this->add_control(
			'subtitle',
			[
				'label' =>  esc_html__( "Sub title", "ale" ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'conditions' => array(
                    'relation' => 'or',
                    'terms'    => array(
                      array(
                        'name'     => 'style',
                        'operator' => '==',
                         'value'   => 'orquidea',
                      ),
                    )
                  ),
			]
        );

        $this->add_control(
			'close',
			[
				'label' => esc_html__( "Close?", "ale" ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
                    'close' => 'Closed',
                    'opened' => 'Opened',
                ],
                'conditions' => array(
                    'relation' => 'or',
                    'terms'    => array(
                      array(
                        'name'     => 'style',
                        'operator' => '==',
                         'value'   => 'orquidea',
                      ),
                    )
                  ),
			]
        );
        
        $this->add_control(
			'bar_color',
			[
				'label' => esc_html__( "Bar Color", "ale" ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'alpha' => true,
				'selectors' => [
					'{{WRAPPER}} .kitty_service_block' => 'background-color: {{VALUE}}',
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
                    'default' => 'Default Style',
                     'keira' => 'Keira Style',
                     'enforcement' => 'Enforcement Price Style',
                     'enforcement_simple' => 'Enforcement Simple Style',
                     'donation' => 'Donation Style',
                     'orquidea' => 'Orquidea Style',
                     'cafeteria' =>  'Cafeteria Style',
                     'hai' => 'Hai Style',
                     'kitty' => 'Kitty Style',
                     'cosushi' => 'coSushi Style'
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

        $image_src = $settings['image']['id'];

		$slide_button_link = '';
        if(!empty($settings['button_link'])){
            $slide_button_link = $settings['button_link'];
        }

        ?>
        <?php if($settings['style'] == 'keira'){ ?>
            <div class="olins_service_block_keira">
                <div class="image_holder">
                    <?php if($image_src){ echo '<img class="animated" src="'.esc_url(wp_get_attachment_url($image_src)).'" alt="'.esc_attr($settings['title']).'" />'; } ?>
                </div>
                <?php if($settings['title']){
                    echo '<h3 class="title font_two">'.esc_attr($settings['title']).'</h3>';
                }
                if($settings['desc']){
                    echo '<p class="description">'.esc_attr($settings['desc']).'</p>';
                } ?>
            </div>
        <?php } elseif($settings['style'] == 'enforcement'){ ?>

            <article class="enforcement_service_item">
                    <div class="image_box">
                        <?php if($image_src){ echo '<img src="'.esc_url(wp_get_attachment_url($image_src)).'" alt="'.esc_attr($settings['title']).'" />'; } ?>
                    </div>
                <h3><span class="prefix">x</span> <?php echo esc_attr($settings['title']); ?></h3>
                <span class="price"><?php echo esc_attr($settings['price']); ?></span>
                <div class="description">
                    <?php echo esc_attr($settings['desc']); ?>
                </div>
            </article>

        <?php } elseif($settings['style'] == 'enforcement_simple'){ ?>

            <div class="enforcement_item_additional">
                <div class="top_line">
                    <div class="icon"><?php if($image_src){ echo '<img src="'.esc_url(wp_get_attachment_url($image_src)).'" alt="'.esc_attr($settings['title']).'" />'; } ?></div>
                    <h5 class="title"><?php echo esc_attr($settings['title']); ?></h5>
                </div>
                <div class="bottom_line">
                    <?php echo esc_attr($settings['desc']); ?>
                </div>
            </div>

        <?php } elseif($settings['style'] == 'donation'){ ?>
            <article class="donation_events_shortcode">
                <?php if($image_src){ echo '<img src="'.esc_url(wp_get_attachment_url($image_src)).'" alt="'.esc_attr($settings['title']).'" />'; } ?>
                <div class="text">
                    <h2><?php echo esc_attr($settings['title']); ?></h2>
                    <div class="string">
                    <?php echo esc_attr($settings['desc']); ?>
                    </div>
                </div>
                <span class="overlay"></span>
            </article>
        <?php } elseif($settings['style'] == 'orquidea'){
            
            $block_class = 'showtitle';
            $figure_show = 'hide';
                if(isset($settings['close']) && $settings['close'] == 'opened') {
                    $block_class = 'hidetitle';
                    $figure_show = 'show';
                }
            
            ?>
            <div class="orquidea_service">
                <div class="orquigrid cs-style-4">
                
                <div class="ale_orquidea_service_item">
                    <div class="titleservice <?php echo esc_attr($block_class); ?> font_one">
                        <?php echo esc_attr($settings['title']); ?>
                    </div>

                    <figure class="imageservice imageservicerot <?php echo esc_attr($figure_show); ?>">
                        <div><img src="<?php echo esc_url(wp_get_attachment_url($image_src)); ?>" alt="image" /></div>
                        <figcaption>
                            <?php if(isset($settings['subtitle'])){ ?><div class="descrtitle font_two cusstyle4"><?php echo esc_attr($settings['subtitle']); ?></div><?php } ?>
                            <div class="descrtext cusstyle5">
                                <?php echo esc_attr($settings['desc']); ?>
                            </div>
                            <?php if(!empty($slide_button_link)){ ?>
                                <a class="font_two" href="<?php echo esc_url($slide_button_link['url']); ?>" <?php if ($slide_button_link['is_external']) {
                                    echo 'target="' . esc_attr($slide_button_link['is_external']) . '"';
                                }
                                if ($slide_button_link['nofollow']) {
                                    echo 'rel="' . esc_attr($slide_button_link['nofollow']) . '"';
                                } ?> >
                                    <?php 
                                        echo esc_html_e('Take a look', 'ale');
                                    ?>
                                </a>
                            <?php } ?>
                        </figcaption>
                    </figure>
                </div>
                </div>
            </div>
        

        <?php } else if($settings['style'] == 'cafeteria'){?>
            <div class="cafeteria_service_block">
                <div class="circle">
                    <div class="img" style="background-image: url('<?php echo esc_url(wp_get_attachment_url($image_src)); ?>')"></div>
                </div>
                <h2 class="firstfont font_one caption colormain"><?php echo esc_attr($settings['title']); ?></h2>
                <p class="text text-center"><?php echo esc_attr($settings['desc']); ?></p>
            </div>
        <?php } else if($settings['style'] == 'hai'){?>
            <div class="hai_service_block">
                <figure>
                    <img src="<?php echo esc_url(wp_get_attachment_url($image_src)); ?>" alt="<?php echo esc_attr($settings['title']); ?>" />
                    <figcaption>
                        <span class="category font_two"><?php echo esc_attr($settings['desc']); ?></span>
                        <h4 class="title"><?php echo esc_attr($settings['title']); ?></h4>
                        <span class="price font_two"><?php echo esc_attr($settings['price']); ?></span>
                    </figcaption>
                </figure>
            </div>
        <?php } else if($settings['style'] == 'kitty'){?>
            <div class="kitty_service_block" <?php if(!empty($settings['bar_color'])){ echo 'style="background-color: '.$settings['bar_color'].';"';} ?>>
                <figure>
                    <div class="circle"></div>
                    <div class="border_hover"></div>
                    <figcaption>
                        <div class="image_holder">
                            <img src="<?php echo esc_url(wp_get_attachment_url($image_src)); ?>" alt="<?php echo esc_attr($settings['title']); ?>" />
                        </div>
                        <h4 class="title font_one"><?php echo esc_attr($settings['title']); ?></h4>
                        <div class="description font_two"><?php echo esc_attr($settings['desc']); ?></div>
                        
                        <?php if(!empty($slide_button_link)){ ?>
                                <a class="font_one read_more" href="<?php echo esc_url($slide_button_link['url']); ?>" <?php if ($slide_button_link['is_external']) {
                                    echo 'target="' . esc_attr($slide_button_link['is_external']) . '"';
                                }
                                if ($slide_button_link['nofollow']) {
                                    echo 'rel="' . esc_attr($slide_button_link['nofollow']) . '"';
                                } ?> >
                                    <?php 
                                        echo esc_html_e('read more', 'ale');
                                    ?>
                                </a>
                            <?php } ?>
                    </figcaption>
                </figure>
            </div>
        <?php } else if($settings['style'] =="cosushi"){ ?>
            <div class="cosushi_service_block">
                <div class="image_holder">
                    <img src="<?php echo esc_url(wp_get_attachment_url($image_src)); ?>" alt="<?php echo esc_attr($settings['title']); ?>" />
                </div>
                <div class="data_holder">
                    <?php if($settings['title']){
                        echo '<div class="title font_one">'.esc_attr($settings['title']).'</div>';
                    }
                    if($settings['desc']){
                        echo '<div class="description">'.esc_attr($settings['desc']).'</div>';
                    } ?>
                </div>
            </div>
        <?php } else {?>

            <div class="olins_service_block">
                <div class="image_holder">
                    <?php if($image_src){ echo '<img class="animated" src="'.esc_url(wp_get_attachment_url($image_src)).'" alt="'.esc_attr($settings['title']).'" />'; } ?>
                </div>
                <div class="data_holder">
                    <?php if($settings['title']){
                        echo '<div class="title">'.esc_attr($settings['title']).'</div>';
                    }
                    if($settings['desc']){
                        echo '<div class="description">'.esc_attr($settings['desc']).'</div>';
                    } ?>
                </div>
            </div>

        <?php } ?>

        <?php

	}

}
