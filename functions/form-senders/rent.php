<?php
// ajax поиск по сайту 
add_action('wp_ajax_nopriv_rentform', 'calculateRent');
add_action('wp_ajax_rentform', 'calculateRent');

function calculateRent(){
    if (!wp_verify_nonce($_POST['nonce'], 'rent-nonce')) {
        wp_die('Данные отправлены с левого адреса');
    }
    header('Content-Type: application/json');
    
    if (empty($_POST)) {
        echo json_encode(['code' => 404]);
        wp_die();
    }

    $post_id = wp_insert_post([
        'post_title' => pll__('Заявка на рассчёт стоимости аренды чиллера'),
        'post_type' => 'form_requests',
        'post_status' => 'publish',
        'post_author' => 1
    ]);

    update_field('rent_fio', $_POST['name'], $post_id);
    update_field('rent_email', $_POST['email'], $post_id);
    update_field('rent_sphere', $_POST['sphere'], $post_id);
    update_field('rent_chillers', $_POST['chillers'], $post_id);
    update_field('rent_days', $_POST['rentalPeriod'], $post_id);

    // var_dump($_POST);
    
    $message = pll__('Имя') . ": " . $_POST['name'] . "\n" .
    "E-Mail" . ": " . $_POST['email'] . "\n" .
    pll__('Сфера деятельности') . ": " . $_POST['sphere'] ."\n".
    pll__('Чиллеры') . ": " . $_POST['chillers'] ."\n".
    pll__('Кол-во дней аренды') . ": " . $_POST['rentalPeriod'] ."\n";


    $headers = array('Content-Type: text/html; charset=UTF-8');
    // wp_mail(get_option('admin_email'), pll__('Заявка на рассчёт стоимости аренды чиллера'), $message, $headers);
    mail(get_option('admin_email'), pll__('Заявка на рассчёт стоимости аренды чиллера'), $message, $headers);


    echo json_encode(['code' => 200, 'msg' => 'success']);
    wp_die();
}