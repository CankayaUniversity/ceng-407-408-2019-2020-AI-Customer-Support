<?php 

$question = "What is the difference between the City Navigato";

if($_SERVER['HTTP_HOST'] == 'localhost'){
    $tmp = exec("C:/Users/mehat/AppData/Local/Programs/Python/Python38-32/python.exe test.py $question");
} else {
    $tmp = exec("/usr/bin/python3 test.py $var1 $var2 $var3");
}

echo $tmp;

?>