<?php
add_action('wp_ajax_nopriv_getpostfb', 'searchajax');
add_action('wp_ajax_getpostfb', 'searchajax');

function searchajax()
{
    if (!wp_verify_nonce($_POST['nonce'], 'getpostfbnonce')) {
        wp_die('Данные отправлены с левого адреса');
    }
    
    $eventID = $_POST['event'];
    $accesstoken = $_POST['token'];

    $ch = curl_init();
    // curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v15.0/me?fields=posts.limit(1)%7Bpermalink_url%2Cmessage%2Cfull_picture%2Cis_published%2Ccreated_time%2Cbackdated_time%2Ctimeline_visibility%2Cscheduled_publish_time%2Cupdated_time%7D&access_token=' . $accesstoken);
    curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v15.0/' . $eventID . '?fields=cover,name,start_time&access_token=' . $accesstoken);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    $result = json_encode($result);
    echo $result;
    die();
}
