<?php
/**
 * Class SEOHelper
 * @author Atakan Demircioğlu
 * @blog https://www.atakann.com
 * @mail mehata1997@hotmail.com
 * @date 17.11.2019
 * @update 05.02.2020
 */
include_once 'inc/Conn.php';
class SEOHelper
{

    /*
    Try to get site settings
     */
    public static function getSiteSettings(){
        $conne = new Mysql();
        $conn = $conne->dbConnect();
        $siteSettings = $conne->selectAll("site_settings");
        if(is_array($siteSettings) && !empty($siteSettings)){
            return $siteSettings;
        } else {
            return false;
        }
    }

    /*
    Credentials
     */
    public static function getDescriptions($returnDescriptions) {
        $getSiteSettings = self::getSiteSettings();

        if($getSiteSettings !== false){
            $Descriptions = array(
                "title" => $getSiteSettings[0]['site_title'],
                "email" => $getSiteSettings[0]['mail_address'],
                "slogan" => $getSiteSettings[0]['slogan'],
                "description" => "Best ai customer support system",
                "keywords" => "This is my page keywords",
                "robots" => "no index, no follow");
        } else {
            $Descriptions = array(
                "title" => "AI Customer Support",
                "email" => "mehata1997@hotmail.com",
                "slogan" => "Best ai customer support system",
                "description" => "This is my page description",
                "keywords" => "This is my page keywords",
                "robots" => "no index, no follow");
        }

        return $Descriptions[$returnDescriptions];
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

}
