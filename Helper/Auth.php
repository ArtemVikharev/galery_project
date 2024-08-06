<?php

class Auth{
    public static function enter (){
        $db = new DB();
        $error = [];
        if (!empty($_POST['login']) && !empty($_POST['password'])){       
            $login = $_POST['login']; 
            $password = $_POST['password'];

            $queryResult = $db-> query("SELECT * FROM user WHERE username='".$login."'");
            if (count($queryResult) == 1){
                $result = $queryResult[0];

                if (password_verify($password, $result['password'])){
                    setcookie ("login", $result['username'], time() + 360000);                         
                    setcookie ("hash", md5($result['username'].$result['fistname'].$result['email']), time() + 360000);                    
                    $_SESSION['id'] = $result['id'];  
                    $id = $_SESSION['id'];                   
                return $error;          
                }           
                else{               
                    $error["auth_error"] = "Неверный пароль";                                       
                    return $error;          
                }       
            }       
            else{           
                $error["auth_error"] = "Неверный логин и пароль";           
                return $error;      
            }   
        }
        else{       
            $error["auth_error"] = "Поля не должны быть пустыми!";            
            return $error;  
        }
        
    }

    public static function login() {
        $db = new DB();  
        session_start();    
        if (isset($_SESSION['id'])){                   
            if(isset($_COOKIE['login']) && isset($_COOKIE['password'])){
                SetCookie("login", "", time() - 1, '/');
                SetCookie("hash","", time() - 1, '/');          
                setcookie ("login", $_COOKIE['login'], time() + 50000, '/');            
                setcookie ("hash", $_COOKIE['hash'], time() + 50000, '/');          
                $id = $_SESSION['id'];                   
                return true;
            }              
            else{
                $queryResult = $db->query("SELECT * FROM user WHERE id='".$_SESSION['id']."'");
                $result = $queryResult[0];             
                if (count($queryResult) == 1){    
                    setcookie ("login", $result['username'], time()+50000, '/');              
                    setcookie ("hash", md5($result['username'].$result['fistname'].$result['email']), time() + 50000, '/'); 
                    $id = $_SESSION['id'];
                    return true;            
                    }
                else{
                    return false;      
                    }
                }
            }    
            else{
                if(isset($_COOKIE['login']) && isset($_COOKIE['password'])){               
                    $queryResult = $db->query("SELECT * FROM user WHERE username='".$_COOKIE['login']."'");
                    $result = $queryResult[0];

                    if(count($queryResult) == 1 && md5($result['username'].$result['fistname'].$result['email']) == $_COOKIE['hash']){ 
                    $_SESSION['id'] = $result['id'];         
                    $id = $_SESSION['id'];              
             
                return true;            
                }           
            else{         
                SetCookie("login", "", time() - 360000, '/');               
                SetCookie("hash", "", time() - 360000, '/');                    
                return false;           
                }   
            }       
            else{         
                return false;       
            }   
        } 
    }

    public static function out(){
        $db = new DB();  
        session_start();    
        $id = $_SESSION['id'];              
     
        unset($_SESSION['id']);  
        SetCookie("login", "");   
        SetCookie("hash", "");    
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
    }
}   