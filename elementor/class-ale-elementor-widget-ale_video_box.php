<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Video_Box extends \Elementor\Widget_Base {


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
					'type' => $this->get_title() .'<br />'. esc_html__( "Video Title", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'desc',
					'type' => $this->get_title() .'<br />'. esc_html__( "Video Short Description", "ale" ),
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
		return 'ale_video_box';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Video Box', 'ale' );
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
			'video',
			[
				'label' =>   esc_html__( "Video Link", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );

		$this->add_control(
			'title',
			[
				'label' => esc_html__( "Video Title", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );

		$this->add_control(
			'desc',
			[
				'label' => esc_html__( "Video Short Description", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );

        $this->add_control(
			'image',
			[
				'label' => esc_html__( "Video Thumb", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
        );

        $this->end_controls_section();


	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {
        wp_enqueue_script( 'venobox' );
		$settings = $this->get_settings_for_display();
        
        $bg_styles = '';
        $bg_styles = 'style="background-image:url('.esc_url($settings['image']['url']).');"';
        ?>

        <div class="olins_video_box">
            <?php if(ALETHEME_DESIGN_STYLE == 'exotico'){ ?>
                <div class="video-thumb"  <?php echo vet_wp_kses($bg_styles); ?>>
                    <div class="overlay-layer">
                        <div class="ins-overlay-layer">

                            <div class="video-prev">
                                <a href="<?php echo esc_url($settings['video']); ?>" class="video-prev__btn venobox" data-type="youtube" ></a>

                                <div class="video-prev__entry">
                                    <h1 class="video-prev__title font_three"><?php echo esc_attr($settings['title']); ?></h1>
                                    <p><?php echo esc_attr($settings['desc']); ?></p>
                                </div>
                                <!-- end video entry -->
                            </div>
                        </div>
                    </div>
                    <!-- end overlay layer -->
                </div>
            <?php } elseif(ALETHEME_DESIGN_STYLE == 'limpieza'){ ?>
                <section class="about-video">
                    <div class="white-bg">
                        <?php if(!empty($settings['image']['url'])){
                            echo '<img src="'.esc_url($settings['image']['url']).'" alt="'.esc_attr($settings['title']).'" />';
                        } ?>

                        <div class="text">
                            <h2>
                                <?php echo esc_attr($settings['title']); ?>
                                <span class="white-col"><?php echo esc_attr($settings['desc']); ?></span>
                            </h2>
                        </div>

                        <span class="icon" id="ale_play_video">
                            <a class="venobox" data-type="youtube" href="<?php echo esc_url($settings['video']); ?>"><i class="fa fa-play white-col red-bg yellow-bg-hover" aria-hidden="true"></i></a>
                        </span>
                    </div>
                </section>
            <?php } else { ?>
            <div class="video_holder">
                <?php if(!empty($settings['image']['url'])){
                    echo '<img src="'.esc_url($settings['image']['url']).'" alt="'.esc_attr($settings['title']).'" />';
                } ?>
                <div class="video_data_mask">
                    <a class="venobox" data-type="youtube" href="<?php echo esc_url($settings['video']); ?>"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                    <div class="font_two video_title"><?php echo esc_attr($settings['title']); ?></div>
                    <div class="font_one video_desc"><?php echo esc_attr($settings['desc']); ?></div>
                </div>
            </div>
            <?php } ?>
        </div>

        <?php

	}

}
