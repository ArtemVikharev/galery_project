<?php
require_once "vendor/DB.php";

class Upload{

    public static function upload_file($objectFile){
        
        if(!is_dir("upload/")){
            mkdir("upload/");
        }
        $fileNameCmps = explode(".",$objectFile['name']);
        $fileExtension = strtolower(end($fileNameCmps)); 
        $path = "upload/" . md5(date("Y-m-d H:i:s")).".".$fileExtension."";
        move_uploaded_file($objectFile["tmp_name"], $path);
        $fileName = $fileNameCmps[0];

        $db = new DB;
        $db->query("INSERT INTO 
        `image`(`name`, `format`, `path`) 
            VALUES ('".$fileName."','".$fileExtension."','".$path."')", false);
        }
    }
