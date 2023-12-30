<?php
// ajax поиск по сайту 
add_action('wp_ajax_nopriv_calcform', 'calcform');
add_action('wp_ajax_calcform', 'calcform');

function calcform(){
    if (!wp_verify_nonce($_POST['nonce'], 'calc-nonce')) {
        wp_die('Данные отправлены с левого адреса');
    }


    header('Content-Type: application/json');
    if (empty($_POST)) {
        echo json_encode(['code' => 404]);
        wp_die();
    }


    $message = '';
    foreach($_POST as $key => $value){
        if($key == 'nonce' || $key == 'action' || !$value) continue;
        
        if($key == 'name'){
            $message .= pll__('Имя') . ': ' . sanitize_text_field($value) . "\n";
        } else if($key == 'email'){
            $message .= 'E-mail: ' . sanitize_text_field($value) . "\n";
        } else {
            $message .= str_replace('_', ' ', sanitize_text_field($key)) . ': ' . sanitize_text_field($value) . "\n";
        }
    }
    $post_id = wp_insert_post([
        'post_title' => pll__('Заявка из формы калькулятора'),
        'post_type' => 'form_requests',
        'post_status' => 'publish',
        'post_author' => 1
    ]);
    update_field('rent_fio', $_POST['name'], $post_id);
    update_field('rent_email', $_POST['email'], $post_id);
    update_field('calc_message', $message, $post_id);


    $headers = array('Content-Type: text/html; charset=UTF-8');
    // wp_mail(get_option('admin_email'), pll__('Заявка из формы калькулятора'), $message, $headers);
    mail(get_option('admin_email'), pll__('Заявка из формы калькулятора'), $message, $headers);


    echo json_encode(['code' => 200, 'msg' => 'success']);
    wp_die();
}