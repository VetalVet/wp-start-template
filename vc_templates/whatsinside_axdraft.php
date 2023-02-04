<?php
$args = array(
    'whatsinside_title'   => '',
    'whatsinside_color'   => '',
    'whatsinside_slider'      => '',
    'whatsinside_texts' => '',
);

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

wp_enqueue_style( 'swiper', get_template_directory_uri() . '/resources/assets/wpbakeryjs/swiper-bundle.min.css' );
wp_enqueue_style( 'whatsinside', get_template_directory_uri() . '/vc_templates/css/whatsinside.css' );
?>


<section class="whatsinside">
    <div class="container">
        <div class="left">
            <?php if (vc_param_group_parse_atts( $atts['whatsinside_slider'])) { ?>
                <div class="image-slider swiper">
                    <div class="image-slider__wrapper swiper-wrapper">
                        <?php foreach (vc_param_group_parse_atts( $atts['whatsinside_slider']) as $slide) { ?>
                            <div class="slide swiper-slide"><?php echo wp_get_attachment_image($slide['whatsinside_slider_img'], 'full'); ?></div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Добавляем если нам нужны стрелки управления -->
                <div class="swiper-button-prev">
                    <svg width="68" height="68" viewBox="0 0 68 68" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g filter="url(#filter0_d_1407_624)">
                            <circle cx="34" cy="32" r="18" transform="rotate(-180 34 32)" fill="white" />
                            <circle cx="34" cy="32" r="17.5" transform="rotate(-180 34 32)" stroke="#E4E8F3" />
                        </g>
                        <path d="M36.3528 38L37.7983 36.59L33.1029 32L37.7983 27.41L36.3528 26L30.2016 32L36.3528 38Z" fill="#253958" />
                        <defs>
                            <filter id="filter0_d_1407_624" x="0" y="0" width="68" height="68" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                <feOffset dy="2" />
                                <feGaussianBlur stdDeviation="8" />
                                <feColorMatrix type="matrix" values="0 0 0 0 0.286275 0 0 0 0 0.403922 0 0 0 0 0.678431 0 0 0 0.2 0" />
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1407_624" />
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1407_624" result="shape" />
                            </filter>
                        </defs>
                    </svg>
                </div>
                <div class="swiper-button-next">
                    <svg width="68" height="68" viewBox="0 0 68 68" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g filter="url(#filter0_d_1407_621)">
                            <circle cx="34" cy="32" r="18" fill="white" />
                            <circle cx="34" cy="32" r="17.5" stroke="#E4E8F3" />
                        </g>
                        <path d="M31.6472 26L30.2017 27.41L34.8971 32L30.2017 36.59L31.6472 38L37.7984 32L31.6472 26Z" fill="#253958" />
                        <defs>
                            <filter id="filter0_d_1407_621" x="0" y="0" width="68" height="68" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                <feOffset dy="2" />
                                <feGaussianBlur stdDeviation="8" />
                                <feColorMatrix type="matrix" values="0 0 0 0 0.286275 0 0 0 0 0.403922 0 0 0 0 0.678431 0 0 0 0.2 0" />
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1407_621" />
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1407_621" result="shape" />
                            </filter>
                        </defs>
                    </svg>
                </div>
                <div class="swiper-pagination"></div>
            <?php } ?>
        </div>
        <div class="right">
            <h2><?php echo $whatsinside_title; ?></h2>

            <?php if (vc_param_group_parse_atts( $atts['whatsinside_texts'] )) { ?>
                <?php foreach (vc_param_group_parse_atts( $atts['whatsinside_texts'] ) as $text) { ?>
                    <p><?php echo $text['whatsinside_text']; ?></p>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</section>

<?php  
    wp_enqueue_script( 'swiper', get_template_directory_uri() . '/resources/assets/wpbakeryjs/swiper-bundle.min2.js', array(), null, true );
    wp_enqueue_script( 'whatsinside', get_template_directory_uri() . '/vc_templates/js/whatsinside.js', array('swiper'), null, true );
?>