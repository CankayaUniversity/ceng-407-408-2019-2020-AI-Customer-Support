<?php 

class ExceptionHandler {

    private $ErrorMessage;
    private $ErrorCode;

    public function Login(){
        $this->ErrorMessage = "Username and password does not match.";
        $this->ErrorCode = "LoginError";
        return array("ErrorCode" => $this->ErrorCode, "ErrorMessage" => $this->ErrorMessage);
    }
    public function Connection($type){
        if($type == "DBError"){
            $this->ErrorMessage = "Database username and password does not match.";
            $this->ErrorCode = "ServerError";
            return array("ErrorCode" => $this->ErrorCode, "ErrorMessage" => $this->ErrorMessage);
        }
        else if($type == "ServerError"){
            $this->ErrorMessage = "Database username and password does not match.";
            $this->ErrorCode = "ServerError";
            return array("ErrorCode" => $this->ErrorCode, "ErrorMessage" => $this->ErrorMessage);
        }
    }
    public function Register($type){
        if($type == "EmailError"){
            $this->ErrorMessage = "This email already exists.";
            $this->ErrorCode = "EmailError";
            return array("ErrorCode" => $this->ErrorCode, "ErrorMessage" => $this->ErrorMessage);
        }
        else if($type == "UsernameError"){
            $this->ErrorMessage = "This username already exists.";
            $this->ErrorCode = "EmailError";
            return array("ErrorCode" => $this->ErrorCode, "ErrorMessage" => $this->ErrorMessage);
        }
    }
}

?>