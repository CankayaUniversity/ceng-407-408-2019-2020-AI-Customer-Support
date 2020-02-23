<?php 
$var1 = "1";
$var2 = "6";
$var3 = "2";
$tmp = exec("C:/Users/mehat/AppData/Local/Programs/Python/Python38-32/python.exe test.py $var1 $var2 $var3");
if($_SERVER['HTTP_HOST'] == 'localhost'){
    $tmp = exec("C:/Users/mehat/AppData/Local/Programs/Python/Python38-32/python.exe test.py $var1 $var2 $var3");
} else {
    $tmp = exec("/usr/bin/python3 test.py $var1 $var2 $var3");
}
echo $tmp;

?>