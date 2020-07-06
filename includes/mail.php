<?php

include_once '../includes/functions.php';
include_once '../classes/_database.php';
include_once "../libraries/phpmailer/vendor/phpmailer/phpmailer/PHPMailerAutoload.php";

if (isset($_POST['mail'])) {
    $to = $_POST['to'];
    $name = $_POST['name'];
    $do_not_send = false;
    switch ($_POST["subject"]) {
        case "activation_key":
            $subject = "Activation Link";
            $link = "{$_SERVER['HTTP_HOST']}/includes/activation.php?activation_key={$_POST['activation_key']}&email={$to}";
            $body = "Welcome to " . APP_NAME . ". Click <a href='{$link}'>here</a> to activate the account.";
            break;
        default :
            $do_not_send = true;
            break;
    }

    if (!$do_not_send) {
        $sent = sendMail($to, $name, $subject, $body);
        if ($sent) {
            $message = setMessage("Welcome to " . APP_NAME . ". Mail sent for activation");
        } else {
            $message = setMessage("Registered. But problem in sending activation mail", "danger");
        }
    } else {
        $message = setMessage("Invalid Operation", "danger");
    }
}

function sendMail($to, $name, $subject, $body) {
    $mail = new PHPMailer;

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.prakarsh.in';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'progranz@prakarsh.in';                 // SMTP username
    $mail->Password = 'ro49w4Q!';                           // SMTP password
    $mail->Port = 25;                                    // TCP port to connect to

    $mail->setFrom('progranz@prakarsh.in', APP_NAME . ' Admin');
    $mail->addAddress($to, $name);     // Add a recipient
    $mail->addReplyTo('progranz@prakarsh.in', APP_NAME . ' Admin');
    $mail->addCC('progranz@prakarsh.in');
    $mail->addBCC('progranz@prakarsh.in');

    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body = $body;

    if (!$mail->send()) {
        return false; //$message = setMessage("Message could not be sent. Mailer Error: " . $mail->ErrorInfo, "danger");
    } else {
        return true; //$message = setMessage("Mail successfully sent");
    }
}
