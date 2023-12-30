<?php
add_action('wp_ajax_newsletter', 'ajaxSubscribeNewsletter');
add_action('wp_ajax_nopriv_newsletter', 'ajaxSubscribeNewsletter');

function ajaxSubscribeNewsletter()
{
    check_ajax_referer('newsletternonce', 'nonce');

    if (!empty($_POST['ne'])) :
        if (filter_var($_POST['ne'], FILTER_VALIDATE_EMAIL)) :
            global $wpdb;

            //check if the email is already in the database
            $exists = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT email FROM " . $wpdb->prefix . "newsletter
                    WHERE email = %s",
                    $_POST['ne']
                )
            );

            if (!$exists) {
                NewsletterSubscription::instance()->subscribe();
                $output = array(
                    'status'    => 'success',
                    'msg'       => __( 'Thank you for your Email. Please check your inbox to confirm your subscription.', 'theme_text_domain' )
                );
            } else {
                //email is already in the database
                $output = array(
                    'status'    => 'error',
                    'msg'       => __('Your Email is already in our system. Please check your inbox, to confirm your subscription.', 'theme_text_domain')
                );
            }

        else :
            $output = array(
                'status'    => 'error',
                'msg'       => __('The Email address is invalid.', 'theme_text_domain')
            );
        endif;
    else :
        $output = array(
            'status'    => 'error',
            'msg'       => __('An Error occurred. Please try again later.', 'theme_text_domain')
        );
    endif;
    wp_send_json($output);
}