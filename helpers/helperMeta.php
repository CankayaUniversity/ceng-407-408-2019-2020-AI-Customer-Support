<?php
class helperMeta
{

    /*
    Meta Descriptions
     */
    public function getDescriptions($returnDescriptions) {
        $Descriptions = array(
            "description" => "This is my page description",
            "keywords" => "This is my page keywords",
            "robots" => "no index, no follow");
        return $Descriptions[$returnDescriptions];
    }

}
