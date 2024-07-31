<div class="image_block">
    <?php foreach ($data as $item) : ?>
        <a href=<?php echo "?route=main/itemImage&id=".$item['image_id'].""?>>
            <img src=<?php echo $item['image_path']?> alt="">
        </a>
        
    <?php endforeach; ?>
</div>