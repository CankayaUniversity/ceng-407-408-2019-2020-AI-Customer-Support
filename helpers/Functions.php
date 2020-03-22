<?php
/**
 * Class Functions
 * @author Atakan Demircioğlu, Arınç Alp Eren
 * @blog https://www.atakann.com
 * @mail mehata1997@hotmail.com
 * @date 10.12.2019
 * @update 05.02.2020
 */
include 'inc/Conn.php';
class Functions
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

    public static function getQuestionNumber() {
        $conne = new Mysql();
        $conn = $conne->dbConnect();
        $count = $conne->selectRowCount("SELECT * FROM questions");
        return $count;
    }

    public static function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } else if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } else if (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } else if (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } else if (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    public static function generateRandomColor() {
        $bs_buttons = ["success","info", "warning", "danger" , "primary", "secondary" , "light" , "dark"];
        $randomNumber = rand(0, count($bs_buttons)-1); 
        return $bs_buttons[$randomNumber];
    }

    /* *** Find time ago for comments *** */
    public static function timeAgo($time_ago) {
        $time_ago = strtotime($time_ago);
        $cur_time = time();
        $time_elapsed = $cur_time - $time_ago;
        $seconds = $time_elapsed;
        $minutes = round($time_elapsed / 60);
        $hours = round($time_elapsed / 3600);
        $days = round($time_elapsed / 86400);
        $weeks = round($time_elapsed / 604800);
        $months = round($time_elapsed / 2600640);
        $years = round($time_elapsed / 31207680);
        // Seconds
        if ($seconds <= 60) {
            return "just now";
        }
        //Minutes
        else if ($minutes <= 60) {
            if ($minutes == 1) {
                return "one minute ago";
            } else {
                return "$minutes minutes ago";
            }
        }
        //Hours
        else if ($hours <= 24) {
            if ($hours == 1) {
                return "an hour ago";
            } else {
                return "$hours hrs ago";
            }
        }
        //Days
        else if ($days <= 7) {
            if ($days == 1) {
                return "yesterday";
            } else {
                return "$days days ago";
            }
        }
        //Weeks
        else if ($weeks <= 4.3) {
            if ($weeks == 1) {
                return "a week ago";
            } else {
                return "$weeks weeks ago";
            }
        }
        //Months
        else if ($months <= 12) {
            if ($months == 1) {
                return "a month ago";
            } else {
                return "$months months ago";
            }
        }
        //Years
        else {
            if ($years == 1) {
                return "one year ago";
            } else {
                return "$years years ago";
            }
        }
    }
}
