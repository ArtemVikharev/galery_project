<div>
    <h2 class="register_title">Форма регистрации</h2>
    <form class="register_form" action="?route=main/registerform" method="post">
        <label for=""> Введите Имя
            <input type="text" name="user_firstname" value=<?php echo (isset($data['userData']["user_firstname"]) != false)? $data['userData']["user_firstname"]: ""; ?>>
        </label>
            <p class =<?php echo (isset($data['errors']["user_firstname"]) != false)? "error_msg": ""; ?>>
            <?php
                if(isset($data['errors']["user_firstname"])){
                    echo $data['errors']["user_firstname"];
                }
            ?></p>
        <label for=""> Введите Фамилию
            <input type="text" name="user_surname" value=<?php echo (isset($data['userData']["user_surname"]) != false)? $data['userData']["user_surname"]: ""; ?>>
        </label>
        <p class =<?php echo (isset($data['errors']["user_surname"]) != false)? "error_msg": ""; ?>>
        <?php
            if(isset($data['errors']["user_surname"])){
                echo $data['errors']["user_surname"];
            }
        ?></p>
        <label for=""> Введите Username
            <input type="text" name="user_username" value=<?php echo (isset($data['userData']["user_username"]) != false)? $data['userData']["user_username"]: ""; ?>>
        </label>
        <p class =<?php echo (isset($data['errors']["user_username"]) != false)? "error_msg": ""; ?>>
        <?php
            if(isset($data['errors']["user_username"])){
                echo $data['errors']["user_username"];
            }
        ?></p>
        <label for=""> Email
            <input type="text" name="user_email" value=<?php echo (isset($data['userData']["user_email"]) != false)? $data['userData']["user_email"]: ""; ?>>
        </label>    
        <p class =<?php echo (isset($data['errors']["user_email"]) != false)? "error_msg": ""; ?>>
        <?php
            if(isset($data['errors']["user_email"])){
                echo $data['errors']["user_email"];
            }
        ?></p>
        <label for=""> Введите Пароль
            <input type="password" name="user_password">
        </label>    
        <p class =<?php echo (isset($data['errors']["user_password"]) != false)? "error_msg": ""; ?>>
        <?php
            if(isset($data['errors']["user_password"])){
                echo $data['errors']["user_password"];
            }
        ?></p>
        <label for=""> Подтвердите пароль
            <input type="password" name="user_repassword">
        </label>
        <p class =<?php echo (isset($data['errors']["user_repassword"]) != false)? "error_msg": ""; ?>>
        <?php
            if(isset($data['errors']["user_repassword"])){
                echo $data['errors']["user_repassword"];
            }
        ?></p>
        <button>Зарегистрироваться</button>
    </form>