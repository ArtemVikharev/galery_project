<?php
require_once "Model/Model.php";


class ImageModel extends Model{
    public $table = "image";
    public $columns = ["id", "name", "height", "width", "format", "viev_count"];

    public function __construct(){           
        parent::__construct($this->table, $this->columns);

    }


}