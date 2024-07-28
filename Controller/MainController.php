<?php

require_once "Model/UserModel.php";
require_once "View/View.php";



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

        if($errors){
            header("location: ?route=main/register&status=".json_encode([$errors, $registerData]));
        }
        else{
            $newUser = new User($_POST['user_firstname'], $_POST['user_surname'],$_POST['user_username'],$_POST['user_email'],$_POST['user_password']);
            $newUser->registerUser();
            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index");
        }         
    }
    
    public function addimageAction(){
        $errors = CheckImage::checkImage($_FILES['userfile']);
        if($_FILES['userfile']['error']==4){
            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index");
            die();
        }
        if($errors){
            header("location: ?route=main/index&status=".json_encode([$errors]));
            die();
        }
        Upload::upload_file($_FILES['userfile']);
        header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index");
    }

    public function errorAction(){
        echo "Ошибка открытия страницы";
    }
}