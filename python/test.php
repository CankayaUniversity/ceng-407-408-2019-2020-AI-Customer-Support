<?php 

$question = "What is the difference between the City Navigato";

if($_SERVER['HTTP_HOST'] == 'localhost'){
    $tmp = exec("C:/Users/mehat/AppData/Local/Programs/Python/Python38-32/python.exe analize.py $question", $out);
} else if($_SERVER['HTTP_HOST'] == 'localhost:8080'){
    $tmp = exec("C:/Users/Arinc/AppData/Local/Programs/Python/Python37-32/python.exe analize.py $question", $out);
} else {
    $tmp = exec("/usr/bin/python3 analize.py $question");
}
echo $tmp;

?>