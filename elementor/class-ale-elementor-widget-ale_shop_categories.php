<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Shop_Categories extends \Elementor\Widget_Base {


	/**
	 * Widget base constructor
	 */

	public function __construct( $data = [], $args = null ) {

		parent::__construct( $data, $args );
	}



	/**
	 * Get widget name
	 */

	public function get_name() {
		return 'ale_shop_categories';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Shop Categories', 'ale' );
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
			'grid',
			[
				'label' =>  esc_html__( "Grid Layout", "ale" ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'hide',
				'options' => [
                     'rossigrid' => 'Rosi Grid', 
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
        
        
        $shop_categories = get_terms('product_cat');

        $i=1;
        echo '<div class="olins_shop_categories_box default_grid">';
        foreach($shop_categories as $category){
    
            $shop_category_image = "";
            $image_meta = "";
    
            $shop_category = get_term($category->term_id, 'product_cat');
            $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
            $shop_category_image = wp_get_attachment_url($thumbnail_id);
    
            if($thumbnail_id){
                $shop_category_image = wp_get_attachment_url($thumbnail_id);
                $image_meta = wp_get_attachment_metadata($thumbnail_id);
            }
    
            $class = '';
    
            if($i == 1) {$class="big";} else if($i == 2) {$class="medium";} else {$class="simple";}
            ?>
            <div class="shop_category_item <?php echo esc_attr($class); ?>">
                <div class="mask"></div>
    
                <?php
                if($thumbnail_id){
                    if($class == 'big' or $class == 'medium'){
                        if($image_meta['height'] > 460){ ?>
                            <div class="shop_category_scroll" data-scroll-speed="8" data-scroll-type="background" style="background-image:url(<?php echo esc_url($shop_category_image); ?>);"></div>
                        <?php } else { ?>
                            <img src="<?php echo esc_url($shop_category_image); ?>" alt="<?php esc_html_e('Preview','ale'); ?>" />
                        <?php }
                    } else {
                        if($image_meta['height'] > 350){ ?>
                            <div class="shop_category_scroll" data-scroll-speed="16" data-scroll-type="background" style="background-image:url(<?php echo esc_url($shop_category_image); ?>);"></div>
                        <?php } else { ?>
                            <img src="<?php echo esc_url($shop_category_image); ?>" alt="<?php esc_html_e('Preview','ale'); ?>" />
                        <?php }
                    }
                } ?>
                <a class="box_mask" href="<?php echo esc_url(get_term_link($shop_category->term_id,'product_cat')); ?>"></a>
    
                <div class="title_holder">
                    <h3 class="title font_two">
                        <a href="<?php echo esc_url(get_term_link($shop_category->term_id,'product_cat')); ?>"># <?php echo esc_attr($shop_category->name); ?></a>
                    </h3>
                    <span class="items_count"><?php echo esc_attr($shop_category->count); ?> <?php echo esc_html_e('items','ale'); ?></span>
                </div>
            </div>
    
        <?php $i++;}
        echo '</div>';


	}

}
