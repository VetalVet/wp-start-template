<?php

class WhosItFor_Axdraft_Block extends WPBakeryShortCode
{

    function __construct()
    {
        add_action('init', array($this, 'create_shortcode'), 999);
        add_shortcode('whoitfor', array($this, 'render_shortcode'));
    }

    public function create_shortcode()
    {
        // Stop all if VC is not enabled
        if (!defined('WPB_VC_VERSION')) {
            return;
        }

        // Map blockquote with vc_map()
        vc_map(array(
            'name'          => 'Whos it for?',
            'base'          => 'whoitfor_axdraft',
            'description'      => '',
            'category'      => 'Axdraft custom blocks',
            'params' => array(
                array(
                    'type'          => 'textfield',
                    'heading'       => 'Block title',
                    'param_name'    => 'whoitfor_title',
                    'value'         => '',
                    'description'   => 'Add Block title',
                ),
                array(
                    "type" => "attach_image",
                    "heading" => "Left Image",
                    "param_name" => "whoitfor_left_img",
                    "value" => "",
                ),
                array(
                    "type" => "attach_image",
                    "heading" => "Right Image",
                    "param_name" => "whoitfor_right_img",
                    "value" => "",
                ),
                array(
                    'type' => 'param_group',
                    'heading'       => 'Photo and caption',
                    'param_name' => 'whoitfor_rep',
                    'params' => array(
                        array(
                            "type" => "attach_image",
                            "holder" => "img",
                            "class" => "",
                            "heading" => "Image",
                            "param_name" => "whoitfor_rep_img",
                            "value" => "",
                        ),
                        array(
                            'type'          => 'textfield',
                            'heading'       => 'Image caption',
                            'param_name'    => 'whoitfor_img_title',
                            'value'         => '',
                        ),
                    )
                )
            ),
        ));
    }

    public function render_shortcode($atts, $content, $tag)
    {
        $atts = (shortcode_atts(array(
            'whoitfor_title'   => '',
            'whoitfor_rep'      => '',
            'whoitfor_left_img' => '',
            'whoitfor_right_img' => '',
        ), $atts));

        // Content
        $content     = wpb_js_remove_wpautop($content, true);
        $title       = esc_html($atts['whoitfor_title']);
        $leftPhoto   = esc_html($atts['whoitfor_left_img']);
        $rightPhoto  = esc_html($atts['whoitfor_right_img']);
        $photos      = esc_html($atts['whoitfor_rep']);

    }
}

new WhosItFor_Axdraft_Block();

class WhatsInside_Axdraft_Block extends WPBakeryShortCode
{

    function __construct()
    {
        add_action('init', array($this, 'create_shortcode'), 999);
        add_shortcode('whatsinside', array($this, 'render_shortcode'));
    }

    public function create_shortcode()
    {
        // Stop all if VC is not enabled
        if (!defined('WPB_VC_VERSION')) {
            return;
        }

        // Map blockquote with vc_map()
        vc_map(array(
            'name'          => 'Whats Inside?',
            'base'          => 'whatsinside_axdraft',
            'description'      => '',
            'category'      => 'Axdraft custom blocks',
            'params' => array(
                array(
                    'type'          => 'textfield',
                    'heading'       => 'Block title',
                    'param_name'    => 'whatsinside_title',
                    'value'         => '',
                ),

                array(
                    'type'          => 'colorpicker',
                    'heading'       => 'Background color',
                    'param_name'    => 'whatsinside_color',
                    'value'         => '',
                ),

                array(
                    'type' => 'param_group',
                    'heading'       => 'Slider',
                    'param_name' => 'whatsinside_slider',
                    'params' => array(
                        array(
                            "type" => "attach_image",
                            "heading" => "Image",
                            "param_name" => "whatsinside_slider_img",
                            "value" => "",
                        ),
                    )
                ),

                array(
                    'type' => 'param_group',
                    'heading'       => 'Texts after title',
                    'param_name' => 'whatsinside_texts',
                    'params' => array(
                        array(
                            "type" => "textarea",
                            "heading" => "Text",
                            "param_name" => "whatsinside_text",
                            "value" => "",
                        ),
                    )
                )
            ),
        ));
    }

