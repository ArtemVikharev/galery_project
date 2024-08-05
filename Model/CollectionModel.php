<?php
require_once "Model/Model.php";

class CollectionModel extends Model{
    public $table = "collection";
    public $columns = ["id", "name", "user_id"];

    public function __construct(){           
        parent::__construct($this->table, $this->columns);

    }
    public function getOneCollection($index){
        $columns = Lib::convertListToString($this->columns);
        $data = $this->db->query("SELECT " . $columns . " FROM " . $this->table . " WHERE id=".$index."");
        return $data;
    }

    public static function createCollection($userId, $nameCollection, $parrentCollectionId = null){
        $db = new DB();
        $db->query("INSERT INTO `collection`(`name`, `user_id`) VALUES ('".$nameCollection."','".$userId."')", false);
        $last_id = $db->lastInsertId();
        if(!isset($parrentCollectionId)){
            $collectionId = $last_id;
            $db->query("INSERT INTO `collection_treepath`(`parent_id`) VALUES ('".$collectionId."')", false);
        }
        if(isset($parrentCollectionId)){
            $childrenCollectionId = $last_id;
            $db->query("INSERT INTO `collection_treepath`(`parent_id`, `children_id`) VALUES ('".$parrentCollectionId."','".$childrenCollectionId."')", false);
        }
    }

    public function getCollection($userId, $parrentCollectionId = null){
        $columns = Lib::convertListToString($this->columns);
        if(isset($parrentCollectionId)){
            $data = $this->db->query("SELECT ".$columns." FROM ".$this->table." WHERE id IN ( SELECT
                                        collection_treepath.children_id AS children_id
                                    FROM 
                                        " . $this->table . "
                                    JOIN
                                        `collection_treepath` ON collection_treepath.parent_id = ".$this->table.".id
                                    WHERE `user_id`=".$userId." AND `collection_treepath`.parent_id=".$parrentCollectionId." AND collection_treepath.children_id > '')");
            return $data;
        }
        if(!isset($parrentCollectionId)){{
            $data = $this->db->query("SELECT
                                     " . $columns . ", collection_treepath.parent_id
                                    FROM 
                                        " . $this->table . "
                                    JOIN
                                        `collection_treepath` ON collection_treepath.parent_id = ".$this->table.".id
                                    WHERE `user_id`=".$userId." AND `collection_treepath`.children_id IS null");
        }
        return $data;
        }
    }

    public function deleteCollection($collectionId){
        $this->db->multiQuery("DELETE FROM image_collection WHERE collection_id IN  (
                                SELECT children_id FROM (
                                    SELECT children_id FROM `collection`
                                    JOIN collection_treepath ON `collection`.id = collection_treepath.children_id
                                    WHERE collection_treepath.parent_id = ".$collectionId."
                                ) AS tmptable);

                            DELETE FROM image_collection WHERE collection_id IN (
                                    SELECT children_id FROM (
                                        SELECT children_id FROM `collection_treepath`
                                        WHERE parent_id = ".$collectionId."
                                    ) AS tmptable);

                            DELETE FROM image_collection WHERE collection_id = ".$collectionId.";

                            DELETE FROM `collection`
                                    WHERE id IN (
                                        SELECT children_id FROM (
                                            SELECT children_id FROM `collection`
                                            JOIN collection_treepath ON `collection`.id = collection_treepath.children_id
                                            WHERE collection_treepath.parent_id = ".$collectionId."
                                        ) AS tmptable
                                    );

                            DELETE FROM `collection_treepath`
                                    WHERE children_id IN (
                                        SELECT children_id FROM (
                                            SELECT children_id FROM `collection_treepath`
                                            WHERE parent_id = ".$collectionId."
                                        ) AS tmptable
                                    );
                            DELETE FROM `collection`
                                    WHERE id = ".$collectionId.";   

                            DELETE FROM collection_treepath
                                    WHERE parent_id = ".$collectionId."");
                                
    }

    public function getChildrenCollection($collectionId){
        $data = $this->db->query("SELECT * FROM `collection`
                                JOIN collection_treepath ON `collection`.id = collection_treepath.children_id
                                WHERE collection_treepath.parent_id = ".$collectionId."");

        $data = $this->getRecorseChildrenCollectio($data);
        return $data;
    }
    public function getAllUserCollection($userId){
        $data = $this->getCollection($userId);
        $data = $this->getRecorseChildrenCollectio($data);
        return $data;
    }

    private function getRecorseChildrenCollectio($data){
        foreach ($data as &$elem) {
            if (is_array($elem)) {
                $elem['childrenCollection'] = $this->getChildrenCollection($elem['id']);
            }
        }
        return $data;
    }


    public function deleteCollectionImage($collectionId){
        $sql = "DELETE FROM image_collection WHERE collection_id IN  (
                        SELECT children_id FROM (
                            SELECT children_id FROM `collection`
                            JOIN collection_treepath ON `collection`.id = collection_treepath.children_id
                            WHERE collection_treepath.parent_id = ".$collectionId."
                        ) AS temptable
                );
                DELETE FROM image_collection WHERE collection_id IN (
                        SELECT children_id FROM (
                            SELECT children_id FROM `collection_treepath`
                            WHERE parent_id = ".$collectionId."
                        ) AS temptable
                    );

                DELETE FROM image_collection WHERE collection_id = ".$collectionId."";

      $this->db->multiQuery($sql, false);

    }
}