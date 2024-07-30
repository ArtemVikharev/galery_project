<?php
require_once "Model/Model.php";

class CollectionModel extends Model{
    public $table = "collection";
    public $columns = ["id", "name", "user_id"];

    public function __construct(){           
        parent::__construct($this->table, $this->columns);

    }

    public static function createCollection($collectionName, $userId){
        $db = new DB();
        
        $db->query("INSERT INTO `collection`(`name`, `user_id`) VALUES ('".$collectionName."','".$userId."')", false);
    }

    public function getPersonalCollection($userId){
        $columns = Lib::convertListToString($this->columns);
        $data = $this->db->query("SELECT " . $columns . " FROM " . $this->table . " WHERE `user_id`=".$userId."");
        return $data;
    }

}