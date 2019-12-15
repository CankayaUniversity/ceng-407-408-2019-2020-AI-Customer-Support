<?php 
include 'inc/Conn.php';
class HomeController 
{
    public function getNCount($userid) {
        $conne = new Mysql();
        $conn = $conne->dbConnect();
        $n_sql = "SELECT * FROM notifications WHERE n_notified_id = '$userid'";
        $n_count = $conn->prepare($n_sql);
        $n_count->execute();
        $count = $n_count->rowCount();
        echo "<script>var n_count = ".json_encode($count).";</script>";
    }

    public function getNotifications($userid){
        $conne = new Mysql();
        $conn = $conne->dbConnect();
        $n_sql = "SELECT * FROM notifications WHERE n_notified_id = '$userid'";
        $n_count = $conn->prepare($n_sql);
        $n_count->execute();
        $count = $n_count->rowCount();
        echo "<script>var notifications = new Array();</script>";
        $q = $conn->query($n_sql);
        $q->setFetchMode(PDO::FETCH_ASSOC);
        for($i=0;$i<$count;$i++){
            $r=$q->fetch();
            $desc = $r['n_description'];
            $desc = wordwrap($desc, 40, "<br>", true);
            $n_date = $r['n_date'];
            echo 
            "
            <script>
                notifications.push({
                    href: 'index.php',
                    image: 'Modification',
                    texte: '$desc',
                    date: '$n_date'
                });

                var template = $('#notificationTemplate').html();
                template = template.replace('{{image}}', notifications[$i].image);
                template = template.replace('{{href}}', notifications[$i].href);
                template = template.replace('{{texte}}', notifications[$i].texte);
                template = template.replace('{{date}}', notifications[$i].date);
    
                $('#notificationsContainer').append(template);

            </script>";
        }
    }
} 

?>