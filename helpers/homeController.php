<?php
/**
 * Class HomeController
 * @author Atakan Demircioğlu, Arınç Alp Eren
 * @blog https://www.atakann.com
 * @mail mehata1997@hotmail.com
 * @date 10.12.2019
 * @update 05.02.2020
 */
include 'inc/Conn.php';
class HomeController
{
    public static function getNCount($userid) {
        $conne = new Mysql();
        $conn = $conne->dbConnect();
        $n_sql = "SELECT * FROM notifications WHERE n_notified_id = '$userid' AND n_isChecked=0";
        $n_count = $conn->prepare($n_sql);
        $n_count->execute();
        $count = $n_count->rowCount();
        echo "<script>var n_count = " . json_encode($count) . ";</script>";
    }

    public static function getNotifications($userid) {
        $conne = new Mysql();
        $conn = $conne->dbConnect();
        $n_sql = "SELECT * FROM notifications WHERE n_notified_id = '$userid' AND n_isChecked=0 ORDER BY n_id DESC";
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
            $n_image = $value['n_image'];

            $sql = $conn->query("SELECT slug FROM questions WHERE q_id = $n_post_id ", PDO::FETCH_ASSOC)->fetch();
            $slug = $sql['slug'];

            echo
                "
            <script>
                notifications.push({
                    href: '/post/$slug',
                    image: '$n_image',
                    texte: '$desc',
                    date: '$n_date'
                });
            </script>";
            $counter++;
        }
    }

    public static function popularArticles() {
        $conne = new Mysql();
        $conn = $conne->dbConnect();
        $popularArticles = $conne->selectFreeRun("SELECT * FROM questions ORDER BY q_view DESC LIMIT 5");
        return $popularArticles;
    }
}
