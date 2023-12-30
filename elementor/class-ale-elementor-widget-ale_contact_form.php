<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Contact_Form extends \Elementor\Widget_Base {

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
					'field' => 'form_title',
					'type' => $this->get_title() .'<br />'. esc_html__( 'Form Heading Title', 'ale' ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'form_name',
					'type' => $this->get_title() .'<br />'. esc_html__( "Name Field Placeholder", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'form_email',
					'type' => $this->get_title() .'<br />'. esc_html__( "Email Field Placeholder", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'form_message',
					'type' => $this->get_title() .'<br />'. esc_html__( "Message Field Placeholder", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'form_submit',
					'type' => $this->get_title() .'<br />'.  esc_html__( "Submit button text", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'form_email_receive',
					'type' => $this->get_title() .'<br />'.  esc_html__( "Receive to", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'form_email_subject',
					'type' => $this->get_title() .'<br />'.  esc_html__( "Email Subject", "ale" ),
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
		return 'ale_contact_form';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Contact Form', 'ale' );
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
			'form_title',
			[
				'label' => esc_html__( 'Form Heading Title', 'ale' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'ask us smth...', 'ale' ),
			]
		);

        $this->add_control(
			'form_name',
			[
				'label' => esc_html__( "Name Field Placeholder", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( "Name", "ale" ),
                'label_block' => true,
			]
		);

        $this->add_control(
			'form_email',
			[
				'label' => esc_html__( "Email Field Placeholder", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( "Email", "ale" ),
                'label_block' => true,
			]
		);

        $this->add_control(
			'form_message',
			[
				'label' => esc_html__( "Message Field Placeholder", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( "Message", "ale" ),
                'label_block' => true,
			]
		);

        $this->add_control(
			'form_submit',
			[
				'label' => esc_html__( "Submit button text", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( "Send", "ale" ),
                'label_block' => true,
			]
		);

        $this->add_control(
			'form_email_receive',
			[
				'label' => esc_html__( "Receive to", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'email@wordpress.org',
                'label_block' => true,
			]
		);

        $this->add_control(
			'form_email_subject',
			[
				'label' => esc_html__( "Email Subject", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
                'label_block' => true,
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
			'form_bg',
			[
				'label' => esc_html__( "Background Image", "ale" ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
        );

        $this->add_control(
			'form_mask_color',
			[
				'label' => esc_html__( "Mask Color", "ale" ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'alpha' => true,
				'selectors' => [
					'{{WRAPPER}} .olins_contact_form_shortcode .form_container' => 'color: {{VALUE}}',
				],
			]
        );
        
        $this->add_control(
			'form_align',
			[
				'label' => esc_html__( "Content Align", "ale" ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
                     'left' => 'Left Align', 
                     'right' => 'Right Align', 
                     'center' => 'Center Align'
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

		$image_src = $settings['form_bg']['url'];

		?>

        <div class="olins_contact_form_shortcode" style="background-image: url(<?php echo esc_url($image_src); ?>);">
            <div class="form_container" style="background-color: <?php echo esc_attr($settings['form_mask_color']); ?>">
                <div class="the_form text_align_<?php echo esc_attr($settings['form_align']); ?>">


                    <?php if($settings['form_title']){?>
                        <h3><?php echo esc_attr($settings['form_title']); ?></h3>
                    <?php } ?>

                    <a name="success"></a>

                    <?php if (isset($_GET['success'])) { ?>
                        <p class="success"><?php echo esc_html_e("Thank you for your message!", "ale"); ?></p>
                    <?php } ?>

                    <?php if (isset($error) && isset($error['msg'])) {?>
                        <p class="error"><?php echo esc_attr($error['msg']); ?></p>
                    <?php } ?>

                    <form method="post" action="<?php echo esc_url(get_the_permalink()); ?>" class="cf clearfix">

                        <input name="contact[name]" type="text" class="item_field" placeholder="<?php echo esc_attr($settings['form_name']); ?>" value="" required="required" id="contact-form-name" />
                        <input name="contact[email]" type="email" class="item_field" placeholder="<?php echo esc_attr($settings['form_email']); ?>" value="" required="required" id="contact-form-email" />
                        <textarea name="contact[message]" class="item_field" placeholder="<?php echo esc_attr($settings['form_message']); ?>" id="contact-form-message" required="required"></textarea>
                        <input type="submit" class="submit submit_button" value="<?php echo esc_attr($settings['form_submit']); ?>"/>
                        <input name="contact[receive]" type="hidden" value="<?php echo esc_attr($settings['form_email_receive']); ?>" />
                        <input name="contact[subject]" type="hidden" value="<?php echo esc_attr($settings['form_email_subject']); ?>" />
                        <?php wp_nonce_field(); ?>

                    </form>

                </div>
            </div>
        </div>

        <?php

	}

}
