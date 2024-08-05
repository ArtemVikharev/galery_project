
<div>
    <h2>Главная страница</h2>
</div>
<div>
    <form class="image_list" method="POST" action="?route=main/addImage" enctype="multipart/form-data">
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
        <button>Опубликовать изображение</button>
    </form>
</div>
<div class="image_block">
    <?php foreach ($data as $item) : ?>
        <a href=<?php echo "?route=main/itemImage&imageId=".$item['id'].""?>>
            <img src=<?php echo $item['path']?> alt="">
        </a> 
    <?php endforeach; ?>
</div>
