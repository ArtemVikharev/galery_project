<?php
require_once "Model/UserModel.php";
require_once "Model/ImageModel.php";
require_once "View/View.php";
require_once "Helper/Auth.php";

class MainController{

    public function indexAction(){
        $model = new ImageModel();

        $data = $model->get();

        if (!$data || count($data) == 0) {

            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/error");
        }
        
        View::render(["page_view" => "default", "layout" => "default", "data" => $data]);
    }

    public function registerAction(){

        $data =[];

        View::render(["page_view" => "register", "layout" => "default", "data" => $data]);
    }

    public function registerformAction(){
        $registerData = $_POST;
        $errors = Validator::isValid($registerData);
        if(!empty(array_diff($errors, array('')))){
            header("location: ?route=main/register&status=".json_encode([$errors, $registerData]));
            die();
        }
        $newUser = new User($_POST['user_firstname'], $_POST['user_surname'],$_POST['user_username'],$_POST['user_email'],$_POST['user_password']);
        $newUser->registerUser();
        header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index");   
    }

    public function authAction(){
        if($_GET['action'] == "out"){
            Auth::out();
        } 
        if(isset($_POST['log_in'])){ 
            $authErrors = Auth::enter();
            if (count($authErrors) == 0){   
                $UID = $_SESSION['id'];
                header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index");
            }
            if($authErrors){
                header("location: ?route=main/index&status=".json_encode([$authErrors]));
            }
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
    public function itemImageAction(){
        $model = new ImageModel();

        $data = $model->getOneImage($_GET["id"]);

        View::render(["page_view" => "item", "layout" => "default", "data" => $data]);
        $model->increseViewCount($_GET["id"]);
    }

    public function errorAction(){
        echo "Ошибка открытия страницы";
    }
}