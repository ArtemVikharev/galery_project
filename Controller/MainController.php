<?php

require_once "Model/User.php";
require_once "View/View.php";
require_once "Helper/Validator.php";


class MainController{

    public function indexAction(){

        $data = [];

        View::render(["page_view" => "default", "layout" => "default", $data]);
    }

    public function registerAction(){

        $data =[];

        View::render(["page_view" => "register", "layout" => "default", $data]);
    }

    public function registerformAction(){
        $registerData = $_POST;
        $errors = Validator::isValid($registerData);
        if(!$errors){
            header("location: ?route=main/register&status=".json_encode([$errors, $registerData]));
        }
        else{
            echo "регистрация";
            $newUser = new User($_POST['user_firstname'], $_POST['user_surname'],$_POST['user_username'],$_POST['user_email'],$_POST['user_password']);
            $newUser->registerUser();
            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index");
        }         
    }

    public function errorAction(){
        echo "Ошибка открытия страницы";
    }
}