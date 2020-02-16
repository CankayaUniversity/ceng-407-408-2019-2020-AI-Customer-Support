<?php
$getAction = $_POST["action"];

if(isset($getAction)){
    if($getAction == 'GeneralSettings') {
        print_r($_POST);
/*        $sql ="CREATE TABLE IF NOT EXISTS site_settings (
            id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            slogan varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            system_address varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            site_address varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            mail_address varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            );";
        $conn->exec($sql);
        echo "Site settings created successfully.</br> ";*/
    }
    if($getAction == 'ServerSettings') {
        print_r($_POST);
    }
    if($getAction == 'AdminSettings') {
        print_r($_POST);
    }
} else {
    echo "No action!";
}

?>

