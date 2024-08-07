<?php
require_once "Model/Model.php";

class CollectionModel extends Model{
    public $table = "collection";
    public $columns = ["id", "name", "parent_id", "user_id"];

    public function __construct(){           
        parent::__construct($this->table, $this->columns);

    }
    public function getOneCollection($index){
        $columns = Lib::convertListToString($this->columns);
        $sql = "SELECT " . $columns . " FROM " . $this->table . " WHERE id=".$index."";
        $data =  $this->db->query($sql);
        return $data;
    }

    public function createCollection($userId, $nameCollection, $parrentCollectionId = 'NULL'){
        $sql =  "INSERT INTO ".$this->table." (`name`, parent_id, user_id) VALUES ('".$nameCollection."', ".$parrentCollectionId.", ".$userId.")";
        $this->db->query($sql, false);
    }

    public function getCollection($userId, $parrentCollectionId = null){
        $columns = Lib::convertListToString($this->columns);
        if(!isset($parrentCollectionId)){
            $sql = "SELECT ".$columns." FROM ".$this->table." WHERE user_id = ".$userId." AND parent_id IS NULL";
        }
        if(isset($parrentCollectionId)){
            $sql = "SELECT ".$columns." FROM ".$this->table." WHERE user_id = ".$userId." AND parent_id = ".$parrentCollectionId."";
        }
        $data = $this->db->query($sql);
        return $data;
    }


    public function deleteCollection($collectionId){
        $sql = "DELETE FROM ".$this->table." WHERE id = ".$collectionId."";
        $this->db->query($sql, false);                     
    }

    public function getChildrenCollection($collectionId){
        $columns = Lib::convertListToString($this->columns);
        $sql = "SELECT ".$columns." FROM ".$this->table." WHERE parent_id = ".$collectionId."";
        $data = $this->db->query($sql);
        $data = $this->getRecorseChildrenCollectio($data);
        return $data;
    }
    public function getAllUserCollection($userId){
        $result = $this->getCollection($userId);
        $data = $this->getRecorseChildrenCollectio($result);
        return $data;
    }

    private function getRecorseChildrenCollectio($data){
        foreach ($data as &$elem) {
            if (is_array($elem)) {
                $result = $this->getChildrenCollection($elem['id']);
                $elem['childrenCollection'] = $result;
            }
        }
        return $data;
    }

    public function getChildCollection($collectionId){
        $sql = "WITH RECURSIVE collection_path (id, `name`) AS
                    (
                    SELECT id, `name`
                        FROM collection
                        WHERE parent_id = ".$collectionId."
                    UNION ALL
                    SELECT c.id, c.name
                        FROM collection_path AS cp JOIN collection AS c
                        ON cp.id = c.parent_id
                    )
                    SELECT * FROM collection_path";
        $result = $this->db->query($sql);
        $data = $result;
        return $data;
        }
}