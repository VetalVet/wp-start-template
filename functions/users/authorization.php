<?php
// Авторизация
add_action('wp_ajax_nopriv_authorization', 'authorization');
add_action('wp_ajax_authorization', 'authorization');

function authorization()
{
    if (!wp_verify_nonce($_POST['nonce'], 'authorization-nonce')) {
        wp_die('Данные отправлены с левого адреса');
    }

    // $login = $_POST['userEmail'];
    // $password = $_POST['userPassword'];

    // $auth = wp_authenticate($login, $password);

    $auth = array();
    $auth['user_login'] = $_POST['userEmail'];
    $auth['user_password'] = $_POST['userPassword'];

    $user = wp_signon($auth);

    if (!is_wp_error($user)) {
        // wp_redirect(get_the_permalink(423), 302);
        // header('Location: ' . get_the_permalink(423));
        
        $output = array(
            'status'     => 'success',
            'success'  => 1,
            'message' => pll__('Авторизованы'),
            'link'    => get_the_permalink(pll_get_post(423), 302),
        );
    } else {
        // echo $user->get_error_message();
        $output = array(
            'status'     => 'error',
            'success'  => 0,
            'message' => pll__('Неверный логин или пароль'),
        );
    }


    // if (!is_wp_error($auth)) {
    //     // пароль и логин введены верно
    //     wp_set_auth_cookie($user_obj->ID); // авторизация пользователя в системе
    //     wp_redirect(get_the_permalink(pll_get_post(423), 302));

    //     $output = array(
    //         'status'     => 'success',
    //         'success'  => 1,
    //         'message' => pll__('Авторизованы')
    //     );
    // } else {
    //     // неправильный логин или пароль
    //     // echo $auth->get_error_message(); // вывод ошибки авторизации
    //     $output = array(
    //         'status'     => 'error',
    //         'success'  => 0,
    //         'message' => $auth->get_error_message(),
    //     );
    // }


    // $output = array(
    //     'status'     => 'success',
    //     'success'  => 1,
    //     'message' => pll__('Данные успешно сохранены')
    // );
    wp_send_json($output);
    wp_die();
}
