<?php

// ajax поиск по сайту 
add_action('wp_ajax_nopriv_registeraction', 'registration');
add_action('wp_ajax_registeraction', 'registration');

function registration()
{
    if (!wp_verify_nonce($_POST['registration_nonce'], 'registration')) {
        wp_die('Данные отправлены с левого адреса');
    }

    // print_r($_POST);

    // require_once(ABSPATH . WPINC . '/registration.php');
    global $wpdb, $user_ID;
    //Проверяем, вошел ли уже пользователь в систему
    if ($user_ID) {

        //Залогиненного пользователя перенаправляем на главную страницу.
        header('Location:' . home_url());
    } else {
        $errors = array();

        if ($_POST) {

            //Убедитесь, что имя пользователя присутствует и еще не используется
            $username = $wpdb->escape($_REQUEST['first_name']);
            if (strpos($username, ' ') !== false) {
                $output = array(
                    'field'     => 'first_name',
                    'status'    => 'success',
                    'msg'       => 'error1'
                );
            }
            //если поле с именем пользователя пустое
            if (empty($username)) {
                $output = array(
                    'field'     => 'first_name',
                    'status'    => 'success',
                    'msg'       => 'error2'
                );
            } elseif (username_exists($username)) {
                //если такой пользователь уже зарегистрирован
                $output = array(
                    'field'     => 'first_name',
                    'status'    => 'success',
                    'msg'       => 'error3'
                );
            }

            // Проверяем, есть ли email и действителен ли он
            $email = $wpdb->escape($_REQUEST['user_email']);
            if (!is_email($email)) {
                $output = array(
                    'field'     => 'email',
                    'status'    => 'success',
                    'msg'       => 'wrong email'
                );
            } elseif (email_exists($email)) {
                $output = array(
                    'field'     => 'email',
                    'status'    => 'success',
                    'msg'       => 'email is registered'
                );
            }

            // Проверка пароля на валидность
            if (0 === preg_match("/.{6,}/", $_POST['password'])) {
                $output = array(
                    'field'     => 'password',
                    'status'    => 'error',
                    'msg'       => 'short password'
                );
            }

            // Проверить согласие с условиями обслуживания 
            if ($_POST['pol'] != "on") {
                $output = array(
                    'field'     => 'pol',
                    'status'    => 'error',
                    'msg'       => 'confirm policy'
                );
            }

            if ($_POST['data'] != "on") {
                $output = array(
                    'field'     => 'pol',
                    'status'    => 'error',
                    'msg'       => 'confirm policy2'
                );
            }
            // если ошибок нет
            if (0 === count($errors)) {

                $password = $_POST['password'];

                $output = array(
                    'user'     => 'registered',
                    'success'  => 1,
                    'username' => $username,
                    'password' => $password,
                    'email' => $email,

                );
                wp_create_user($username, $password, $email);
                wp_new_user_notification();
                // Здесь вы можете делать все, что угодно, например, отправлять электронное письмо пользователю и т. д. 

                // header('Location:' . get_bloginfo('url') . '/login/?success=1&u=' . $username);
            } else {
                $output = array(
                    'status'     => 'error',
                    'success'  => 1,
                );
            }
        }
    }


    wp_send_json($output);
}
