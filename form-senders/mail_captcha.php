<?php

// Подробный гайд
// https://itchief.ru/php/add-recaptcha-to-form

// Введите свой секретный ключ
// www.google.com/recaptcha/admin - взять здесь
$secretKey = "6LdM0dchAAAAAGTUlMDsAEDNLmhv5eGHNro1Yx68";

// Ip-адрес, опционально
// $ip = $_SERVER['REMOTE_ADDR'];

// post request to server
$url =  'https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey .  '&response=' . $_POST['g-recaptcha-response'];
$response = file_get_contents($url);
$responseKeys = json_decode($response, true);

header('Content-type: application/json');

if ($responseKeys["success"]) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $text = $_POST['message'];

    $to = "vetalflame@gmail.com";
    $date = date("d.m.Y");
    $time = date("h:i");
    // $from = $email;
    $from = "sales@brebeneskul.com";
    $subject = "Request from site";


    $msg = "
	Name: $name 
    Email: $email 
    Message: $text";
    mail($to, $subject, $msg, "From: $from ");

    $output = array(
        'status'    => 'success',
        'msg'       => 'Thank you for your message! A Brebeneskul team member will get back to you shortly.',
    );
    echo json_encode($output);
} 
else {
    $output = array(
        'status'    => 'error',
        'msg'       => 'Server error, try send your message later',
    );
    echo json_encode($output);
}
