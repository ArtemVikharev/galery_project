
<div>
    <h2>Главная страница</h2>
    <a href="?route=main/register">Зарегистрироватся</a>
    <div>
        <form class=auth>
            <label for=""> Имя пользователя
                <input type="text" name="username">
            </label>
            <label for=""> Пароль
                <input type="text" name="password">
            </label>
            <button>Войти</button>
        </form>  
    </div>
</div>
<div>
    <form class="image_list" method="POST" action="?route=main/addimage" enctype="multipart/form-data">
        <input type="file" name="userfile">
        <p class =<?php echo (writeStatus("existFile") != false)? "error_msg": ""; ?>>
        <?php
            if(writeStatus("existFile")){
                echo writeStatus("existFile");
            }
            
        ?></p>
        <p class =<?php echo (writeStatus("imageFormat") != false)? "error_msg": ""; ?>>
        <?php
            if(writeStatus("imageFormat")){
                echo writeStatus("imageFormat");
            }
            
        ?></p>
        <p class =<?php echo (writeStatus("imageSize") != false)? "error_msg": ""; ?>>
        <?php
            if(writeStatus("imageSize")){
                echo writeStatus("imageSize");
            }
            
        ?></p>        
        <button>Загрузить изображение</button>
    </form>
</div>
<div class="image_block">
    <?php foreach ($data as $item) : ?>
        <a href=<?php echo "?route=main/itemImage&id=".$item['id'].""?>>
            <img src=<?php echo $item['path']?> alt="">
        </a>
        
    <?php endforeach; ?>
</div>
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