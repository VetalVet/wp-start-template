<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Corporate_Team extends \Elementor\Widget_Base {

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
					'field' => 'name',
					'type' => $this->get_title() .'<br />'. esc_html__( "Member Name", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'post',
					'type' => $this->get_title() .'<br />'. esc_html__( "Member Post", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'desc',
					'type' => $this->get_title() .'<br />'. esc_html__( "Member Description", "ale" ),
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
		return 'ale_corporate_team';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Corporate Team', 'ale' );
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
				'label' => esc_html__( "Member Photo", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
        );

		$this->add_control(
			'name',
			[
				'label' => esc_html__( "Member Name", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

        $this->add_control(
			'post',
			[
				'label' =>  esc_html__( "Member Post", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );
        
        $this->add_control(
			'desc',
			[
				'label' => esc_html__( "Member Description", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );
        
        $this->add_control(
			'tw',
			[
				'label' =>  esc_html__( "Twitter Link", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
        $this->add_control(
			'fb',
			[
				'label' => esc_html__( "Facebook Link", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
        $this->add_control(
			'gl',
			[
				'label' => esc_html__( "Google Link", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
        $this->add_control(
			'pin',
			[
				'label' =>  esc_html__( "Pinterest Link", "ale" ),
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
                    'default' => 'Default',
                    'rosi' => 'Rosi Style',
                    'enforcement' => 'Enforcement Style',
                    'donation' => 'Donation Style',
                    'orquidea' => 'Orquidea Style',
                    'limpieza' => 'Limpieza Style',
                    'cafeteria' => 'Cafeteria Style',
                    'hai' => 'Hai Style',
                    'smoothie' => 'Smoothie Style',
                    'burger' => 'Burger Style',
                    'laptica' => 'Laptica Style'
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

		    if($settings['style'] == 'rosi'){ ?>
                <div class="rosi_team_style">
                    <?php if($image_src){ ?>
                        <div class="image_box">
                            <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($settings['name']); ?>" />
                        </div>
                    <?php } ?>
                    <div class="team_data">
                        <?php if($settings['name']){
                            echo '<div class="name font_two">'.esc_attr($settings['name']).'</div>';
                        } ?>
                        <?php if($settings['post']){
                            echo '<div class="post">'.esc_attr($settings['post']).'</div>';
                        } ?>
                        <?php if($settings['desc']){
                            echo '<div class="description">'.esc_attr($settings['desc']).'</div>';
                        } ?>
                        <div class="social_link">
                            <?php if($settings['tw']){
                                echo '<a class="tw social_icon" href="'.esc_url($settings['tw']).'"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
                            } ?>
                            <?php if($settings['fb']){
                                echo '<a class="fb social_icon" href="'.esc_url($settings['fb']).'"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
                            } ?>
                            <?php if($settings['gl']){
                                echo '<a class="gl social_icon" href="'.esc_url($settings['gl']).'"><i class="fa fa-google-plus" aria-hidden="true"></i></a>';
                            } ?>
                            <?php if($settings['pin']){
                                echo '<a class="pin social_icon" href="'.esc_url($settings['pin']).'"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>';
                            } ?>
                        </div>
                    </div>
                </div>
            <?php } else if($settings['style'] == 'enforcement'){?>
                <div class="enforcement_team_corporate">
                    <div class="team_item">
                        <div class="image_holder">
                            <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($settings['name']); ?>" />
                            <div class="mask_hover">
                                <div class="social_l">
                                    <?php if(!empty($settings['tw'])){ ?><a href="<?php echo esc_url($settings['tw']); ?>" target="_blank"><?php esc_html_e('TW.','ale'); ?></a><?php } ?>
                                    <?php if(!empty($settings['fb'])){ ?><a href="<?php echo esc_url($settings['fb']); ?>" target="_blank"><?php esc_html_e('FB.','ale'); ?></a><?php } ?>
                                    <?php if(!empty($settings['gl'])){ ?><a href="<?php echo esc_url($settings['gl']); ?>" target="_blank"><?php esc_html_e('GL.','ale'); ?></a><?php } ?>
                                    <?php if(!empty($settings['pin'])){ ?><a href="<?php echo esc_url($settings['pin']); ?>" target="_blank"><?php esc_html_e('PN.','ale'); ?></a><?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="text_holder">
                            <h4><?php echo esc_attr($settings['name']); ?></h4>
                            <?php if($settings['post']){ ?>
                                <span class="team_occupation">
                                    <?php echo esc_attr($settings['post']); ?>
                                </span>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            <?php } else if($settings['style'] == 'donation'){ ?>
                <article class="team_donation_shortcode">
                    <div class="image">
                        <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($settings['name']); ?>" />
                    </div>

                    <div class="text">
                        <h3><?php echo esc_attr($settings['name']); ?></h3>
                        <span class="team-post"><?php echo esc_attr($settings['post']); ?></span>
                        <div class="string">
                            <?php echo esc_attr($settings['desc']); ?>
                        </div>
                        <div class="media-links">
                            <?php if($settings['tw']): ?>
                                <a href="<?php echo esc_url($settings['tw']); ?>"><span class="fa fa-twitter"></span></a>
                            <?php endif; ?>

                            <?php if($settings['fb']): ?>
                                <a href="<?php echo esc_url($settings['fb']); ?>"><span class="fa fa-facebook"></span></a>
                            <?php endif; ?>
                            
                            <?php if($settings['pin']): ?>
                                <a href="<?php echo esc_url($settings['pin']); ?>"><span class="fa fa-pinterest"></span></a>
                            <?php endif; ?>
                            
                            <?php if($settings['gl']): ?>
                                <a href="<?php echo esc_url($settings['gl']); ?>"><span class="fa fa-google"></span></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php } else if($settings['style'] == 'orquidea'){ ?>
                <div class="orquidea_corporate_team">
                    <div class="imagebox">
                        <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($settings['name']); ?>" />
                        <div class="namemask">
                            <div class="namecenter">
                                <span class="nameitem font_one"><?php echo esc_attr($settings['name']); ?></span>
                                <span class="workitem font_two"><?php echo esc_attr($settings['post']); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="workertitle font_one">
                        <?php if($settings['tw']): ?>
                            <a href="<?php echo esc_url($settings['tw']); ?>"><span class="fa fa-twitter"></span></a>
                        <?php endif; ?>

                        <?php if($settings['fb']): ?>
                            <a href="<?php echo esc_url($settings['fb']); ?>"><span class="fa fa-facebook"></span></a>
                        <?php endif; ?>
                        
                        <?php if($settings['pin']): ?>
                            <a href="<?php echo esc_url($settings['pin']); ?>"><span class="fa fa-pinterest"></span></a>
                        <?php endif; ?>
                        
                        <?php if($settings['gl']): ?>
                            <a href="<?php echo esc_url($settings['gl']); ?>"><span class="fa fa-google"></span></a>
                        <?php endif; ?>
                    </div>
                    <div class="workerdescr">
                        <?php echo esc_attr($settings['desc']); ?>
                    </div>
                </div>
            <?php } else if($settings['style'] == 'limpieza'){?>
                <div class="limpieza_team_member">
                        <div class="image left">
                            <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($settings['name']); ?>" />

                            <div class="overlay white-bg">
                                <?php if($settings['tw']): ?>
                                    <a href="<?php echo esc_url($settings['tw']); ?>" class="yellow-col red-col-hover">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if($settings['fb']): ?>
                                    <a href="<?php echo esc_url($settings['fb']); ?>" class="yellow-col red-col-hover">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if($settings['pin']): ?>
                                    <a href="<?php echo esc_url($settings['pin']); ?>" class="yellow-col red-col-hover">
                                        <i class="fa fa-pinterest"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if($settings['gl']): ?>
                                    <a href="<?php echo esc_url($settings['gl']); ?>" class="yellow-col red-col-hover">
                                        <i class="fa fa-google"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="text left">
                            <h3>
                                <span class="black-col yellow-col-hover">
                                    <?php echo esc_attr($settings['name']); ?>
                                    <span><?php echo esc_attr($settings['desc']); ?></span>
                                </span>
                            </h3>
                            <span class="blue-menu-col"><?php echo esc_attr($settings['post']); ?></span>
                        </div>
                </div>
            <?php } else if($settings['style'] == 'cafeteria'){?>
                <div class="cafeteria_team_item">
                    <div class="circle">
                        <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($settings['name']); ?>" /></div>
                    <h2 class="firstfont font_one caption colormain"><?php echo esc_attr($settings['name']); ?></h2>
                    <p class="text">
                        <?php echo esc_attr($settings['desc']); ?>
                    </p>
                </div>
            <?php } else if($settings['style'] == 'hai'){ ?>
                <div class="hai_corporate_team">
                    <?php if($image_src){ ?>
                        <div class="image_box">
                            <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($settings['name']); ?>" />
                            <?php if($settings['post']){
                                echo '<div class="post font_two">'.esc_attr($settings['post']).'</div>';
                            } ?>
                        </div>
                    <?php } ?>
                    <div class="data_holder">
                        <?php if($settings['name']){
                            echo '<div class="name font_two">'.esc_attr($settings['name']).'</div>';
                        } ?>
                        <?php if($settings['desc']){
                            echo '<div class="description">'.esc_attr($settings['desc']).'</div>';
                        } ?>
                        <div class="social_link">
                            <?php if($settings['tw']){
                                echo '<a class="tw social_icon" href="'.esc_url($settings['tw']).'"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
                            } ?>
                            <?php if($settings['fb']){
                                echo '<a class="fb social_icon" href="'.esc_url($settings['fb']).'"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
                            } ?>
                            <?php if($settings['gl']){
                                echo '<a class="gl social_icon" href="'.esc_url($settings['gl']).'"><i class="fa fa-google-plus" aria-hidden="true"></i></a>';
                            } ?>
                            <?php if($settings['pin']){
                                echo '<a class="pin social_icon" href="'.esc_url($settings['pin']).'"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>';
                            } ?>
                        </div>
                    </div>
                </div>
            <?php } else if($settings['style'] == 'smoothie'){ ?>
                <div class="smoothie_corporate_team">
                    <?php if($image_src){ ?>
                        <div class="image_box">
                            <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($settings['name']); ?>" />
                        </div>
                    <?php } ?>
                    <div class="info_data">
                        <?php if($settings['name']){
                            echo '<div class="name">'.esc_attr($settings['name']).'</div>';
                        } ?>
                        <?php if($settings['post']){
                            echo '<div class="post">'.esc_attr($settings['post']).'</div>';
                        } ?>
                        <?php if($settings['desc']){
                            echo '<div class="description">'.esc_attr($settings['desc']).'</div>';
                        } ?>
                        <div class="social_link">
                            <?php if($settings['tw']){
                                echo '<a class="tw social_icon" href="'.esc_url($settings['tw']).'"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
                            } ?>
                            <?php if($settings['fb']){
                                echo '<a class="fb social_icon" href="'.esc_url($settings['fb']).'"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
                            } ?>
                            <?php if($settings['gl']){
                                echo '<a class="gl social_icon" href="'.esc_url($settings['gl']).'"><i class="fa fa-google-plus" aria-hidden="true"></i></a>';
                            } ?>
                            <?php if($settings['pin']){
                                echo '<a class="pin social_icon" href="'.esc_url($settings['pin']).'"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>';
                            } ?>
                        </div>
                    </div>
                </div>
            <?php } else if($settings['style'] == 'burger'){ ?>
                <div class="burger_corporate_team">
                    <?php if($image_src){ ?>
                        <div class="image_box">
                            <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($settings['name']); ?>" />
                        </div>
                    <?php } ?>
                    <div class="info_data">
                        <?php if($settings['name']){
                            echo '<div class="name font_one">'.esc_attr($settings['name']).'</div>';
                        } ?>
                        <?php if($settings['post']){
                            echo '<div class="post">'.esc_attr($settings['post']).'</div>';
                        } ?>
                        <?php if($settings['desc']){
                            echo '<div class="description">'.esc_attr($settings['desc']).'</div>';
                        } ?>
                        <div class="social_link">
                            <?php if($settings['tw']){
                                echo '<a class="tw social_icon" href="'.esc_url($settings['tw']).'"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
                            } ?>
                            <?php if($settings['fb']){
                                echo '<a class="fb social_icon" href="'.esc_url($settings['fb']).'"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
                            } ?>
                            <?php if($settings['gl']){
                                echo '<a class="gl social_icon" href="'.esc_url($settings['gl']).'"><i class="fa fa-google-plus" aria-hidden="true"></i></a>';
                            } ?>
                            <?php if($settings['pin']){
                                echo '<a class="pin social_icon" href="'.esc_url($settings['pin']).'"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>';
                            } ?>
                        </div>
                    </div>
                </div>
            <?php } else if($settings['style'] == 'laptica'){ ?>
                <div class="laptica_team_style">
                    <?php if($image_src){ ?>
                        <div class="image_box">
                            <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($settings['name']); ?>" />
                        </div>
                    <?php } ?>
                    <div class="team_data">
                        <div class="name_post_desc">
                            <?php if($settings['name']){
                                echo '<div class="name font_one">'.esc_attr($settings['name']).'</div>';
                            } ?>
                            <?php if($settings['post']){
                                echo '<div class="post">'.esc_attr($settings['post']).'</div>';
                            } ?>
                            <?php if($settings['desc']){
                                echo '<div class="description">'.esc_attr($settings['desc']).'</div>';
                            } ?>
                        </div>
                        <div class="social_link">
                            <?php if($settings['tw']){
                                echo '<a class="tw social_icon" href="'.esc_url($settings['tw']).'"><span><i class="fa fa-twitter" aria-hidden="true"></i></span></a>';
                            } ?>
                            <?php if($settings['fb']){
                                echo '<a class="fb social_icon" href="'.esc_url($settings['fb']).'"><span><i class="fa fa-facebook" aria-hidden="true"></i></span></a>';
                            } ?>
                            <?php if($settings['gl']){
                                echo '<a class="gl social_icon" href="'.esc_url($settings['gl']).'"><span><i class="fa fa-google-plus" aria-hidden="true"></i></span></a>';
                            } ?>
                            <?php if($settings['pin']){
                                echo '<a class="pin social_icon" href="'.esc_url($settings['pin']).'"><span><i class="fa fa-pinterest-p" aria-hidden="true"></i></span></a>';
                            } ?>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="olins_corporate_team">
                    <?php if($image_src){ ?>
                        <div class="image_box">
                            <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($settings['name']); ?>" />
                        </div>
                    <?php } ?>
                    <?php if($settings['name']){
                        echo '<div class="name">'.esc_attr($settings['name']).'</div>';
                    } ?>
                    <?php if($settings['post']){
                        echo '<div class="post">'.esc_attr($settings['post']).'</div>';
                    } ?>
                    <?php if($settings['desc']){
                        echo '<div class="description">'.esc_attr($settings['desc']).'</div>';
                    } ?>
                    <div class="social_link">
                        <?php if($settings['tw']){
                            echo '<a class="tw social_icon" href="'.esc_url($settings['tw']).'"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
                        } ?>
                        <?php if($settings['fb']){
                            echo '<a class="fb social_icon" href="'.esc_url($settings['fb']).'"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
                        } ?>
                        <?php if($settings['gl']){
                            echo '<a class="gl social_icon" href="'.esc_url($settings['gl']).'"><i class="fa fa-google-plus" aria-hidden="true"></i></a>';
                        } ?>
                        <?php if($settings['pin']){
                            echo '<a class="pin social_icon" href="'.esc_url($settings['pin']).'"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>';
                        } ?>
                    </div>

                </div>
            <?php } 

	}

}
