<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Main</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="<?= base_url('/assets/css/main.css') ?>" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
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
                    <img src="" alt=""
                         class="">
                    <p class="product_item_title"><?= $product['name'] ?></p>
                    <p class="product_item_title"><?= $product['name'] ?></p>
                    <p class="product_item_desc"><?= $product['description'] ?></p>
                    <p class="product_item_desc">категория: <?= $product['category_id'] ?></p>
                    <p class="product_item_desc">цена: <?= $product['price'] ?></p>
                    <!--                <p class="work_item_date">id: --><? //= $work['id'] ?><!--</p>-->
                    <!--                <p class="work_item_date">categoryId: -->
                    <? //= $work['category_id'] ?><!--</p>-->
                </div>
            <?php endforeach;
        endif; ?>
    </div>


</div>

</body>
</html>
