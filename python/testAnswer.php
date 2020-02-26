<?php
$q_id = 3;
$question = urlencode("What is the difference between the City Navigato");

$ch = curl_init();
if($_SERVER['HTTP_HOST'] == 'localhost'){
    $url = "http://localhost:80/python/index.php?question=".$question."&questionID=".$q_id."";
} else {
    $url = "http://atakde.site:80/python/index.php?question=".$question."&questionID=".$q_id."";
}
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 1);
curl_exec($ch);
curl_close($ch);

?>