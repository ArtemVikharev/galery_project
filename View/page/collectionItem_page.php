
<div class="collection_title">
    <h3>Коллекциия "<?php echo $data['currentCollection'][0]['name'];?>"<h3>
</div>
<div class="add_collection_form">
    <form method="POST" action="?route=main/createCollection&collectionId=<?php echo $_GET['collectionId']?>">
        <label for="">Имя коллекции:
            <input type="text" name="collection_name">
        </label>
        <button>Создать коллекцию</button>
    </form>
</div>
<div class="delete_collection_form">
    <form method="POST" action="?route=main/deleteCollection&collectionId=<?php echo $_GET['collectionId']?>">
        <button>Удалить коллекцию</button>
        <p>*при идалении коллекции, удаляться все вложения.</p>
    </form>
</div>
<div class="collection_list">
    <?php foreach ($data['collectionList'] as $item) : ?>
        <a href="?route=main/collection&collectionId=<?echo $item['id'];?>">
            <p><? echo $item['name']?></p>
        </a>
    <?php endforeach; ?>
</div>
<div class="image_block">
    <?php foreach ($data['images'] as $item) : ?>
        <a href=<?php echo "?route=main/itemImage&collectionId=".$_GET['collectionId']."&imageId=".$item['image_id'].""?>>
            <img src=<?php echo $item['image_path']?> alt="">
        </a>   
    <?php endforeach; ?>
</div>

