<?php
$args = array(
    'whoitfor_title'   => '',
    'whoitfor_left_img'   => '',
    'whoitfor_right_img'      => '',
    'whoitfor_rep' => '',
);


$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

wp_enqueue_style( 'whositfor', get_template_directory_uri() . '/vc_templates/css/whoitfor.css' );
?>

<section class="whositfor">
    <div class="container">
        <h2><?php echo $atts['whoitfor_title']; ?></h2>

        <?php if (vc_param_group_parse_atts( $atts['whoitfor_rep'])) { ?>
            <div class="whositfor-flex">
                <?php echo wp_get_attachment_image($atts['whoitfor_left_img'], 'full'); ?>
                <?php foreach (vc_param_group_parse_atts( $atts['whoitfor_rep']) as $item) { ?>
                    <div class="block">
                        <div class="img">
                            <?php echo wp_get_attachment_image( $item['whoitfor_rep_img'], 'full'); ?>
                        </div>
                        <p><?php echo $item['whoitfor_img_title']; ?></p>
                    </div>
                <?php } ?>
                <?php echo wp_get_attachment_image($atts['whoitfor_right_img'], 'full'); ?>
            </div>
        <?php } ?>
    </div>
</section>