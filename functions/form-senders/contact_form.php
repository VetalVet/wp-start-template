<?php
// ajax поиск по сайту 
add_action('wp_ajax_nopriv_contact_form', 'sendRequest');
add_action('wp_ajax_contact_form', 'sendRequest');

function sendRequest(){
    if (!wp_verify_nonce($_POST['nonce'], 'contact-nonce')) {
        wp_die('Данные отправлены с левого адреса');
    }
    header('Content-Type: application/json');
    
    if (empty($_POST)) {
        echo json_encode(['code' => 404]);
        wp_die();
    }

    $post_id = wp_insert_post([
        'post_title' => pll__('Заявка из формы в попапе "Связаться с нами"'),
        'post_type' => 'form_requests',
        'post_status' => 'publish',
        'post_author' => 1
    ]);

    update_field('rent_fio', $_POST['userName'], $post_id);
    update_field('rent_phone', $_POST['userNumber'], $post_id);

    // var_dump($_POST);
    
    $message = pll__('Имя') . ": " . $_POST['userName'] . "\n" .
    pll__('Номер телефона') . ": " . $_POST['userNumber'] . "\n";


    $headers = array('Content-Type: text/html; charset=UTF-8');
    // wp_mail(get_option('admin_email'), pll__('Заявка на рассчёт стоимости аренды чиллера'), $message, $headers);
    mail(get_option('admin_email'), pll__('Заявка из формы в попапе "Связаться с нами"'), $message, $headers);


    echo json_encode(['code' => 200, 'msg' => 'success']);
    wp_die();
}