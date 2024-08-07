<?php
require_once "Model/Model.php";

class ImageModel extends Model{
    private $table = "image";
    private $columns = ["id", "name", "path", "view_count"];

    public function __construct(){           
        parent::__construct($this->table, $this->columns);

    }

    public function getOneImage($index){
        $columns = Lib::convertListToString($this->columns);
        $sql = "SELECT " . $columns . " FROM " . $this->table . " WHERE id=".$index."";
        $data = $this->db->query($sql);
        return $data;
    }
    
    public function getCollectionImage($userId, $collectionId){
        $sql = "SELECT 
                    image.id AS image_id,
                    image.path AS image_path,
                    image.view_count,
                    collection.name AS collection_name
                FROM
                    `image`
                JOIN
                    image_collection ON image_collection.image_id=image.id
                JOIN
                    `collection` ON image_collection.collection_id=collection.id
                WHERE
                    collection.id=".$collectionId." AND collection.user_id=".$userId."";

        $data = $this->db->query($sql);
        return $data;                                   
    }
        
    public function increseViewCount($index){
        $this-> db = new DB();
        $data = [];
        $columns = Lib::convertListToString($this->columns);
        $sql = "SELECT " . $columns . " FROM " . $this->table . " WHERE id=".$index."";
        $result = $this->db->query($sql);
        $data['image'] = $result[0];
        $data['image']['view_count'] +=1;
        $sql = "UPDATE ".$this->table." SET `view_count`=".$data['image']["view_count"]." WHERE `id`=".$index."";
        $this->db->query($sql, false);
    }

    public function addInCollection($imageId, $colectionId){
        $table = "image_collection";
        $columns = Lib::convertListToString(["image_id", "collection_id"]);
        $sql = "SELECT $columns FROM $table WHERE image_id=".$imageId." AND collection_id = ".$colectionId."";
        $result = $this->db->query($sql);
        if ($result){
            return "Изображение уже добавленно в выбранную коллекцию";
        }
        $sql = "INSERT INTO `".$table."`(".$columns.") VALUES ('".$imageId."','".$colectionId."')";
        $this->db->query($sql, false);
        
    }
    public function deleteImage($imageId, $collectionId){
        $sql = "DELETE FROM `image_collection` WHERE `image_id`=".$imageId." AND `collection_id`=".$collectionId."";
        $this->db->query($sql, false);
    }

    public function deleteCollectionImage($collectionId){
        $sql = "DELETE FROM `image_collection` WHERE `collection_id`=".$collectionId."";
        $this->db->query($sql, false);
    }

    public function getMostView(){
        $columns = Lib::convertListToString($this->columns);
        $sql = "SELECT ".$columns." FROM ".$this->table." ORDER BY  `image`.`view_count` DESC LIMIT 3";
        $data = $this->db->query($sql);
        return $data;
    }
}