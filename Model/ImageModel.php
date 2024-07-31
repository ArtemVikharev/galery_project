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
    public function getCollectionImage($userId, $collectionId, $subCollectionId = null){
        if(!$subCollectionId){
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
    }
        


    public function increseViewCount($index){
        $this-> db = new DB();

        $columns = Lib::convertListToString($this->columns);
        $data = $this->db->query("SELECT " . $columns . " FROM " . $this->table . " WHERE id=".$index."");

        $data[0]['view_count'] +=1;

        $this->db->query("UPDATE ".$this->table." SET `view_count`=".$data[0]["view_count"]." WHERE `id`=".$index."", false);
    }

    public static function addInCollection($imageId, $colectionId){
        $db = new DB();
        $table = "image_collection";
        $columns = Lib::convertListToString(["image_id", "collection_id"]);
        echo "INSERT INTO `".$table."`(".$columns.") VALUES ('".$imageId."','".$colectionId."')";
        $db->query("INSERT INTO `".$table."`(".$columns.") VALUES ('".$imageId."','".$colectionId."')",false);
        
    }


}