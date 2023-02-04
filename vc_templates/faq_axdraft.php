<?php
$args = array(
    'faq_title'   => '',
    'faq_img'   => '',
    'faq_accordion'      => '',
);

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

wp_enqueue_style('faq', get_template_directory_uri() . '/vc_templates/css/faq.css');
?>

<section class="faqcustom">
    <div class="container">
        <div class="right">
            <h2><?php echo $atts['faq_title']; ?></h2>
            <div>
                <?php echo wp_get_attachment_image($atts['faq_img'], 'full'); ?>
            </div>
        </div>
        <?php if (vc_param_group_parse_atts( $atts['faq_accordion'])) { ?>
            <div data-spollers data-one-spoller class="left">
                <?php foreach(vc_param_group_parse_atts( $atts['faq_accordion']) as $item){ ?>
                    <div class="block__item">
                        <button type="button" data-spoller class="block__title"><span><?php echo $item['faq_question']; ?></span></button>
                        <div class="block__text"><?php echo $item['faq_answer']; ?></div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>

<?php
    wp_enqueue_script('faq', get_template_directory_uri() . '/vc_templates/js/faq.js');
?>