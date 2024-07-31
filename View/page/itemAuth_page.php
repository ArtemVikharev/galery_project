<div class="image_item">
    <img src="<?php echo $data[0][0]['path']?>" alt="">
</div>
<div class="btn_control">
    <form class="add_btn" method="POST" action="?route=main/addInCollection&imageId=<?echo $data[0][0]['id']?>">
        <label for="">Выберите коллекцию:
            <select name="collectionId">
                <?php foreach ($data[1] as $item) : ?>
                    <option value="<? echo $item['id']?>"><?echo $item['name']?></option>
                <? endforeach;?>
            </select>
        </label>
        <button>Добавить в коллекцию</button>
    </form>    
</div>