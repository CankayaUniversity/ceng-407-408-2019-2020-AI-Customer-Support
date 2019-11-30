<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Install Customer Support DB</title>
    </head>
    <body>
        <h1>Install Customer Support DB</h1>
        <form action="install.php" method="post">
            <label for="servername">servername</label>
            <input type="text" id="servername" name="servername" placeholder="localhost"><br>
            <label for="username">username</label>
            <input type="text" id="username" name="username" placeholder="root"><br>
            <label for="password">password</label>
            <input type="text" id="password" name="password" placeholder="password"><br>
            <label for="db_name">db_name</label>
            <input type="text" id="db_name" name="db_name" placeholder="set db name"><br>
            <input type="submit" name="register" value="Register"></button>
        </form>
    </body>
</html>

<?php
if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'localhost:8080' || $_SERVER['HTTP_HOST'] == 'localhost:80' || $_SERVER['HTTP_HOST'] == 'localhost:8085') {
    $environment = 'dev';
} else {
    $environment = 'live';
    //echo "Şuan live için açık değil.";
    //exit(0);
}
if (isset($_POST['register'])) {
    $servername = $_POST['servername'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $db_name = $_POST['db_name'];

    if($environment == "dev") {
        $db_name = 'customer_support';    
    }

    try {
        $conn = new PDO("mysql:host=$servername", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
        $conn->exec($sql);

        echo "DB created successfully. ";

        $sql = "use $db_name";
        $conn->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS users (
            user_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            firstname varchar(50) NOT NULL,
            surname varchar(50) NOT NULL,
            email varchar(50) NOT NULL,
            username varchar(50) NOT NULL,
            password_ varchar(50) NOT NULL,
            create_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            last_login datetime DEFAULT CURRENT_TIMESTAMP,
            is_verified int NOT NULL,
            is_admin int NOT NULL
            );";
        
        $conn->exec($sql);

        echo "Users table created successfully. ";

        $sql = "CREATE TABLE IF NOT EXISTS questions (
            q_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            q_title varchar(100) NOT NULL,
            q_description varchar(1000) NOT NULL,
            q_author int NOT NULL,
            q_like int NOT NULL DEFAULT '0',
            q_dislike int NOT NULL  DEFAULT '0',
            q_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (q_author) REFERENCES Users(user_id)
            );";

        echo "Questions table created successfully. ";

        $conn->exec($sql);
        
        $sql= "INSERT INTO users(firstname,surname,email,username,password_,is_verified,is_admin) 
        VALUES ('Arınç Alp','Eren','arinc@arinc.com','arinc','arinc',0,0),
        ('Atakan','Demircioğlu','atakan@atakan.com','atakan','atakan',0,0),
        ('Alperen','Sarınay','alperen@alperen.com','alperen','alperen',0,0),
        ('Cavid','Aydın','cavid@cavid.com','cavid','cavid',0,0),
        ('a','a','a@a.com','a','a',0,0),
        ('b','b','b@b.com','b','b',1,0),
        ('c','c','c@c.com','c','c',0,1);";
        $conn->exec($sql);

        $sql= "INSERT INTO questions(q_title, q_description, q_author) VALUES
        ('Sample Question Title 1 ', 'Sample Question Description 1 ', 1),
        ('Sample Question Title 2 ', 'Sample Question Description 2 ', 2),
        ('Sample Question Title 3 ', 'Sample Question Description 3 ', 3);";
        $conn->exec($sql);
        
        echo "Insertions done successfully. ";

        echo "Everything is okey :)";

    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
}
