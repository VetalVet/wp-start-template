<?php
// Сохранение/изменение данных юзера в личном кабинете
add_action('wp_ajax_nopriv_update_user_data', 'update_user_data');
add_action('wp_ajax_update_user_data', 'update_user_data');

function update_user_data(){
    if (!wp_verify_nonce($_POST['nonce'], 'update-user-nonce')) {
        wp_die('Данные отправлены с левого адреса');
    }

    $userName = sanitize_text_field($_POST['userName']);
    $userPhone = sanitize_text_field($_POST['userPhone']);
    $userEmail = sanitize_email($_POST['userEmail']);
    $userCountry = sanitize_text_field($_POST['userCountry']);
    $userCompanyName = sanitize_text_field($_POST['userCompanyName']);
    $userField = sanitize_text_field($_POST['userField']);
    $userID = get_current_user_id();

    if ($userName && $userPhone && $userEmail && $userCountry && $userCompanyName && $userField && $userID) {
        update_field('user_fio', $userName, 'user_' . $userID);
        update_field('user_phone', $userPhone, 'user_' . $userID);
        update_field('user_email', $userEmail, 'user_' . $userID);
        update_field('user_country', $userCountry, 'user_' . $userID);
        update_field('user_company', $userCompanyName, 'user_' . $userID);
        update_field('user_sphere', $userField, 'user_' . $userID);

        $output = array(
            'status'     => 'success',
            'success'  => 1,
            'message' => pll__('Данные успешно сохранены')
        );
    } else {
        $output = array(
            'status'     => 'error',
            'success'  => 0,
            'message' => pll__('Произошла ошибка, попробуйте позже')
        );
    }

    wp_send_json($output);
    wp_die();
}
