<?php 
include 'inc/Conn.php';
class HomeController 
{
    public static function getNCount($userid) {
        $conne = new Mysql();
        $conn = $conne->dbConnect();
        $n_sql = "SELECT * FROM notifications WHERE n_notified_id = '$userid'";
        $n_count = $conn->prepare($n_sql);
        $n_count->execute();
        $count = $n_count->rowCount();
        echo "<script>var n_count = ".json_encode($count).";</script>";
    }

    public static function getNotifications($userid){
        $conne = new Mysql();
        $conn = $conne->dbConnect();
        $n_sql = "SELECT * FROM notifications WHERE n_notified_id = '$userid'";
        $n_count = $conn->prepare($n_sql);
        $n_count->execute();
        $count = $n_count->rowCount();
        echo "<script>var notifications = new Array();</script>";
        $q = $conn->query($n_sql);
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $result = $q->fetchAll();
        $counter = 0;
        foreach ($result as $key => $value) {

            $desc = $value['n_description'];
            $desc = wordwrap($desc, 40, "<br>", true);
            $n_date = $value['n_date'];
            $n_post_id = $value['n_post_id'];
            echo 
            "
            <script>
                notifications.push({
                    href: 'single.php?post=$n_post_id',
                    image: 'Modification',
                    texte: '$desc',
                    date: '$n_date'
                });

                var template = $('#notificationTemplate').html();
                template = template.replace('{{image}}', notifications[$counter].image);
                template = template.replace('{{href}}', notifications[$counter].href);
                template = template.replace('{{texte}}', notifications[$counter].texte);
                template = template.replace('{{date}}', notifications[$counter].date);
    
                $('#notificationsContainer').append(template);

            </script>";
            $counter++;
        }
    }
} 

?>