<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ale_Elementor_Widget_Ale_Simple_Form extends \Elementor\Widget_Base {

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
					'field' => 'name_label',
					'type' => $this->get_title() .'<br />'. esc_html__( "Name Placeholder", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'email_label',
					'type' => $this->get_title() .'<br />'. esc_html__( "Email Placeholder", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'message_label',
					'type' => $this->get_title() .'<br />'. esc_html__( "Message Placeholder", "ale" ),
					'editor_type' => 'LINE'
			  ],
			  [
					'field' => 'form_submit',
					'type' => $this->get_title() .'<br />'.esc_html__( "Submit button text", "ale" ),
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
		return 'ale_simple_form';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return esc_html__( 'Simple Form', 'ale' );
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
			'name_label',
			[
				'label' => esc_html__( "Name Placeholder", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Your name ...',
			]
		);

        $this->add_control(
			'email_label',
			[
				'label' => esc_html__( "Email Placeholder", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Your e-mail address',
                'label_block' => true,
			]
		);

        $this->add_control(
			'message_label',
			[
				'label' => esc_html__( "Message Placeholder", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Write your message here',
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
                'label_block' => true,
			]
        );
        
        $this->add_control(
			'form_email_subject',
			[
				'label' =>  esc_html__( "Email Subject", "ale" ),
				'type' => \Elementor\Controls_Manager::TEXT,
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
			'subjectshow',
			[
				'label' =>  esc_html__( "Show Subject field?", "ale" ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'hide',
				'options' => [
                     'hide' => 'Hide', 
                     'show' => 'Show'
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

        <div class="olins_simple_form font_one">

            <a name="success"></a>

            <?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo esc_html_e("Thank you for your message!", "ale"); ?></p>
            <?php } ?>

            <?php if (isset($error) && isset($error['msg'])) {?>
            <p class="error"><?php echo esc_attr($error['msg']); ?></p>
            <?php } ?>

            <form method="post" action="<?php echo esc_url(get_the_permalink()); ?>" class="cf clearfix">
            <div class="module_line cf">
                <input name="contact[name]" type="text" class="item_field <?php if(ALETHEME_DESIGN_STYLE == 'rosi'){ echo 'font_two'; } else { echo 'font_one';} ?>" placeholder="<?php echo esc_attr($settings['name_label']); ?>" value="" required="required" id="contact-form-name" />
                <input name="contact[email]" type="email" class="item_field <?php if(ALETHEME_DESIGN_STYLE == 'rosi'){ echo 'font_two'; } else { echo 'font_one';} ?>" placeholder="<?php echo esc_attr($settings['email_label']); ?>" value="" required="required" id="contact-form-email" />
            </div>
            <?php if($settings['subjectshow'] == 'show'){ ?>
                <div class="module_line cf">
                    <input name="contact[subject]" type="text" class="item_field item_subject <?php if(ALETHEME_DESIGN_STYLE == 'rosi'){ echo 'font_two'; } else { echo 'font_one';} ?>" placeholder="<?php echo esc_attr($settings['form_email_subject']); ?>" value="" required="required" id="contact-form-subject" />
                </div>
            <?php } ?>
            <div class="module_line cf">
                <textarea name="contact[message]" class="item_field <?php if(ALETHEME_DESIGN_STYLE == 'rosi'){ echo 'font_two'; } else { echo 'font_one';} ?>" placeholder="<?php echo esc_attr($settings['message_label']); ?>" id="contact-form-message" required="required"></textarea>
            </div>
            <div class="module_line cr">
                <input type="submit" class="submit submit_button <?php if(ALETHEME_DESIGN_STYLE == 'rosi'){ echo 'font_two'; } else { echo 'font_one';} ?>" value="<?php echo esc_attr($settings['form_submit']); ?>"/>
            </div>
            <input name="contact[receive]" type="hidden" value="<?php echo esc_attr($settings['form_email_receive']); ?>" />
            <input name="contact[subject]" type="hidden" value="<?php echo esc_attr($settings['form_email_subject']); ?>" />
            <?php wp_nonce_field(); ?>

            </form>

        </div>

        <?php
	}

}
