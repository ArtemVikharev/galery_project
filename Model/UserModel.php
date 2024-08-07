<?php

require_once "vendor/DB.php";


class User{
    private $table = "user";
    private $columns = ['fistname', 'surname', 'username', 'email', 'password'];

    protected $firstname = null;
    protected $surename = null;
    protected $username = null;
    protected $email = null;
    protected $password = null;
    protected $db = null;

    public function __construct($firstname, $surename,  $username, $email, $password,){
        $this->firstname = $firstname;
        $this->surename = $surename;
        $this->username = $username;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    
    public function registerUser(){
        $this->db = new DB;
        $columns = Lib::convertListToString($this->columns);
        $sql = "INSERT 
                    INTO 
                        ".$this->table."(".$columns.")
                    VALUES 
                        ('".$this->firstname."','".$this->surename."','".$this->username."','".$this->email."','".$this->password."')";
        $this->db->query($sql, false);
    }

}

?>