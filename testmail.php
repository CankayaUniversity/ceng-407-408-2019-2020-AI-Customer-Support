<?php
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");
$sender = 'someone@somedomain.tld';
$recipient = 'cpukarsilastir@gmail.com';

$subject = "php mail test";
$message = "php test message";
$headers = 'From:' . $sender;

if (mail($recipient, $subject, $message, $headers))
{
    echo "Message accepted";
}
else
{
    echo "Error: Message not accepted";
}
?>