<?php

require '.././vendor/autoload.php';

$mail = new PHPMailer\PHPMailer\PHPMailer;

$mail->isSMTP();


//$mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;

$mail->Host = mailConfig::SMTP_HOST;

$mail->SMTPOptions = array(
'ssl' => array(
'verify_peer' => false,
'verify_peer_name' => false,
'allow_self_signed' => true
)
);

$mail->Port = mailConfig::SMTP_PORT;
$mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
$mail->SMTPAuth = true;
$mail->Username = mailConfig::SMTP_USER;
$mail->Password = mailConfig::SMTP_PASSWORD;

$mail->setFrom('from@example.com', 'First Last');
$mail->addReplyTo('replyto@example.com', 'First Last');
$mail->addAddress('cpukarsilastir@gmail.com', 'John Doe');
$mail->Subject = 'PHPMailer TESTTEST';
$mail->Body = 'Hello, this is my message.';

//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: '. $mail->ErrorInfo;
} else {
    echo 'Message sent!';
    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
}