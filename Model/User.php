<?php

require_once "vendor/DB.php";


class User{
    private $firstname = null;
    private $surename = null;
    private $username = null;
    private $email = null;
    private $password = null;
    private $hash = null;
    protected $db = null;

    public function __construct($firstname, $surename, $password, $username, $email){
        $this->firstname = $firstname;
        $this->surename = $surename;
        $this->username = $username;
        $this->email = $email;
        $this->password = md5($password);
        $this->hash = 123;
    }
    
    public function registerUser(){
        $this->db = new DB;
        $this->db->query("INSERT INTO 
                                `User`(`fistname`, `surname`, `username`, `email`, `password`, `hash`) 
                            VALUES ('".$this->firstname."','".$this->surename."','".$this->username."','".$this->email."','".$this->password."', '".$this->hash."')", false);
    }

}

?>