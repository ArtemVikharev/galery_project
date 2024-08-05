<?php
require_once "Model/UserModel.php";
require_once "Model/ImageModel.php";
require_once "Model/CollectionModel.php";
require_once "View/View.php";
require_once "Helper/Auth.php";

class MainController{

    public function indexAction(){
        $model = new ImageModel();
        $allImage = $model->get();
        $mostViewImage = $model->getMostView();
        $data = [$mostViewImage, $allImage];
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
    }

    public function itemImageAction(){
            $imageModel = new ImageModel();
            $image = $imageModel->getOneImage($_GET["imageId"]);
            if(Auth::login()){
                $UID = $_SESSION['id'];
                $collectionModel = new CollectionModel();
                $collection = $collectionModel->getAllUserCollection($UID);
                $data = [$image, $collection];
            }
            if(!Auth::login()){
                $data = [$image];
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
        }
        $checkResult = $model->addInCollection($_GET['imageId'], $_POST['collectionId'], $UID);
        if ($checkResult){
            $addErrors['exist'] = $checkResult;
            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/itemImage&imageId=".$_GET['imageId']."&status=".json_encode([$addErrors]));
            die();
        }
        $model->addInCollection($_GET['imageId'], $_POST['collectionId'], $UID);
        header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index");
    }

    public function personalPageAction(){
        if(!Auth::login()){
            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index");
        }
        $UID = $_SESSION['id'];
        $model = new CollectionModel();
        $data = $model->getAllUserCollection($UID);
        View::render(["page_view" => "collection", "layout" => "default", "data" => $data]);
        
    }

    public function collectionAction(){
        Auth::login();
        $UID = $_SESSION['id'];
        if(isset($_GET['collectionId'])){
            $imageModel = new ImageModel();
            $collectionModel = new CollectionModel();
            $imageData = $imageModel->getCollectionImage($UID, $_GET['collectionId']);
            $currentCollectionData = $collectionModel->getOneCollection($_GET['collectionId']);
            $colectionList = $collectionModel->getCollection($UID,  $_GET['collectionId']);
            $collectionThree = $collectionModel->getChildrenCollection($_GET['collectionId']);
            $data = [$currentCollectionData[0]['name'],$colectionList, $imageData, $collectionThree];
            View::render(["page_view" => "collectionItem", "layout" => "default", "data" => $data]);
        }
        else{
            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index"); 
        }
        
    }

    public function deleteImageAction(){
        Auth::login();
        $UID = $_SESSION['id'];
        $model = new ImageModel();
        $result = $model->getCollectionImage($UID, $_GET['collectionId']);
        if(count($result) != 0)
            $model->deleteCollectionImage($_GET['imageId'],$_GET['collectionId']);
            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/collection&collectionId=".$_GET['collectionId']);
    }

    public function createCollectionAction(){
        if(Auth::login()){
            $UID = $_SESSION['id'];
            if(isset($_GET['collectionId'])){
                CollectionModel::createCollection($UID, $_POST["collection_name"], $_GET['collectionId']);
                header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/collection&collectionId=".$_GET['collectionId']."");
                
            }
            if(!isset($_GET['collectionId'])){
                CollectionModel::createCollection($UID, $_POST["collection_name"]);
                header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/personalPage");
            } 
        }
        else{
            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/index");  
        }      
    }

    public function deleteCollectionAction(){
        if(Auth::login()){
            $collectionModel = new CollectionModel();
            $collectionModel->deleteCollection($_GET['collectionId']);
            sleep(1);
            header("location: http://" . $_SERVER["SERVER_NAME"] . "" . $_SERVER["SCRIPT_NAME"] . "?route=main/personalPage");
        }
    }

    public function errorAction(){
        echo "Ошибка открытия страницы";
    }
}