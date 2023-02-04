<?php
$args = array(
    'moreabout_title'   => '',
    'moreabout_rep'   => '',
);


$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

// echo '<pre>';
// print_r(vc_param_group_parse_atts($atts['moreabout_rep']));
// echo '</pre>';

wp_enqueue_style('moreabout', get_template_directory_uri() . '/vc_templates/css/moreabout.css');
?>

<section class="moreabout">
    <div class="container">
        <h2><?php echo $atts['moreabout_title']; ?></h2>

        <?php if (vc_param_group_parse_atts($atts['moreabout_rep'])) { ?>
            <div>
                <?php foreach (vc_param_group_parse_atts($atts['moreabout_rep']) as $item) { ?>
                    <p><?php echo $item['moreabout_text']; ?></p>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>

<!-- <section class="whositfor">
    <div class="container">
        <h2><?php echo $atts['whoitfor_title']; ?></h2>

        <?php if (vc_param_group_parse_atts($atts['whoitfor_rep'])) { ?>
            <div class="whositfor-flex">
                <?php echo wp_get_attachment_image($atts['whoitfor_left_img'], 'full'); ?>
                <?php foreach (vc_param_group_parse_atts($atts['whoitfor_rep']) as $item) { ?>
                    <div class="block">
                        <div class="img">
                            <?php echo wp_get_attachment_image($item['whoitfor_rep_img'], 'full'); ?>
                        </div>
                        <p><?php echo $item['whoitfor_img_title']; ?></p>
                    </div>
                <?php } ?>
                <?php echo wp_get_attachment_image($atts['whoitfor_right_img'], 'full'); ?>
            </div>
        <?php } ?>
    </div>
</section> -->