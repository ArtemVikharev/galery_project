<?php
require_once "Model/Model.php";

class ImageModel extends Model{
    public $table = "image";
    public $columns = ["id", "name", "path", "view_count"];

    public function __construct(){           
        parent::__construct($this->table, $this->columns);

    }

    public function getOneImage($index){
        $this-> db = new DB();

        $columns = Lib::convertListToString($this->columns);
        $data = $this->db->query("SELECT " . $columns . " FROM " . $this->table . " WHERE id=".$index."");

        return $data;
    }

    public function increseViewCount($index){
        $this-> db = new DB();

        $columns = Lib::convertListToString($this->columns);
        $data = $this->db->query("SELECT " . $columns . " FROM " . $this->table . " WHERE id=".$index."");

        $data[0]['view_count'] +=1;

        $this->db->query("UPDATE ".$this->table." SET `view_count`=".$data[0]["view_count"]." WHERE `id`=".$index."", false);
    }


}