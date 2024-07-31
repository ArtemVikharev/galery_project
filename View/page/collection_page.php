<div class="page_title">
    <h2>Мои коллекции</h2>
</div>
<div class="add_collection_form">
    <form class="create_collection_form" method="POST" action="?route=main/createCollection">
        <label for="">Имя коллекции:
            <input type="text" name="collection_name">
        </label>
        <button>Создать коллекцию</button>
    </form>
</div>
<div class="collection_list">
    <?php foreach ($data as $item) : ?>
        <a href="?route=main/collection&id=<?echo $item['id'];?>">
            <p><? echo $item['name']?></p>
        </a>
    <?php endforeach; ?>
</div>