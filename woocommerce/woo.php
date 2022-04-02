<?php
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    //Интеграция WooCommerce Шаблона
    add_filter( 'woocommerce_add_to_cart_fragments', 'wayup_header_add_to_cart_fragment' );
    function wayup_header_add_to_cart_fragment( $fragments ) {
        global $woocommerce;

        ob_start();

        //echo '<a href="' . esc_url(wc_get_cart_url()) . '" title="' . esc_html__( 'Cart','olins' ) . '" class="cart_link ale_cart_link_location"><span>'.esc_attr(WC()->cart->get_cart_contents_count()).'</span></a>';

        echo '<a href="'.esc_url(wc_get_cart_url()).'" class="heading__bag"><svg width="17" height="20"><use xlink:href="#bag"/></svg><span class="count">'. esc_attr(WC()->cart->get_cart_contents_count()).'</span></a>';

        $fragments['a.heading__bag'] = ob_get_clean();
        return $fragments;
    }



    // Здесь писать свои функции вывода вёрстки для WooCommerce хуков
    


    // Удаление/Подключение/Переподключение хуков


    
}