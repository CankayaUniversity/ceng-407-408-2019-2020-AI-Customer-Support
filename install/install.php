<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install Customer Support DB</title>
    <link rel="shortcut icon" href="images/favicon.png" />
    <!-- Style Sheet-->
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">  
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
<div style=" margin: 30px 50px 100px;">
    <center>
        <img src="../images/mascot.png" alt="mascot" class="img-fluid" width="300px" height="300px">
    </center>
    <form action="install.php" method="post">
        <div class="container">
            <div class="row">
                <div class="col-md-3"> 
                </div>  
                <div class ="col-md-9">
                    <div class="row">
                        <div class="col-md-2"> 
                            <h4><strong><label for="servername">Servername</label></strong></h4>
                        </div>  
                        <div class="col-md-5">   
                            <input type="text" id="servername" name="servername" placeholder="localhost" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-xs">
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-2">
                            <h4><strong><label for="username">Username</label></strong></h4>
                        </div>  
                        <div class="col-md-5"> 
                            <input type="text" id="username" name="username" placeholder="root" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                        </div>   
                    </div>
                    <div class="row">
                        <div class="col-md-2"> 
                            <h4><strong><label for="password">Password</label></strong></h4>
                        </div>  
                        <div class="col-md-5"> 
                            <input type="text" id="password" name="password" placeholder="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                        </div> 
                    </div> 
                    <div class="row">
                        <div class="col-md-2"> 
                            <h4><strong><label for="db_name">DB Name</label></strong></h4>
                        </div>  
                        <div class="col-md-5"> 
                            <input type="text" id="db_name" name="db_name" placeholder="set db name" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                        </div>
                    </div> 
                    <br>
                    <div class="row">
                            <div class="col-md-3"></div> 
                    <div class ="col-md-4">
                        <button type="submit" name="register" value="Register"class="btn btn-primary">Register</button>
                        <label><input type="checkbox" name="ResetDB"/> Reset Database</label>
                    </div>
                </div>    
            </div>
        </div>
        </div>  
    </form>
</body>

<?php 
include '../helpers/helperDev.php';
/*if (ENV == 'live') {
    echo "Şuan live için açık değil.";
    exit(0);
}*/
if (isset($_POST['register'])) {
    $servername = $_POST['servername'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $db_name = $_POST['db_name'];

    if(ENV == "dev") {
        $db_name = 'customer_support';    
    }

    try {
        $conn = new PDO("mysql:host=$servername", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(isset($_POST['ResetDB'])) {
            $sql = "DROP DATABASE IF EXISTS $db_name";
            $conn->exec($sql);
        }

        $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
        $conn->exec($sql);

        echo "DB created successfully.</br> ";

        $sql = "use $db_name";
        $conn->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS users (
            user_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            firstname varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
            surname varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            email varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            username varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            password_ varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
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
            category int NOT NULL DEFAULT '0',
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
            cat_totalquestion int NOT NULL DEFAULT '0'
            );";

        $conn->exec($sql);

        echo "Categories table created successfully.</br> ";

        $sql= "INSERT INTO users(firstname,surname,email,username,password_,is_verified,is_admin) 
        VALUES ('Arınç Alp','Eren','arinc@arinc.com','arinc','arinc',0,0),
        ('Atakan','Demircioğlu','atakan@atakan.com','atakan','atakan',0,0),
        ('Alperen','Sarınay','alperen@alperen.com','alperen','alperen',0,0),
        ('Cavid','Aydın','cavid@cavid.com','cavid','cavid',0,0),
        ('a','a','a@a.com','a','a',0,0),
        ('b','b','b@b.com','b','b',1,0),
        ('c','c','c@c.com','c','c',0,1);";
        $conn->exec($sql);

        $sql= "INSERT INTO questions(q_title, q_description, q_tags, q_author, title_meta, description_meta, keywords_meta, slug) VALUES
        ('Sample Question Title 1 ', 'Sample Question Description 1 ', 'help', 1, 'Sample Question Title 1', 'Sample Question Description 1', 'sample,question,description,1', 'sample-question-1',),
        ('Sample Question Title 2 ', 'Sample Question Description 2 ', 'help', 2, 'Sample Question Title 2', 'Sample Question Description 2', 'sample,question,description,2', 'sample-question-2',),
        ('Sample Question Title 3 ', 'Sample Question Description 3 ', 'help', 3, 'Sample Question Title 3', 'Sample Question Description 3', 'sample,question,description,3', 'sample-question-3',);";
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

        $sql="INSERT INTO categories (cat_name,cat_description,cat_keywords) VALUES
        ('Commerce', 'Support for your products', 'Commerce'),
        ('Profile', 'Profile Support', 'Profile'),
        ('Technical Issues', 'Technical Support', 'Technical,Issues'),
        ('Account', 'Private Informations', 'Account');";
        $conn->exec($sql);

        echo "Insertions done successfully.</br>";

        echo "Everything is okey :)<br>";

        //echo "<meta http-equiv='refresh' content='3;url=../index.php'/>";

        echo"<div id='counter'>You will be redirected to mainpage in 3</div>
            <script>
                var count = 3;
                setInterval(function() {
                    var div = document.querySelector('#counter');
                    count--;
                    div.textContent = 'You will be redirected to mainpage in '+count;
                    if (count <= 0) {
                        window.location.replace('../index.php');
                    }
                }, 1000);
            </script>
            ";

    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
}
