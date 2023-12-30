<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Works_Vertical_Slider extends \Elementor\Widget_Base {

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
					'type' => $this->get_title() .'<br />'. esc_html__( "Slider Title", "ale" ),
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
		return 'ale_works_vertical_slider';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Works Vertical Slider', 'ale' );
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
    
    public function get_works_taxonomies(){
        $categories = get_terms( array(
            'orderby'      => 'name',
            'pad_counts'   => false,
            'hierarchical' => 1,
            'hide_empty'   => true,
        ) );
    
        $result = array();
    
        foreach( $categories as $category ) {
    
            if ($category->taxonomy == 'work-category' ) {
                $result[$category->slug] =  $category->name;
            }
        }
    
        return $result;
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
				'label' => esc_html__( "Slider Title", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

        $this->add_control(
			'slug',
			[
				'label' => esc_html__( "Style", "ale" ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->get_works_taxonomies(),
			]
		);
        

		$this->end_controls_section();


	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {
        wp_enqueue_style('swiper');
        wp_enqueue_script( 'swiper' );

		$settings = $this->get_settings_for_display();

        

		$ale_po_portfolio_categories = '';

        if(!empty($settings['slug'])){
            $ale_po_portfolio_categories = get_term_by('slug', $settings['slug'], 'work-category'); 
        }
        ?>

        <div class="ale_po_vertical_slider">
            <?php if($ale_po_portfolio_categories){

                echo '<div class="portfolio_category_box">';
                        $item_name = $ale_po_portfolio_categories->name;
                        echo '<span class="category_name font_two">'.esc_attr($settings['title']).'</span>';
                echo '</div>';

                echo '<div class="swiper-container portfolio_slider_container cf">';
                    $posts_from_term = new WP_Query(array(
                        'post_type' => 'works',
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'work-category',
                                'field'    => 'slug',
                                'terms'    => esc_attr($ale_po_portfolio_categories->slug),
                            ),
                        ),
                    ));

                    if ($posts_from_term->have_posts()){
                        echo '<div class="portfolio-column"><div class="swiper-wrapper cf">';
                        while ($posts_from_term->have_posts()) : $posts_from_term->the_post(); ?>
                            <div class="swiper-slide">
                                <figure>
                                    <a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail(get_the_ID(),'full'); ?></a>
                                    <figcaption class="hover_mask font_two">
                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    </figcaption>
                                </figure>
                            </div>
                        <?php endwhile;
                        echo '</div></div>';
                    }
                    wp_reset_postdata();

                echo '</div>';
            } ?>
        </div>

        
        

        <?php

	}

}