    public function render_shortcode($atts, $content, $tag)
    {

        $atts = (shortcode_atts(array(
            'whatsinside_title'   => '',
            'whatsinside_color'   => '',
            'whatsinside_slider'      => '',
            'whatsinside_texts' => '',
        ), $atts));

        //Content
        $content     = wpb_js_remove_wpautop($content, true);
        $title       = esc_html($atts['whatsinside_title']);
        $color       = esc_html($atts['whatsinside_color']);
        $slider      = esc_html($atts['whatsinside_slider']);
        $texts       = esc_html($atts['whatsinside_texts']);

    }
}

new WhatsInside_Axdraft_Block();

class FAQ_Axdraft_Block extends WPBakeryShortCode
{

    function __construct()
    {
        add_action('init', array($this, 'create_shortcode'), 999);
        add_shortcode('faq', array($this, 'render_shortcode'));
    }

    public function create_shortcode()
    {
        // Stop all if VC is not enabled
        if (!defined('WPB_VC_VERSION')) {
            return;
        }

        // Map blockquote with vc_map()
        vc_map(array(
            'name'          => 'FAQ',
            'base'          => 'faq_axdraft',
            'description'      => '',
            'category'      => 'Axdraft custom blocks',
            'params' => array(
                array(
                    'type'          => 'textfield',
                    'heading'       => 'Block title',
                    'param_name'    => 'faq_title',
                    'value'         => '',
                ),

                array(
                    'type'          => 'attach_image',
                    'heading'       => 'Image after title',
                    'param_name'    => 'faq_img',
                    'value'         => '',
                ),

                array(
                    'type' => 'param_group',
                    'heading'       => 'FAQ accordion',
                    'param_name' => 'faq_accordion',
                    'params' => array(
                        array(
                            "type" => "textfield",
                            "heading" => "Question",
                            "param_name" => "faq_question",
                            "value" => "",
                        ),
                        array(
                            "type" => "textarea",
                            "heading" => "Text",
                            "param_name" => "faq_answer",
                            "value" => "",
                        ),
                    )
                ),
            ),
        ));
    }

    public function render_shortcode($atts, $content, $tag)
    {
        $atts = (shortcode_atts(array(
            'faq_title'   => '',
            'faq_img'   => '',
            'faq_accordion'      => '',
        ), $atts));

        //Content
        $content     = wpb_js_remove_wpautop($content, true);
        $title       = esc_html($atts['faq_title']);
        $image       = esc_html($atts['faq_img']);
        $accordion   = esc_html($atts['faq_accordion']);
    }
}

new FAQ_Axdraft_Block();


class MoreAbout_Axdraft_Block extends WPBakeryShortCode
{

    function __construct()
    {
        add_action('init', array($this, 'create_shortcode'), 999);
        add_shortcode('moreabout', array($this, 'render_shortcode'));
    }

    public function create_shortcode()
    {
        if (!defined('WPB_VC_VERSION')) {
            return;
        }

        vc_map(array(
            'name'          => 'More About',
            'base'          => 'moreabout_axdraft',
            'description'      => '',
            'category'      => 'Axdraft custom blocks',
            'params' => array(
                array(
                    'type'          => 'textfield',
                    'heading'       => 'Block title',
                    'param_name'    => 'moreabout_title',
                    'value'         => '',
                    'description'   => 'Add Block title',
                ),
                array(
                    'type' => 'param_group',
                    'heading'       => 'Text items',
                    'param_name' => 'moreabout_rep',
                    'params' => array(
                        array(
                            'type'          => 'textarea',
                            'heading'       => 'Text',
                            'param_name'    => 'moreabout_text',
                            'value'         => '',
                        ),
                    )
                )
            ),
        ));
    }

    public function render_shortcode($atts, $content, $tag)
    {
        $atts = (shortcode_atts(array(
            'moreabout_title'   => '',
            'moreabout_rep'      => '',
        ), $atts));

        // Content
        $content     = wpb_js_remove_wpautop($content, true);
        $title       = esc_html($atts['moreabout_title']);
        $leftPhoto   = esc_html($atts['moreabout_rep']);

    }
}

new MoreAbout_Axdraft_Block();