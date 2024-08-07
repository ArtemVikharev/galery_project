<div class="image_item">
    <img src="<?php echo $data['image']['path']?>" alt="">
</div>
<div class="btn_control">
    <form class="add_btn" method="POST" action="?route=main/addInCollection&imageId=<?echo $data['image']['id']?>">
        <label for="">Выберите коллекцию:
            <select name="collectionId">
                <?php foreach ($data[1] as $item) : ?>
                    <option value="<? echo $item['id']?>"><?echo $item['name']?></option>
                <? endforeach;?>
            </select>
        </label>
        <button>Добавить в коллекцию</button>
    </form>
    <form 
        class="delete_btn" 
        method="POST" 
        action=<?php echo "?route=main/deleteImage&collectionId=".$_GET['collectionId']."&imageId=".$_GET['imageId'];?>
        >
        <button>Удалить из коллекции</button>
    </form>  
</div>