<?php require_once "Helper/CollectionThree.php";?>
<?php $collectionDropList = CollectionThree::showDropCollection($data[1], "");?>
<div class="image_item">
    <img src="<?php echo $data[0][0]['path']?>" alt="">
</div>
<?php if(isset($UID)){?>
<div class="btn_control">
    <form class="add_btn" method="POST" action="?route=main/addInCollection&imageId=<?echo $data[0][0]['id']?>">
        <label for="">Выберите коллекцию:
            <? echo '<select name="collectionId"><option value="">Выбери '. $collectionDropList .'</select>';?>
        </label>
        
        <button>Добавить в коллекцию</button>
        <p class =<?php echo (writeStatus("exist") != false)? "error_msg": ""; ?>>
                        <?php
                            if(writeStatus("exist")){
                                echo writeStatus("exist");
                            }
                        ?></p>
    </form>
    <?if (isset($_GET['collectionId'])){?>
    <form 
        class="delete_btn" 
        method="POST" 
        action=<?php echo "?route=main/deleteImage&collectionId=".$_GET['collectionId']."&imageId=".$_GET['imageId'];?>
        >
        <button>Удалить из коллекции</button>
    </form>
    <?}?>    
</div>
<?}?> 

<?
