<?php
/**
 * Class helperMeta
 * @author Atakan Demircioğlu
 * @blog https://www.atakann.com
 * @mail mehata1997@hotmail.com
 * @date 17.11.2019
 * @update 05.02.2020
 */ 
class helperMeta
{

    /*
    Meta Descriptions
     */
    public static function getDescriptions($returnDescriptions) {
        $Descriptions = array(
            "description" => "This is my page description",
            "keywords" => "This is my page keywords",
            "robots" => "no index, no follow");
        return $Descriptions[$returnDescriptions];
    }

}
