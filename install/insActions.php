<?php
$getAction = $_POST["action"];

if(isset($getAction)){
    if($getAction == 'ServerSettings') {
        $Servername = $_POST["Servername"];
        $Username = $_POST["Username"];
        $Password = $_POST["Password"];
        $DB_Name = $_POST["DB_Name"];

        $conn = new PDO("mysql:host=$Servername", $Username, $Password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DROP DATABASE IF EXISTS $DB_Name";
        $conn->exec($sql);

        $sql = "CREATE DATABASE IF NOT EXISTS $DB_Name";
        $conn->exec($sql);

        echo "DB created successfully.</br> ";

        $sql = "use $DB_Name";
        $conn->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS users (
            user_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            firstname varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
            surname varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            email varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            username varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            password_ varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            create_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            last_login datetime DEFAULT CURRENT_TIMESTAMP,
            ip_address nvarchar(50) DEFAULT 'UNKNOWN',
            is_verified int NOT NULL,
            is_admin int NOT NULL
            );";
        
        $conn->exec($sql);

        echo "Users table created successfully.</br> ";

        $sql = "CREATE TABLE IF NOT EXISTS questions (
            q_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            q_title varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            q_description varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            q_tags varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            title_meta varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            description_meta varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            keywords_meta varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            slug varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            category int NOT NULL DEFAULT '1',
            q_author int NOT NULL,
            q_like int NOT NULL DEFAULT '0',
            q_dislike int NOT NULL  DEFAULT '0',
            q_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (q_author) REFERENCES users(user_id)
            );";

        $conn->exec($sql);

        echo "Questions table created successfully.</br> ";

        $sql = "CREATE TABLE IF NOT EXISTS comments (
            c_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            c_description varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            c_author int NOT NULL,
            c_post_id int NOT NULL,
            c_like int NOT NULL DEFAULT '0',
            c_dislike int NOT NULL  DEFAULT '0',
            c_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (c_author) REFERENCES users(user_id),
            FOREIGN KEY (c_post_id) REFERENCES questions(q_id)
            );";

        $conn->exec($sql);

        echo "Comments table created successfully.</br> ";
        
        $sql = "CREATE TABLE IF NOT EXISTS notifications (
            n_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            n_description varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            n_author int NOT NULL,
            n_post_id int NOT NULL,
            n_notified_id int NOT NULL,
            n_isChecked int NOT NULL DEFAULT '0',
            n_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (n_author) REFERENCES users(user_id),
            FOREIGN KEY (n_post_id) REFERENCES questions(q_id)
            );";

        $conn->exec($sql);

        echo "Notifications table created successfully.</br> ";

        $sql = "CREATE TABLE IF NOT EXISTS categories (
            cat_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            cat_name varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            cat_description varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            cat_keywords varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            cat_slug varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            cat_totalquestion int NOT NULL DEFAULT '0'
            );";

        $conn->exec($sql);

        echo "Categories table created successfully.</br> ";

        $sql ="CREATE TABLE IF NOT EXISTS like_data (
            id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            q_id int NOT NULL,
            user_id int NOT NULL,
            status int NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(user_id),
            FOREIGN KEY (q_id) REFERENCES questions(q_id)
            );";

        $conn->exec($sql);
        echo "Like Data table created successfully.</br> ";

        $sql= "INSERT INTO users(firstname,surname,email,username,password_,is_verified,is_admin) 
        VALUES ('Arınç Alp','Eren','arinc@arinc.com','arinc','$2y$04$39Qbmj9YV04JXKBzWloixu4FIU37OwD3w7EAwICxNr6EZLMK6Wdky',0,0),
        ('Atakan','Demircioğlu','atakan@atakan.com','atakan','$2y$04$39Qbmj9YV04JXKBzWloixu4FIU37OwD3w7EAwICxNr6EZLMK6Wdky',0,0),
        ('Alperen','Sarınay','alperen@alperen.com','alperen','$2y$04$39Qbmj9YV04JXKBzWloixu4FIU37OwD3w7EAwICxNr6EZLMK6Wdky',0,0),
        ('Cavid','Aydın','cavid@cavid.com','cavid','cavid',0,0),
        ('a','a','a@a.com','a','$2y$04$39Qbmj9YV04JXKBzWloixu4FIU37OwD3w7EAwICxNr6EZLMK6Wdky',0,0),
        ('b','b','b@b.com','b','$2y$04$39Qbmj9YV04JXKBzWloixu4FIU37OwD3w7EAwICxNr6EZLMK6Wdky',1,0),
        ('c','c','c@c.com','c','$2y$04$39Qbmj9YV04JXKBzWloixu4FIU37OwD3w7EAwICxNr6EZLMK6Wdky',0,1);";
        $conn->exec($sql);

        $sql= "INSERT INTO questions(q_title, q_description, q_tags, q_author, title_meta, description_meta, keywords_meta, slug) VALUES
        ('Sample Question Title 1 ', 'Sample Question Description 1 ', 'help', 1, 'Sample Question Title 1', 'Sample Question Description 1', 'sample,question,description,1', 'sample-question-1'),
        ('Sample Question Title 2 ', 'Sample Question Description 2 ', 'help', 2, 'Sample Question Title 2', 'Sample Question Description 2', 'sample,question,description,2', 'sample-question-2'),
        ('Sample Question Title 3 ', 'Sample Question Description 3 ', 'help', 3, 'Sample Question Title 3', 'Sample Question Description 3', 'sample,question,description,3', 'sample-question-3');";
        $conn->exec($sql);
        
        $sql="INSERT INTO comments (c_description,c_author,c_post_id) VALUES
        ('Sample Comment Description 1 ', 1, 1),
        ('Sample Comment Description 2 ', 2, 1),
        ('Sample Comment Description 3 ', 3, 2),
        ('Sample Comment Description 4 ', 4, 2);";
        $conn->exec($sql);

        $sql="INSERT INTO notifications (n_description,n_author,n_post_id,n_notified_id) VALUES
        ('Sample Notification Description 1 ', 1, 1, 2),
        ('Sample Notification Description 2 ', 2, 1, 2),
        ('Sample Notification Description 3 ', 3, 2, 1),
        ('Sample Notification Description 4 ', 4, 2, 1);";
        $conn->exec($sql);

        $sql="INSERT INTO categories (cat_name,cat_description,cat_keywords,cat_slug) VALUES
        ('Commerce', 'Support for your products', 'Commerce','commerce'),
        ('Profile', 'Profile Support', 'Profile','profile'),
        ('Technical Issues', 'Technical Support', 'Technical,Issues','technical-issues'),
        ('Account', 'Private Informations', 'Account','account');";
        $conn->exec($sql);

        echo "Insertions done successfully.</br>";
        echo "Everything is okey :)<br>";
    }
    if($getAction == 'GeneralSettings') {
        $siteTitle = $_POST["siteTitle"];
        $siteSlogan = $_POST["siteSlogan"];
        $systemAddress = $_POST["systemAddress"];
        $siteAddress = $_POST["siteAddress"];
        $siteEmail = $_POST["siteEmail"];
        $Servername = $_POST["Servername"];
        $Username = $_POST["Username"];
        $Password = $_POST["Password"];
        $DB_Name = $_POST["DB_Name"];

        $conn = new PDO("mysql:host=$Servername", $Username, $Password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "use $DB_Name";
        $conn->exec($sql);

        $sql ="CREATE TABLE IF NOT EXISTS site_settings (
            id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            slogan varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            system_address varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            site_address varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            mail_address varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
            );";
        $conn->exec($sql);

        $sql= "INSERT INTO site_settings(slogan, system_address, site_address, mail_address) VALUES
        ('$siteSlogan','$systemAddress','$siteAddress','$siteEmail')";
        $conn->exec($sql);

        echo "Site settings created and registered successfully.</br> ";
    }
    if($getAction == 'AdminSettings') {
        $Servername = $_POST["Servername"];
        $Username = $_POST["Username"];
        $Password = $_POST["Password"];
        $DB_Name = $_POST["DB_Name"];
        $AdminUsername = $_POST["AdminUsername"];
        $AdminPassword = $_POST["AdminPassword"];
        $AdminFirstName = $_POST["AdminFirstName"];
        $AdminSurname = $_POST["AdminSurname"];
        $AdminEmail = $_POST["AdminEmail"];
        $options = array("cost"=>4);
        $hashPassword = password_hash($AdminPassword,PASSWORD_BCRYPT,$options);

        $conn = new PDO("mysql:host=$Servername", $Username, $Password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "use $DB_Name";
        $conn->exec($sql);   

        $sql= "INSERT INTO users(firstname,surname,email,username,password_,is_verified,is_admin) 
        VALUES ('$AdminFirstName','$AdminSurname','$AdminEmail','$AdminUsername','$hashPassword',1,1)";
        $conn->exec($sql); 
    }
} else {
    echo "No action!";
}

?>

