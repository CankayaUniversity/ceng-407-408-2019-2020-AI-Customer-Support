<?php

include 'Dbconfig.php';

class Mysql extends Dbconfig    {

public $conn;
public $dataSet;
private $sqlQuery;

protected $databaseName;
protected $hostName;
protected $userName;
protected $passCode;

function Mysql()    {
    $this->conn = NULL;
    $this->sqlQuery = NULL;
    $this->dataSet = NULL;

    $dbPara = new Dbconfig();
    $this->databaseName = $dbPara->dbName;
    $this->hostName = $dbPara->serverName;
    $this->userName = $dbPara->userName;
    $this->passCode = $dbPara->passCode;
    $dbPara = NULL;
    $this->checkEnv();
    
}

function checkEnv() {
    if(!defined('ENV')) {
        if ($_SERVER['HTTP_HOST'] == 'localhost' ||
         $_SERVER['HTTP_HOST'] == 'localhost:8080' ||
         $_SERVER['HTTP_HOST'] == 'localhost:80') {
            define('ENV', 'dev');
        } else {
            define('ENV', 'live');
        }
    date_default_timezone_set('Europe/Istanbul');
    }
}

function dbConnect()    {
    $this->conn = new PDO("mysql:host=$this->hostName;dbname=$this->databaseName", $this->userName, $this->passCode);
    //$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $this->conn;
}

 function selectAll($tableName) {
    $this->sqlQuery = 'SELECT * FROM '.$tableName.'';
    $this->dataSet = $this->conn->prepare($this->sqlQuery);
    $this->dataSet->execute();
    $this->dataSet = $this->dataSet->fetchAll();
    return $this->dataSet;
}

function insertInto($tableName,$values) {
    $i = 0;
    $this->sqlQuery = 'INSERT INTO '.$tableName.' VALUES (null, ';
    while($values[$i]["val"] != NULL && $values[$i]["type"] != NULL) {
        if($values[$i]["type"] == "char")   {
            $this->sqlQuery .= "'";
            $this->sqlQuery .= $values[$i]["val"];
            $this->sqlQuery .= "'";
        }
        else if($values[$i]["type"] == 'int')   {
            $this->sqlQuery .= $values[$i]["val"];
        }
        $i++;
        if($values[$i]["val"] != NULL)  {
            $this->sqlQuery .= ',';
        }
    }
    $this->sqlQuery .= ')';
    $this->conn->prepare($this->sqlQuery)->execute();
    $this->sqlQuery = NULL;
}

function selectWhere($tableName,$rowName,$operator,$value,$valueType)   {
    $this->sqlQuery = 'SELECT * FROM '.$tableName.' WHERE '.$rowName.' '.$operator.' ';
    if($valueType == 'int') {
        $this->sqlQuery .= $value;
    }
    else if($valueType == 'char')   {
        $this->sqlQuery.="'".$value."'";
    }

    $this->dataSet = $this->conn->prepare($this->sqlQuery);
    $this->dataSet->execute();
    $this->dataSet = $this->dataSet->fetchAll();
    
    $this->sqlQuery = NULL;
    return $this->dataSet;
}

function selectFreeRun($query)  {
    $this->dataSet = $this->conn->prepare($query);
    $this->dataSet->execute();
    $this->dataSet = $this->dataSet->fetchAll();
    return $this->dataSet;
}

function freeRun($query)  {
    $this->dataSet = $this->conn->prepare($query)->execute();
}

}
?>