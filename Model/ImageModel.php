<?php
require_once "Model/Model.php";

class ImageModel extends Model{
    public $table = "image";
    public $columns = ["id", "name", "path", "view_count"];

    public function __construct(){           
        parent::__construct($this->table, $this->columns);

    }

    public function getOneImage($index){

        $columns = Lib::convertListToString($this->columns);
        $data = $this->db->query("SELECT " . $columns . " FROM " . $this->table . " WHERE id=".$index."");

        return $data;
    }
    public function getCollectionImage($userId, $collectionId){
        $data = $this->db->query("SELECT 
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
                                        collection.id=".$collectionId." AND collection.user_id=".$userId."
                                    ");
        return $data;                                   
    }
        
    public function increseViewCount($index){
        $this-> db = new DB();

        $columns = Lib::convertListToString($this->columns);
        $data = $this->db->query("SELECT " . $columns . " FROM " . $this->table . " WHERE id=".$index."");

        $data[0]['view_count'] +=1;

        $this->db->query("UPDATE ".$this->table." SET `view_count`=".$data[0]["view_count"]." WHERE `id`=".$index."", false);
    }

    public function addInCollection($imageId, $colectionId){
        $table = "image_collection";
        $columns = Lib::convertListToString(["image_id", "collection_id"]);
        $result = $this->db->query("SELECT $columns FROM $table WHERE image_id=".$imageId." AND collection_id = ".$colectionId."");
        if ($result){

            return "Изображение уже добавленно в выбранную коллекцию";
        }
        $this->db->query("INSERT INTO `".$table."`(".$columns.") VALUES ('".$imageId."','".$colectionId."')",false);
        
    }
    public function deleteCollectionImage($imageId, $collectionId){
        $this->db->query("DELETE FROM `image_collection` WHERE `image_id`=".$imageId." AND `collection_id`=".$collectionId."", false);
    }

    public function deleteImageInCollection($collectionId){

        // $this->db->query("DELETE FROM `image_collection`
        //                             WHERE `image_collection`.image_id IN (
        //                                 SELECT image_id FROM (
        //                                     SELECT image_id FROM `image_treepath`
        //                                     WHERE collectionId = ".$collectionId."
        //                                 ) AS temptable
        // )", false);
    }

    public function getMostView(){
        $columns = Lib::convertListToString($this->columns);
        $data = $this->db->query("SELECT ".$columns." FROM ".$this->table." ORDER BY  `image`.`view_count` DESC LIMIT 3");

        return $data;
    }
}