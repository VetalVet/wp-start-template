<?php
    $name = $_POST['name'];
    $surname = $_POST['surname'];
	$phone = $_POST['phone'];
    $email = $_POST['email'];
    $text = $_POST['text'];

	$to = "mail@gmail.com"; 
	$date = date ("d.m.Y"); 
	$time = date ("h:i");
	$from = $email;
	$subject = "Заявка c сайта";

	
	$msg="
    Имя: $name /n
    Фамилия: $surname /n
    Телефон: $phone /n
    Почта: $email /n
    Текст: $text"; 	
	mail($to, $subject, $msg, "From: $from ");

    // function send_message_mailer($mails, $msg, $thm) {
    //     $mails = explode(', ', $mails);
    
    //     require "phpmailer/PHPMailerAutoload.php";
    
    //     $mail = new PHPMailer();
    //     //Tell PHPMailer to use SMTP
    //     $mail->isSMTP();
    //     //Enable SMTP debugging
    //     // 0 = off (for production use)
    //     // 1 = client messages
    //     // 2 = client and server messages
    //     $mail->SMTPDebug = 0;
    //     //Ask for HTML-friendly debug output
    //     $mail->Debugoutput = 'html';
    //     //Set the hostname of the mail server
    //     $mail->Host = 'smtp.office365.com';
    //     //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    //     $mail->Port = 587;
    //     //Set the encryption system to use - ssl (deprecated) or tls
    //     $mail->SMTPAutoTLS = true;
    //     $mail->SMTPSecure = 'tls';
    //     //Whether to use SMTP authentication
    //     $mail->SMTPAuth = true;
    //     // $mail->SMTPAuth = false;
    //     //Username to use for SMTP authentication - use full email address for gmail
    //     $mail->Username = "news@iitd.io";
    //     //Password to use for SMTP authentication
    //     $mail->Password = "Cah16230";
    //     //Set who the message is to be sent from
    //     $mail->setFrom('news@iitd.io', 'iITD');
    //     //Set an alternative reply-to address
    //     //$mail->addReplyTo('brazer@gmail.com', 'Evoting System');
    //     //Set who the message is to be sent to
    //     foreach ($mails as $mail_t) {
    //         $mail->addAddress($mail_t);	
    //     }
    //     $mail->CharSet = 'UTF-8';
    
    //     //Set the subject line
    //     $mail->Subject = $thm;
    //     //Read an HTML message body from an external file, convert referenced images to embedded,
    //     //convert HTML into a basic plain-text alternative body
    //     $mail->msgHTML($msg);
    //     //Replace the plain text body with one created manually
    //     $mail->AltBody = $msg;
    //     //Attach an image file
    //     // $mail->addAttachment('images/phpmailer_mini.gif');
    
    //     // send the message, check for errors
    //     return $mail->send();
    // }
?>

<p>Привет, форма отправлена</p>

