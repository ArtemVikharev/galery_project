<?php

class CheckImage{
    public static function checkImage($fileObject){
        $errors = [];
        $errors['imageFormat'] = self::checkImageFormat($fileObject);
        $errors['imageSize'] = self::checkImageSize($fileObject);
        if(empty($errors['imageFormat']) && empty( $errors['imageSize'])){
            $errors = [];
        }
        return $errors;        
    }

    private static function checkImageFormat($fileObject){
        $validFormat = ["gif", "jpg", "jpeg", "png"];

        if(!in_array(strtolower(pathinfo($fileObject['name'], PATHINFO_EXTENSION)), $validFormat)){
            return "Неверный формат изображения";
        }
    }
    private static function checkImageSize($fileObject){
        $validSize = 5242880;
        if($fileObject['size'] > $validSize){
            return "Слишком большой размер изображения, допустимый размер 5МБ";
        }
    }
    
}