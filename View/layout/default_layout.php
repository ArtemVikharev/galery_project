<?php if (Auth::login()){   
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
                    <p class =<?php echo (writeStatus("auth_error") != false)? "error_msg": ""; ?>>
                    <?php
                        if(writeStatus("auth_error")){
                            echo writeStatus("auth_error");
                        }
                    ?></p>
                          
                </form>
                <?}
                    ?>
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


<?php
function writeStatus($nameField){
	if(isset($_GET['status'])){

		$data = $_GET['status'];

		$data = json_decode($data);

		$error = (array)$data[0];
		
		if(isset($error[$nameField])){
			return $error[$nameField];
		}
	}
    
	return false;
}

function setValue($nameField){
    if(isset($_GET['status'])){

        $data = $_GET['status'];

        $data = json_decode($data);

        $value = (array)$data[1];
        
        if(isset($value[$nameField])){
            return $value[$nameField];
        }
    }
    return false;
}
?>