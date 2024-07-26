<?php

require_once "vendor/DB.php";


class User{
    protected $firstname = null;
    protected $surename = null;
    protected $username = null;
    protected $email = null;
    protected $password = null;
    protected $hash = null;
    protected $db = null;

    public function __construct($firstname, $surename,  $username, $email, $password,){
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