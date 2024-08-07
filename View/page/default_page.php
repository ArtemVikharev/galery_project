<?php 
    if(Auth::login()){   
        $UID = $_SESSION['id'];
    }
?>
<div>
    <h2>Главная страница</h2>
</div>
<div class="most_view">
    <?php foreach ($data['mostView'] as $item) : ?>
    <div class="most_view_item">
        <a href=<?php echo "?route=main/itemImage&imageId=".$item['id'].""?>>
            <img src=<?php echo $item['path']?> alt="">
        </a> 
        <p>Количество просмотров:<?echo $item['view_count']?></p>
    </div>
    <?php endforeach; ?>
</div>
<div>
    <form class="image_list" method="POST" action="?route=main/addImage" enctype="multipart/form-data">
        <input type="file" name="userfile">
        <p class =<?php echo (isset($data["errors"]["existFile"]) != false)? "error_msg": ""; ?>>
        <?php
            if(isset($data["errors"]["existFile"])){
                echo $data["errors"]["existFile"];
            }
            
        ?></p>
        <p class =<?php echo (isset($data["errors"]["imageFormat"]) != false)? "error_msg": ""; ?>>
        <?php
            if(isset($data["errors"]["imageFormat"])){
                echo $data["errors"]["imageFormat"];
            }
            
        ?></p>
        <p class =<?php echo (isset($data["errors"]["imageSize"]) != false)? "error_msg": ""; ?>>
        <?php
            if(isset($data["errors"]["imageSize"])){
                echo $data["errors"]["imageSize"];
            }
            
        ?></p>        
        <button>Опубликовать изображение</button>
    </form>
</div>
<div class="image_block">
    <?php foreach ($data['images'] as $item): ?>
        <a href=<?php echo "?route=main/itemImage&imageId=".$item['id'].""?>>
            <img src=<?php echo $item['path']?> alt="">
        </a> 
    <?php endforeach; ?>
</div>
