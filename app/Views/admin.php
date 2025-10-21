<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="<?= base_url('/assets/css/main.css') ?>" rel="stylesheet"  crossorigin="anonymous">
</head>
<body>

<div class="container">
    <div class="headContent">
        <h1 style="text-align:center;">Товары из МойСклад (api)</h1>
        <div class="buttons">
            <button class="btn btn-info"
                    id="sync"
            >sync</button>
            <a href="<?= base_url('/') ?>"
               class="btn btn-dark"
               style="margin-left: 20px;">main page</a>
        </div>

    </div>
    <?php if (!empty($products)): ?>
        <table class="table table-hover">
            <thead class="table-dark">
            <tr>
                <th scope="col">Выбрать</th>
                <th scope="col">ID</th>
                <th scope="col">Название</th>
                <th scope="col">Category ID</th>
                <th scope="col">Описание</th>
                <th scope="col">Артикул</th>
                <th scope="col">Фото</th>
                <th scope="col">Цена</th>
                <th scope="col">Доступно</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product) : ?>
                <tr data-id="<?= $product['id'] ?>">
                    <td class="">
                        <input type="checkbox" name="" value="0">
                    </td>
                    <td class=""><?= $product['id'] ?></td>
                    <td class=""><?= $product['name'] ?></td>
                    <td class=""><?= $product['category_id'] ?></td>
                    <td class=""><?= $product['description'] ?></td>
                    <td class=""><?= $product['article'] ?></td>
                    <td class=""><?= $product['img_path'] ?></td>
                    <td class=""><?= $product['price'] ?></td>
                    <td class=""><?= $product['available'] ?></td>


                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Нет товаров на складе moysklad.ru</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->

<!--<script src="assets/js/mark.min.js"></script>-->
<!--<script src="assets/js/sweetalert2.all.min.js"></script>-->
<script src="<?= base_url('/assets/js/main.js') ?>"></script>

</body>
</html>