<?php

// define( 'THEME_NAME', get_option('stylesheet') );

add_action('wp_ajax_uaknewsletter', 'ajaxSubscribeNewsletter');
add_action('wp_ajax_nopriv_uaknewsletter', 'ajaxSubscribeNewsletter');

function ajaxSubscribeNewsletter(){
    check_ajax_referer( 'uaknewsletternonce', 'nonce' );
    
    $data = urldecode( $_POST['data'] );
    if ( !empty( $data ) ) :
        $data_array = explode( "&", $data );
        $fields = [];
        foreach ( $data_array as $array ) :
            $array = explode( "=", $array );
            $fields[ $array[0] ] = $array[1];
        endforeach;
    endif;

    if ( !empty( $fields ) ) :
         if ( filter_var( $fields['ne'], FILTER_VALIDATE_EMAIL ) ) :
            global $wpdb;

             //check if the email is already in the database
             $exists = $wpdb->get_var(
                 $wpdb->prepare(
                     "SELECT email FROM " . $wpdb->prefix . "newsletter
                    WHERE email = %s",
                     $fields['ne']
                 )
             );

             if ( ! $exists ) {
                 NewsletterSubscription::instance()->subscribe();
                 $output = array(
                     'status'    => 'success',
                    //  'msg'       => __( 'Thank you for your Email. Please check your inbox to confirm your subscription.', 'theme_text_domain' )
                 );
             } else {
                 //email is already in the database
                 $output = array(
                     'status'    => 'error',
                     'msg'       => __( 'Your Email is already in our system. Please check your inbox, to confirm your subscription.', 'theme_text_domain' )
                 );
             }

         else :
             $output = array(
                 'status'    => 'error',
                 'msg'       => __( 'The Email address is invalid.', 'theme_text_domain' )
             );
         endif;
    else :
        $output = array(
            'status'    => 'error',
            'msg'       => __( 'An Error occurred. Please try again later.', 'theme_text_domain' )
        );
    endif;
    wp_send_json( $output );
}
