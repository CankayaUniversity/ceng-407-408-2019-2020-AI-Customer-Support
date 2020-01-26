<?php
ini_set('display_errors', 1);
error_reporting(-1); 
$kime      = 'cpukarsilastir@gmail.com';
$konu      = 'konu';
$ileti     = 'Merhaba';
$başlıklar = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($kime, $konu, $ileti, $başlıklar);
?>