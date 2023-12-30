<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Works_Masonry_Grid extends \Elementor\Widget_Base {

    public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'ale-works-masonry-grid', ALETHEME_THEME_URL. '/aletheme/elementor/js/widget-ale-works-masonry-grid.js', [ 'elementor-frontend' ], ALETHEME_THEME_VERSION, true );
			return [ 'ale-works-masonry-grid' ];
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
			'fields' => [
			  [
					'field' => 'count',
					'type' => $this->get_title() .'<br />'.  esc_html__( "Items Count", "ale" ),
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
		return 'ale_works_masonry_grid';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Works Masonry Grid', 'ale' );
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
			'count',
			[
                'label' => esc_html__( "Items Count", "ale" ),
                'default' => '-1',
				'type' => \Elementor\Controls_Manager::TEXT,
			]
        );
        
        $this->add_control(
			'grid',
			[
				'label' => esc_html__( "Grid Layout", "ale" ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'optionsgrid',
				'options' => [
                    'travelphotography' => 'Travel Photography', 
                    'viajegrid' => 'Viaje Grid', 
                    'furnituregrid' => 'Furniture Grid',
                    'creativegrid' => 'Creative Grid',
                    'brigittegrid' => 'Brigitte Grid',
                    'stephaniegrid' => 'Stephanie Grid',
                    'optionsgrid' => 'Options Grid',
                    'simplegrid' => 'Simple Grid',
                    'cafeteriagrid' => 'Cafeteria Grid',
                    'haigrid' => 'Hai Grid'
				],
			]
		);


		$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {
        wp_enqueue_script( 'masonry' );
		$settings = $this->get_settings_for_display();

		
        $args = array(
            'posts_per_page'    => $settings['count'],
            'post_type'         => 'works',
        );
        $recent_works = new WP_Query( $args );
        $i = '0';
        $variant_style_class = '';
        $font_variant = '';

        switch ($settings['grid']) {
            case 'viajegrid' :
                $variant_style_class = 'viaje_design';
                break;
            case 'furnituregrid' :
                $variant_style_class = 'furniture_design';
                $font_variant = 'font_two';
                break;
            case 'simplegrid' :
                $variant_style_class = 'simple_design';
                break;
            case 'creativegrid' :
                $variant_style_class = 'creative_design';
                break;
            case 'brigittegrid' :
                $variant_style_class = 'brigitte_design';
                break;
            case 'stephaniegrid' :
                $variant_style_class = 'stephanie_design';
                break;
            case 'optionsgrid' :
                $variant_style_class = 'options_design';
                break;
        }
        if($settings['grid'] == 'viajegrid' or $settings['grid'] == 'furnituregrid'){
            echo '<div class="olins_works_masonry_grid '.esc_attr($variant_style_class).'"><div class="grid-sizer"></div><div class="gutter-sizer"></div>';

            if ( $recent_works->have_posts() ) {

                while ( $recent_works->have_posts() ) {
                    $recent_works->the_post(); ?>

                    <div class="grid_item_work <?php if($i == 5 or $i == 8){ echo 'grid-item--width2';} ?>">
                        <div class="gallery_post">
                            <div class="image">
                                <a href="<?php echo esc_url( the_permalink() ); ?>" class="work_single_page">
                                    <?php if ( $i == 0 ) {
                                        echo get_the_post_thumbnail( get_the_ID(), 'works-viajetin' );
                                    } else if($i == 5){
                                        echo get_the_post_thumbnail( get_the_ID(), 'works-viajebig' );
                                    } else if($i == 8){
                                        echo get_the_post_thumbnail( get_the_ID(), 'works-viajehor' );
                                    } else {
                                        echo get_the_post_thumbnail( get_the_ID(), 'works-viajemini' );
                                    }
                                    ?>
                                </a>
                            </div>
                            <div class="data_mask <?php echo esc_attr($font_variant); ?>">
                                <?php if($grid == 'viajegrid'){ ?>
                                    <a href="<?php echo esc_url( the_permalink() ); ?>" class="icon_eye"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <?php } ?>
                                <div class="bottom_text">
                                    <h3 class="title font_two">
                                        <a href="<?php echo esc_url( the_permalink() ); ?>"><?php echo esc_attr( get_the_title() ); ?></a>
                                    </h3>
                                    <div class="separator"></div>
                                    <?php if($grid == 'viajegrid'){ ?>
                                        <?php if($i == 0 or $i == 5){ ?><p><?php echo ale_limit_excerpt(20); ?></p><?php } ?>
                                    <?php } elseif($grid == 'furnituregrid'){ ?>
                                        <?php $type_terms = get_the_terms( get_the_ID(), "work-category" );
                                        if(!empty($type_terms)){
                                            foreach($type_terms as $term){
                                                if(isset($term->name)){
                                                    echo '<span class="category">'.esc_attr($term->name).'</span>';
                                                } break;
                                            }
                                        } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $i ++;
                }
                wp_reset_postdata();
            } else {
                echo esc_html_e( 'Add some posts in Works Post Type section', 'ale' );
            }
            echo '</div>';
        } else if($settings['grid'] == 'simplegrid'){
            echo '<div class="olins_works_masonry_grid '.esc_attr($variant_style_class).'"><div class="grid-sizer"></div><div class="gutter-sizer"></div>';

            if ( $recent_works->have_posts() ) {

                while ( $recent_works->have_posts() ) {
                    $recent_works->the_post(); ?>

                    <div class="grid_item_work">
                        <div class="gallery_post">
                            <div class="image">
                                <a href="<?php echo esc_url( the_permalink() ); ?>" class="work_single_page">
                                    <?php echo get_the_post_thumbnail( get_the_ID(), 'works-gridmedium' ); ?>
                                </a>
                            </div>
                            <div class="data_mask">
                                <div class="bottom_text">
                                    <h3 class="title font_two">
                                        <a href="<?php echo esc_url( the_permalink() ); ?>"><?php echo esc_attr( get_the_title() ); ?></a>
                                    </h3>
                                    <div class="separator"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $i ++;
                }
                wp_reset_postdata();
            } else {
                echo esc_html_e( 'Add some posts in Works Post Type section', 'ale' );
            }
            echo '</div>';
        } else if($settings['grid'] == 'stephaniegrid'){
            echo '<div class="olins_works_masonry_grid '.esc_attr($variant_style_class).'"><div class="grid-sizer"></div><div class="gutter-sizer"></div>';

            if ( $recent_works->have_posts() ) {

                while ( $recent_works->have_posts() ) {
                    $recent_works->the_post(); ?>

                    <div class="grid_item_work">
                        <div class="stephanie_style">
                            <div class="image_container">
                                <div class="image">
                                    <a href="<?php echo esc_url( the_permalink() ); ?>" class="work_single_page">
                                        <?php echo get_the_post_thumbnail( get_the_ID(), 'works-viajetin' ); ?>
                                    </a>
                                    <div class="title_with_cat">
                                        <h2 class="work_title aspect_color font_one"><a href="<?php echo esc_url(the_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>"><?php the_title(); ?></a></h2>

                                        <?php $type_terms = get_the_terms( get_the_ID(), "work-category" );
                                        if(!empty($type_terms)){
                                            foreach($type_terms as $term){
                                                if(isset($term->name)){
                                                    echo '<span class="category">'.esc_attr($term->name).'</span>';
                                                } break;
                                            }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $i ++;
                }
                wp_reset_postdata();
            } else {
                echo esc_html_e( 'Add some posts in Works Post Type section', 'ale' );
            }
            echo '</div>';
        } else if($settings['grid'] == 'creativegrid'){
            echo '<div class="olins_works_masonry_grid '.esc_attr($variant_style_class).'"><div class="grid-sizer"></div><div class="gutter-sizer"></div>';

            if ( $recent_works->have_posts() ) {

                while ( $recent_works->have_posts() ) {
                    $recent_works->the_post(); ?>

                    <div class="grid_item_work">
                        <div class="creative_style">
                            <a href="<?php echo esc_url(the_permalink()); ?>" class="work_single_page">
                                <?php echo get_the_post_thumbnail( get_the_ID(), 'works-gridmedium' ); ?>
                                <div class="white-mask">
                                    <h3 class="title"><?php echo esc_attr( get_the_title() ); ?></h3>
                                    <?php if(ale_get_meta('post_pre_title',get_the_ID())){ ?>
                                        <span class="pre-title olins_creative_text">
                                            <?php echo esc_attr(ale_get_meta('post_pre_title',get_the_ID())); ?>
                                        </span>
                                    <?php } ?>
                                </div>
                            </a>
                        </div>
                    </div>

                    <?php
                    $i ++;
                }
                wp_reset_postdata();
            } else {
                echo esc_html_e( 'Add some posts in Works Post Type section', 'ale' );
            }
            echo '</div>';
        } else if($settings['grid'] == 'brigittegrid'){
            echo '<div class="olins_works_masonry_grid '.esc_attr($variant_style_class).'"><div class="grid-sizer"></div><div class="gutter-sizer"></div>';

            if ( $recent_works->have_posts() ) {

                while ( $recent_works->have_posts() ) {
                    $recent_works->the_post(); ?>

                    <div class="grid_item_work">
                        <div class="brigitte_style">
                            <div class="simple_opacity">
                                <a href="<?php echo esc_url(the_permalink()); ?>" class="work_single_page">
                                    <?php echo get_the_post_thumbnail(get_the_ID(),'full'); ?>
                                </a>
                            </div>
                            <div class="white-mask">
                                <h3 class="title"><a href="<?php echo esc_url(the_permalink()); ?>" class="work_single_page"><?php echo esc_attr( get_the_title() ); ?></a></h3>
                                <?php $type_terms = get_the_terms( get_the_ID(), "work-category" );
                                if(!empty($type_terms)){
                                    foreach($type_terms as $term){
                                        if(isset($term->name)){
                                            echo '<span class="category">'.esc_attr($term->name).'</span>';
                                        } break;
                                    }
                                } ?>
                            </div>

                        </div>
                    </div>

                    <?php
                    $i ++;
                }
                wp_reset_postdata();
            } else {
                echo esc_html_e( 'Add some posts in Works Post Type section', 'ale' );
            }
            echo '</div>';
        } else if($settings['grid'] == 'optionsgrid'){
            //Columns Settings
            $ale_work_columns = ale_get_option('default_work_columns');
            $ale_columns_class = '';
            if($ale_work_columns){
                $ale_columns_class = 'ale_work_columns_'.esc_attr($ale_work_columns);
            }

            echo '<div class="olins_works_masonry_grid grid works_items_container  '.esc_attr($ale_columns_class).' '.esc_attr($variant_style_class).'"><div class="grid-sizer"></div><div class="gutter-sizer"></div>';

            if ($recent_works->have_posts()) : while ($recent_works->have_posts()) : $recent_works->the_post(); ?>
                <?php 
                    if(ALETHEME_DESIGN_STYLE == 'donation'){
                        get_template_part('partials/work/workpreview_donation' );
                    } elseif(ALETHEME_DESIGN_STYLE == 'moka'){
                        get_template_part('partials/work/workpreview_moka' );
                    } else {
                        get_template_part('partials/work/workpreview' );
                    }
                ?>
            <?php endwhile; else: ?>
                <?php get_template_part('partials/notfound')?>
            <?php endif; wp_reset_postdata();
            echo '</div>';
        } else if($settings['grid'] == 'cafeteriagrid'){

            echo '<div class="cafeteria_works_grid">';
            if ( $recent_works->have_posts() ) {
                while ( $recent_works->have_posts() ) {
                    $recent_works->the_post(); ?>

                    <div class="col-3 element">
                        <div class="background">
                            <a href="<?php the_permalink(); ?>">
                                <div class="hover"></div>
                                <?php echo get_the_post_thumbnail(get_the_ID(),'works-linesmall'); ?>
                            </a>
                            <div class="pic"><i class="fa fa-camera-retro" aria-hidden="true"></i></div>
                            <a class="look" href="<?php the_permalink(); ?>"><?php esc_html_e('Take a look','ale'); ?></a>
                        </div>
                    </div>

                    
                <?php }
                wp_reset_postdata();
            } else {
                echo esc_html_e( 'Add some posts in Works Post Type section', 'ale' );
            }
            echo '</div>';
            
        } else if($settings['grid'] == 'haigrid'){
            echo '<div class="hai_works_masonry_grid">';

            if ( $recent_works->have_posts() ) {

                while ( $recent_works->have_posts() ) {
                    $recent_works->the_post(); ?>

                    <div class="grid_item_work">
                        <div class="image_holder">
                            <a href="<?php echo esc_url( the_permalink() ); ?>" class="work_single_page">
                                <?php echo get_the_post_thumbnail( get_the_ID(), 'full' ); ?>
                            </a>
                        </div>
                        <div class="data_holder">
                            <div class="mask_box">
                                <span class="title font_two">
                                    <a href="<?php echo esc_url( the_permalink() ); ?>"><?php echo esc_html_e('read more', 'ale'); ?></a>
                                </span>
                            </div>
                        </div>
                    </div><?php
                }
                wp_reset_postdata();
            } else {
                echo esc_html_e( 'Add some posts in Works Post Type section', 'ale' );
            }
            echo '</div>';
        } else {
            echo '<div class="olins_works_masonry_grid"><div class="grid-sizer"></div><div class="gutter-sizer"></div>';

            if ( $recent_works->have_posts() ) {

                while ( $recent_works->have_posts() ) {
                    $recent_works->the_post(); ?>

                    <div class="grid_item_work">
                        <div class="hover_holder">
                            <div class="image_holder">
                                <a href="<?php echo esc_url( the_permalink() ); ?>" class="work_single_page">
                                    <?php if ( $i == 0 or $i == 2 or $i == 3 or $i == 9 or $i == 10 or $i == 11 ) {
                                        echo get_the_post_thumbnail( get_the_ID(), 'works-photobig' );
                                    } else {
                                        echo get_the_post_thumbnail( get_the_ID(), 'works-photosmall' );
                                    }
                                    ?>
                                </a>
                            </div>
                            <div class="data_holder">
                                <h3 class="title">
                                    <a href="<?php echo esc_url( the_permalink() ); ?>"><?php echo esc_attr( get_the_title() ); ?></a>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <?php
                    $i ++;
                }
                wp_reset_postdata();
            } else {
                echo esc_html_e( 'Add some posts in Works Post Type section', 'ale' );
            }
            echo '</div>';
        }
        ?>

        <?php

	}

}
