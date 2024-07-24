<?php

require_once "Model/User.php";
require_once "View/View.php";


class MainController{

    public function indexAction(){
        // echo "Главная страница";
        $data = [];

        // if (!$data || count($data) == 0) {

        //     header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/error");
        // }
        View::render(["page_view" => "default", "layout" => "default", $data]);
    }

    public function registerAction(){

        $data =[];

        View::render(["page_view" => "register", "layout" => "default", $data]);
    }

    public function registerformAction(){
        $newUser = new User($_POST['user_firstname'], $_POST['user_surname'],$_POST['user_username'],$_POST['user_email'],$_POST['user_password']);
        $newUser->registerUser();

        header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index");
    }


    public function errorAction(){
        echo "Ошибка открытия страницы";
    }
}