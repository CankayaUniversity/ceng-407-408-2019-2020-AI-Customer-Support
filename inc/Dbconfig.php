<?php
/**
 * Class HomeController
 * @author Atakan Demircioğlu, Arınç Alp Eren
 * @blog https://www.atakann.com
 * @mail mehata1997@hotmail.com
 * @date 10.12.2019
 * @update 22.02.2020
 */ 
class Dbconfig {
    protected $serverName;
    protected $userName;
    protected $passCode;
    protected $dbName;

    function Dbconfig() {
        $this->serverName = 'localhost';
        $this->userName = 'root';
        $this->passCode = '12345678';
        $this->dbName = 'customer_support';
    }
}
?>