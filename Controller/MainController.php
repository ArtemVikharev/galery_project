<?php
require_once "Model/UserModel.php";
require_once "Model/ImageModel.php";
require_once "Model/CollectionModel.php";
require_once "View/View.php";
require_once "Helper/Auth.php";

class MainController{

    public function indexAction(){
        $model = new ImageModel();
        $data = [];
        $data['images'] = $model->get();
        $data['mostView'] = $model->getMostView();
        if (!$data || count($data) == 0) {
            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/error");
            die();
        }
        View::render(["page_view" => "default", "layout" => "default", "data" => $data]);
    }

    public function registerAction(){
        $data = [];
        if(Auth::login()){
            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index");
            die();
        }
        View::render(["page_view" => "register", "layout" => "default", "data" => $data]);
    }

    public function registerformAction(){
        $data['userData'] = $_POST;
        $data['errors'] = Validator::isValid($data['userData']);
        if(!empty($data)){
            View::render(["page_view" => "register", "layout" => "default", "data" => $data]);
        }
        $newUser = new User($_POST['user_firstname'], $_POST['user_surname'],$_POST['user_username'],$_POST['user_email'],$_POST['user_password']);
        $newUser->registerUser();
        header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index");
        die();
    }

    public function authAction(){
        session_start();
        if($_GET['action'] == "out"){
            Auth::out();
        } 
        if(isset($_POST['log_in'])){ 
            $authErrors = Auth::enter();
            if (count($authErrors) == 0){   
                $UID = $_SESSION['id'];
                header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index");
                echo $UID;
            }
            if($authErrors){
                $data['errors'] = $authErrors;
                $model = new ImageModel();
                $data['images'] = $model->get();
                $data['mostView'] = $model->getMostView();
                View::render(["page_view" => "default", "layout" => "default", "data" => $data]);
            }
        }
    }
    
    public function addImageAction(){
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
        die();
    }

    public function itemImageAction(){
            $data = [];
            $imageModel = new ImageModel();
            $result = $imageModel->getOneImage($_GET["imageId"]);
            $data['image'] = $result[0];
            if(Auth::login()){
                $UID = $_SESSION['id'];
                $collectionModel = new CollectionModel();
                $result = $collectionModel->getAllUserCollection($UID);
                $data['collection'] = $result;
            }
            View::render(["page_view" => "item", "layout" => "default", "data" => $data]);
            $imageModel->increseViewCount($_GET["imageId"]);
    }

    public function addInCollectionAction(){
        Auth::login();
        $UID = $_SESSION['id'];
        $model = new ImageModel();
        $addErrors = [];
        if (!$_POST['collectionId']){
            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/itemImage&imageId=".$_GET['imageId']);
            die();
        }
        $checkResult = $model->addInCollection($_GET['imageId'], $_POST['collectionId'], $UID);
        if ($checkResult){
            $addErrors['exist'] = $checkResult;
            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/itemImage&imageId=".$_GET['imageId']."&status=".json_encode([$addErrors]));
            die();
        }
        $model->addInCollection($_GET['imageId'], $_POST['collectionId'], $UID);
        header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index");
        die();
    }

    public function personalPageAction(){
        if(!Auth::login()){
            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index");
            die();
        }
        $UID = $_SESSION['id'];
        $model = new CollectionModel();
        $data = $model->getAllUserCollection($UID);
        View::render(["page_view" => "collection", "layout" => "default", "data" => $data]);
        
    }

    public function collectionAction(){
        $data = [];
        Auth::login();
        $UID = $_SESSION['id'];
        if(isset($_GET['collectionId'])){
            $imageModel = new ImageModel();
            $collectionModel = new CollectionModel();
            $data['images'] = $imageModel->getCollectionImage($UID, $_GET['collectionId']);
            $data['currentCollection'] = $collectionModel->getOneCollection($_GET['collectionId']);
            $data['collectionList'] = $collectionModel->getCollection($UID,  $_GET['collectionId']);
            $data['collectionThree'] = $collectionModel->getChildrenCollection($_GET['collectionId']);
            View::render(["page_view" => "collectionItem", "layout" => "default", "data" => $data]);
        }
        else{
            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index");
            die();
        }
        
    }

    public function deleteImageAction(){
        Auth::login();
        $UID = $_SESSION['id'];
        $model = new ImageModel();
        $result = $model->getCollectionImage($UID, $_GET['collectionId']);
        if(count($result) != 0){
            $model->deleteImage($_GET['imageId'],$_GET['collectionId']);
            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/collection&collectionId=".$_GET['collectionId']);
        }            
    }

    public function createCollectionAction(){
        $model = new CollectionModel;
        if(Auth::login()){
            $UID = $_SESSION['id'];
            if(isset($_GET['collectionId'])){
                $model->createCollection($UID, $_POST["collection_name"], $_GET['collectionId']);
                header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/collection&collectionId=".$_GET['collectionId']."");
                die();
            }
            if(!isset($_GET['collectionId'])){
                $model->createCollection($UID, $_POST["collection_name"]);
                header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/personalPage");
                die();
            } 
        }
        header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index");
        die();     
    }

    public function deleteCollectionAction(){
        if(Auth::login()){
            $imageModel = new ImageModel();
            $collectionModel = new CollectionModel();
            $childCollectionArray = $collectionModel->getChildCollection($_GET['collectionId']);
            foreach ($childCollectionArray as $collection){
                $imageModel->deleteCollectionImage($collection['id']);
            }
            $collectionModel->deleteCollection($_GET['collectionId']);
            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/personalPage");
            die();
        }
    }

    public function errorAction(){
        echo "Ошибка открытия страницы";
    }
}