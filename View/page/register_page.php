<div>
    <a href="?route=main/index">Главная страница</a>
</div>
<div>
    <h2 class="register_title">Форма регистрации</h2>
    <form class="register_form" action="?route=main/registerform" method="post">
        <label for=""> Введите Имя
            <input type="text" name="user_firstname" value=<?php echo (setValue("user_firstname") != false)? setValue("user_firstname"): ""; ?>>
        </label>
            <p class =<?php echo (writeStatus("user_firstname") != false)? "error_msg": ""; ?>>
            <?php
                if(writeStatus("user_firstname")){
                    echo writeStatus("user_firstname");
                }
            ?></p>
        <label for=""> Введите Фамилию
            <input type="text" name="user_surname" value=<?php echo (setValue("user_surname") != false)? setValue("user_surname"): ""; ?>>
        </label>
        <p class =<?php echo (writeStatus("user_surname") != false)? "error_msg": ""; ?>>
        <?php
            if(writeStatus("user_surname")){
                echo writeStatus("user_surname");
            }
        ?></p>
        <label for=""> Введите Username
            <input type="text" name="user_username" value=<?php echo (setValue("user_username") != false)? setValue("user_username"): ""; ?>>
        </label>
        <p class =<?php echo (writeStatus("user_username") != false)? "error_msg": ""; ?>>
        <?php
            if(writeStatus("user_username")){
                echo writeStatus("user_username");
            }
        ?></p>
        <label for=""> Email
            <input type="text" name="user_email" value=<?php echo (setValue("user_email") != false)? setValue("user_email"): ""; ?>>
        </label>    
        <p class =<?php echo (writeStatus("user_email") != false)? "error_msg": ""; ?>>
        <?php
            if(writeStatus("user_email")){
                echo writeStatus("user_email");
            }
        ?></p>
        <label for=""> Введите Пароль
            <input type="password" name="user_password">
        </label>    
        <p class =<?php echo (writeStatus("user_password") != false)? "error_msg": ""; ?>>
        <?php
            if(writeStatus("user_password")){
                echo writeStatus("user_password");
            }
        ?></p>
        <label for=""> Подтвердите пароль
            <input type="password" name="user_repassword">
        </label>
        <p class =<?php echo (writeStatus("user_repassword") != false)? "error_msg": ""; ?>>
        <?php
            if(writeStatus("user_repassword")){
                echo writeStatus("user_repassword");
            }
        ?></p>
        <button>Зарегистрироваться</button>
    </form>