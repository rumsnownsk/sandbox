<div class="container">
    <div class="headContent">
        <h1>Main page with products</h1>
        <div class="buttons">
            <a href="<?= base_url('/admin') ?>"
               class="btn btn-dark"
               style="margin-left: 20px;">admin page</a>
        </div>

    </div>
    <div class="productsList">
        <?php if (!empty($products)) : ?>
            <?php foreach ($products as $product) : ?>
                <div class="product_item">
                    <img src="<?= base_url($product['img_path']) ?>" alt=""
                         class="">
                    <p class="product_item_title"><?= $product['name'] ?></p>
                    <p class="product_item_desc"><?= $product['description'] ?></p>
                    <p class="product_item_desc"><b>Категория:</b> <?= $product['category'] ?></p>
                    <p class="product_item_desc"><b>Цена:</b> <?= $product['price'] ?></p>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Нет товаров в базе MySql</p>
        <?php endif; ?>
    </div>
</div>
