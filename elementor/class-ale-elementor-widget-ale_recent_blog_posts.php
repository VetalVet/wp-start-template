<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Recent_Blog_Posts extends \Elementor\Widget_Base {

    public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_register_script( 'ale-recent_blog_posts', ALETHEME_THEME_URL. '/aletheme/elementor/js/widget-ale-recent_blog_posts.js', [ 'elementor-frontend' ], ALETHEME_THEME_VERSION, true );
			return [ 'ale-recent_blog_posts' ];
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
		return 'ale_recent_blog_posts';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Recent Blog Posts', 'ale' );
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
				'default' => 'default',
				'options' => [
                    'default' => 'Theme Options Style (uses Blog Styles)',
                    'rosi' => 'Rosi Style',
                    'keira' => 'Keira Style',
                    'exotico' => 'Exotico Style',
                    'prestigio' => 'Prestigio Style',
                    'ospedale' => 'Ospedale Style',
				],
			]
		);
        $this->add_control(
			'posttype',
			[
				'label' => esc_html__( "Post type", "ale" ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'post',
				'options' => [
                    'post' => 'Posts',
                    'works' => 'Works',
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

		
        if($settings['posttype']){
            $ale_post_type = $settings['posttype'];
        } else {
            $ale_post_type = 'post';
        }
        $args = array(
            'posts_per_page'    => $settings['count'],
            'post_type'         => $ale_post_type,
        );
        if($settings['grid'] == 'rosi'){
            $recent_posts = new WP_Query( $args ); ?>
        
            <div class="blog_grid grid ale_blog_columns_3 ale_blog_text_align_left">
                <div class="grid-sizer"></div>
                <div class="gutter-sizer"></div>
                <?php if ($recent_posts->have_posts()) : while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                    <article <?php post_class('grid-item'); ?> id="post-<?php the_ID()?>" data-post-id="<?php the_ID()?>">
                        <?php if(get_the_post_thumbnail(get_the_ID(),'large')){ ?>
                            <div class="post_image_holder">
                                <a href="<?php echo esc_url(the_permalink()); ?>">
                                    <?php echo get_the_post_thumbnail(get_the_ID(),'post-vertical'); ?>
                                </a>
                            </div>
                        <?php } ?>
                        <div class="post_content_holder">
                            <?php echo '<span class="date font_two">'.esc_attr(get_the_date()).'</span>'; ?>
                            <h3 class="post_title"><a href="<?php esc_url(the_permalink()); ?>"><?php esc_attr(the_title()); ?></a></h3>
                            <p class="post_excerpt">
                                <?php echo ale_limit_excerpt(20); ?>
                            </p>
                            <a class="ale_button font_two" href="<?php echo esc_url(the_permalink()); ?>"><?php esc_html_e('Read More','ale'); ?></a>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); else: ?>
                    <?php get_template_part('partials/notfound')?>
                <?php endif; ?>
            </div>
        <?php } elseif($settings['grid'] == 'donation'){ ?>
            
            
        
        <?php } else if($settings['grid'] == 'keira'){
        
            $recent_posts = new WP_Query( $args ); ?>
            <div class="olins_events_list">
                <?php if ($recent_posts->have_posts()) : while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                    <article <?php post_class('event_item'); ?> id="post-<?php the_ID()?>" data-post-id="<?php the_ID()?>">
                        <?php if(get_the_post_thumbnail(get_the_ID(),'full')){ ?>
                        <div class="post_image_holder">
                            <a href="<?php echo esc_url(the_permalink()); ?>">
                                <?php echo get_the_post_thumbnail(get_the_ID(),'works-squaresmall'); ?>
                            </a>
                        </div>
                        <?php } ?>
                        <div class="date_container">
                            <span class="date"><?php echo esc_attr(get_the_date()) ?></span>
                            <span class="line"></span>
                        </div>
                        <h3 class="font_two">
                            <a href="<?php esc_url(the_permalink()); ?>"><?php esc_attr(the_title()); ?></a>
                        </h3>
                    </article>
                <?php endwhile; wp_reset_postdata(); else: ?>
                    <?php get_template_part('partials/notfound')?>
                <?php endif; ?>
            </div>
        <?php } else if($settings['grid'] == 'ospedale'){
        
        $recent_posts = new WP_Query( $args ); ?>
            <div class="ospedale_blogposts">
                <?php if ($recent_posts->have_posts()) : while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                    <article <?php post_class('blogitem col-3'); ?> id="post-<?php the_ID()?>" data-post-id="<?php the_ID()?>">
                        
                        <div class="blog1"><a href="<?php esc_url(the_permalink()); ?>"><strong><?php esc_attr(the_title()); ?></strong></a></div>
                        <div class="blog2"><?php echo esc_attr(get_the_date()) ?></div>
                        <div class="blog3">
                            <?php echo ale_trim_excerpt(10); ?>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); else: ?>
                    <?php get_template_part('partials/notfound')?>
                <?php endif; ?>
            </div>
        <?php } else if($settings['grid'] == 'exotico'){
            $recent_posts = new WP_Query( $args ); ?>
            <div class="olins_recent_blog_posts_exotico">
                <div class="blogs blogs_home">
                    <?php if ($recent_posts->have_posts()) : while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                    <article <?php post_class('blog'); ?> id="post-<?php the_ID()?>" data-post-id="<?php the_ID()?>">
                        <?php if(get_the_post_thumbnail(get_the_ID(),'full')){ ?>
                        <div class="blog__thumb">
                            <a href="<?php echo esc_url(the_permalink()); ?>">
                                <?php echo get_the_post_thumbnail(get_the_ID(),'large'); ?>
                            </a>
                        </div>
                        <?php } ?>
                        <header class="blog__header">
                            <div class="meta">
                                <time datetime="<?php echo esc_attr(get_the_date()) ?>" class="meta__item meta__item_date"><?php echo esc_attr(get_the_date()) ?></time>
                                <a href="<?php echo esc_url(the_permalink()); ?>" class="meta__item meta__item_comments"><?php echo esc_attr(get_comments_number(get_the_ID())); ?></a>
                            </div>
                            <!-- end blog meta -->
        
                            <h1 class="blog__title font_one">
                                <a href="<?php esc_url(the_permalink()); ?>"><?php esc_attr(the_title()); ?></a>
                            </h1>
                        </header>
                        <!-- end blog header -->
                    </article>
                    <!-- end blog -->
                    <?php endwhile; wp_reset_postdata(); else: ?>
                        <?php get_template_part('partials/notfound')?>
                    <?php endif; ?>
        
                </div>
            </div>
        <?php } else if($settings['grid'] == 'prestigio'){
            wp_enqueue_script( 'ale-slider' );
        
            $recent_posts = new WP_Query( $args );
            ?>
        
            <div class="olins_prestigio_blog">
                <section class="blog  <?php echo esc_attr($posttype)."_slider" ?>">
                    <div class="center">
                        <h2><?php if($posttype == 'works'){ esc_html_e('GALLERY','ale'); } else { esc_html_e('THE BLOG','ale'); } ?><span class="prev"></span><span class="next"></span></h2>
        
                        <div class="blog-slider cf">
                            <ul class="slides">
        
                                <li>
                                    <?php
                                    $i = 1;
                                    if ($recent_posts->have_posts()) : while ($recent_posts->have_posts()) : $recent_posts->the_post();
        
                                        $categories = get_the_category(); ?>
        
                                        <div class="col-3">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php echo get_the_post_thumbnail(get_the_ID(),'large'); ?>
                                                <div class="hover">
                                                    <h3><?php esc_attr(the_title()); ?></h3>
                                                    <p><?php echo esc_attr(get_the_date()); ?>  •  <?php
                                                        if($posttype == 'works'){
                                                            $category = get_the_terms( get_the_ID(), 'work-category' );
                                                            if(!empty($category)){
                                                                foreach ( $category as $cat){
                                                                    echo esc_html($cat->name);
                                                                }
                                                            }
                                                        } else {
                                                            if (!empty($categories)) {
                                                                echo esc_html($categories[0]->name);
                                                            }
                                                        }
                                                        ?></p>
                                                </div>
                                            </a>
                                        </div>
        
                                    <?php if( ($i % 8 == 0 && $i != $count)) echo '</li><li>'; $i++; endwhile; wp_reset_postdata(); else: ?>
                                        <?php get_template_part('partials/notfound')?>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
        
        <?php } else {
            //Columns Settings
            $ale_blog_columns = ale_get_option('default_blog_columns');
            $ale_columns_class = '';
            if($ale_blog_columns){
                $ale_columns_class = 'ale_blog_columns_'.esc_attr($ale_blog_columns);
            }
            //Text Align Settings
            $ale_blog_text_align = ale_get_option('default_blog_text_align');
            $ale_text_align_class = '';
            if($ale_blog_text_align){
                $ale_text_align_class = 'ale_blog_text_align_'.esc_attr($ale_blog_text_align);
            }
            //Grid type
            $blog_grid_type = 'blog_grid grid';
            if(ale_get_option('blog_grid_layout') == 'vintage'){
                $blog_grid_type = 'blog_grid vintage-grid';
            } else if(ale_get_option('blog_grid_layout') == 'furniture'){
                $blog_grid_type = 'blog_grid furniture-grid';
            }
        
            $recent_posts = new WP_Query( $args ); ?>
        
            <div class="<?php echo esc_attr($blog_grid_type)." ".esc_attr($ale_columns_class)." ".esc_attr($ale_text_align_class); ?>">
                <div class="grid-sizer"></div>
                <div class="gutter-sizer"></div>
                <?php if ($recent_posts->have_posts()) : while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                    <?php  do_action('aletheme_specific_blog_grid');  ?>
                <?php endwhile; wp_reset_postdata(); else: ?>
                    <?php get_template_part('partials/notfound')?>
                <?php endif; ?>
            </div>
        
        <?php }


	}

}
