
<?php $collectionDropList = CollectionThree::showDropCollection($data['collection'], "");?>
<div class="image_item">
    <img src="<?php echo $data['image']['path']?>" alt="">
</div>
<?php if(isset($UID)){?>
<div class="btn_control">
    <form class="add_btn" method="POST" action="?route=main/addInCollection&imageId=<?echo $data['image']['id']?>">
        <label for="">Выберите коллекцию:
            <? echo '<select name="collectionId"><option selected="true" disabled="disabled">Выбери '. $collectionDropList .'</select>';?>
        </label>
        
        <button>Добавить в коллекцию</button>
        <p class =<?php echo (isset($data['addErrors']["exist"]) != false)? "error_msg": ""; ?>>
                        <?php
                            if (isset($data['addErrors']["exist"])){
                                echo $data['addErrors']["exist"];
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
