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
if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'localhost:8080' || $_SERVER['HTTP_HOST'] == 'localhost:80') {
    $environment = 'dev';
} else {
    $environment = 'live';
    echo "Şuan live için açık değil.";
    exit(0);
}
if (isset($_POST['register'])) {
    $servername = $_POST['servername'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $db_name = $_POST['db_name'];

    try {
        $conn = new PDO("mysql:host=$servername", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
        $conn->exec($sql);

        echo "DB created successfully";

        $sql = "use $db_name";
        $conn->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS users (
            user_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            firstname varchar(50) NOT NULL,
            surname varchar(50) NOT NULL,
            email varchar(50) NOT NULL,
            username varchar(50) NOT NULL,
            password_ varchar(50) NOT NULL,
            create_date datetime NOT NULL,
            last_login datetime,
            is_verified int NOT NULL,
            is_admin int NOT NULL
            );";
        
        $conn->exec($sql);

        echo "users table created successfully";

        $sql = "CREATE TABLE IF NOT EXISTS questions (
            q_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            q_title varchar(100) NOT NULL,
            q_description varchar(1000) NOT NULL,
            q_author int NOT NULL,
            q_like int NOT NULL,
            q_dislike int NOT NULL,
            q_date datetime NOT NULL,
            FOREIGN KEY (q_author) REFERENCES Users(user_id)
            );";

        echo "questions table created successfully";

        $conn->exec($sql);

        date_default_timezone_set('Europe/Istanbul');
        $CreateDate = date('Y-m-d H:i:s');
        $LastLogin = date('Y-m-d H:i:s');

        $sql= "INSERT INTO users(firstname,surname,email,username,password_,create_date,last_login,is_verified,is_admin) 
        VALUES ('a','a','a@a.com','a','a','$CreateDate','$LastLogin',0,0),
        ('b','b','b@b.com','b','b','$CreateDate','$LastLogin',1,0),
        ('c','c','c@c.com','c','c','$CreateDate','$LastLogin',0,1);";
        $conn->exec($sql);

        echo "Everything is okey :)";

    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
}
