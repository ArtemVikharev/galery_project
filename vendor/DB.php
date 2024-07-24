<?php 
    require_once "config.php";

    class DB{ 
        public $connect = null;

        public function __construct(){
                $this->connect();
        }


        public function connect(){
            $this->connect = new mysqli(HOST, USER, PASSWORD, DB_NAME);
        }
        public function querySelect($sql, $responseData = true){
            $result = $this->connect->query($sql);

            if (!$result){
                die("error");
            }
            
            
            if($responseData){
                $data = [];

                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    $data[] = $row;
                }   
            
            }

            return $data;

        }
        public function query($sql, $responseData = true){
            $result = $this->connect->query($sql);

            if (!$result){
                die("error");
            }
            
            
            if($responseData){
                $data = [];

                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    $data[] = $row;
                }   
            
            }
        }

    }