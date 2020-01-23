<?php 

if(!isset($_GET['post'])) { 
   $sayfa = 'anasayfa';
} else {
   $sayfa = $_GET['post'];
}
 
switch($sayfa) {
case 'ati':
   echo "girdi - ati";
   break; 
case 'atakan':
   echo "girdi - atakan";
   break;
}

?>