<?php
/**
 * Class helperDev
 * @author Atakan Demircioğlu
 * @blog https://www.atakann.com
 * @mail mehata1997@hotmail.com
 * @date 10.12.2019
 * @update 05.02.2020
 */
include_once 'inc/Conn.php';
class helperDev {

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

    /* ***  Function to get the client IP address *** */
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
    /* ***  Generate SEO Friendly URL's *** */
    public static function SEOFriendlyURL($string) {
        $conne = new Mysql();
        $conn = $conne->dbConnect();

        if ($string !== mb_convert_encoding(mb_convert_encoding($string, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32')) {
            $string = mb_convert_encoding($string, 'UTF-8', mb_detect_encoding($string));
        }

        $string = htmlentities($string, ENT_NOQUOTES, 'UTF-8');
        $string = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '1', $string);
        $string = html_entity_decode($string, ENT_NOQUOTES, 'UTF-8');
        $string = preg_replace(array('`[^a-z0-9]`i', '`[-]+`'), '-', $string);
        $string = strtolower(trim($string, '-'));

        $query = "SELECT * FROM questions WHERE slug = '$string'";
        $rowCount = $conne->selectRowCount($query);
        if ($rowCount > 0) {
            $randomNumber = rand(15, 20000000);
            $string .= "-" . $randomNumber;
        }
        return $string;
    }

    public static function generateRandomColor() {
        $bs_buttons = ["success","info", "warning", "danger" , "primary", "secondary" , "light" , "dark"];
        $randomNumber = rand(0, count($bs_buttons)); 
        return $bs_buttons[$randomNumber];
    }
}
