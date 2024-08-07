<?php

require_once "vendor/DB.php";

class Validator{
    public static function isValid($inputData){
        $errors =[];
        if(isset($inputData['user_firstname'])){
            $errors["user_firstname"] = self::validateName($_POST['user_firstname']);
        }
        if(isset($inputData['user_surname'])){
            $errors["user_surname"] = self::validateName($_POST['user_surname']);
        }
        if(isset($inputData['user_email'])){
            $errors["user_email"] = self::validateEmail($_POST['user_email']);
        }
        if(isset($inputData['user_username'])){
            $errors["user_username"] = self::validateUsername($_POST["user_username"]);
        }
        if(isset($inputData['user_password'])){
            $errors["user_password"] = self::validatePassword($_POST["user_password"]);
        }
        if(isset($inputData['user_repassword'])){
            $errors["user_repassword"] = self::validateRePassword($_POST["user_password"], $_POST["user_repassword"]);
        }
        return $errors;
    }
    
    private static function validateName($value){
        if(!empty($value)){
            if(strlen($value) < 3){   
                return "Имя не должно быть меньше 3 символов";
            }
            return null;
        }
        return "Поле обязательно для ввода";
    }

    private static function validateEmail($value){
        if(!empty($value)){
            if(strlen($value) < 8){
                return "Поле не должно быть меньше 8 символов";    
            }
            if(1 != preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-0-9A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $value)){
                return "Ведденные данные не соответстуют формату адреса электронной почты";
            }
            if(!empty(self::checkUseremailDB($value))){
                return "Адрес почты уже используется";
            }
            return null;
        }
        return "Поле обязательно для ввода";
    }

    private static function validateUsername($value){
        if(!empty($value)){
            if(strlen($value) < 6){ 
                return "Имя не должно быть меньше 6 символов";
            }
            if(!empty(self::checkUserNameDB($value))){
                return "Имя уже занято";
            }
            return null;
        }
        return "Поле обязательно для ввода";
    }     

    private static function validatePassword($value){
        if(!empty($value)){
            if(strlen($value) < 8){ 
                return "Пароль не должен быть меньше 8 символов";
            }
            return null;
        }
        return "Поле обязательно для ввода";
    }        

    private static function validateRePassword($password, $rePassword){
        if(!empty($rePassword)){
            if(strlen($rePassword) < 8){
                return "Пароль не должен быть меньше 8 символов";     
            }
            if($password != $rePassword){
                return "Пароли должны совпадать";
            }
            return null;       
        }
        return "Поле обязательно для ввода";    
    }

    private static function checkUserNameDB($username){
        $db = new DB();
        $sql = "SELECT username FROM user WHERE `username` = '".$username."'";
        $result = $db->query($sql);
        return $result;
    }

    private static function checkUserEmailDB($email){
        $db = new DB();
        $sql = "SELECT email FROM user WHERE email = '".$email."'";
        $result = $db->query($sql);
        return $result;
    }   
}
