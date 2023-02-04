<?php
$args = array(
    'moreabout_title'   => '',
    'moreabout_rep'   => '',
);

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

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