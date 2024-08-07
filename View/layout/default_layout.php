<?php
    if(Auth::login()){   
        $UID = $_SESSION['id'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/aos.css">
</head>
<body>
    <header>
        <div>
            <a href="?route=main/index">Главная страница</a>
            <?php if(!isset($UID)){?>
            <a href="?route=main/register">Зарегистрироватся</a>
            <?}
                    ?> 
            <div>
                <?php if(!isset($UID)){ ?>                
                <form class=auth  action="?route=main/auth&action=log_in" method="post">
                    <label for=""> Имя пользователя
                        <input type="text" name="login">
                    </label>
                    <label for=""> Пароль
                        <input type="password" name="password">
                    </label>
                    <input type="submit" name="log_in" value="Войти">
                    <p class =<?php echo (isset($data['errors']["auth_error"]) != false)? "error_msg": ""; ?>>
                    <?php
                        if(isset($data['errors']["auth_error"])){
                            echo $data['errors']["auth_error"];
                        }
                    ?></p>
                          
                </form>
                <?}?>
                <?php if(isset($UID)){?>
                <a href="/?route=main/personalPage"> Мои коллекции</a>
                <a href="/?route=main/auth&action=out">Выход</a>
                <?}?>
            </div> 
        </div>
    </header>
    <?php include "View/page/" . $params['page_view'];?> 
</body>
</html>

