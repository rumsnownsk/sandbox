<div class="container">
    <div class="headContent">
        <div class="buttons">
            <div class="buttonsLeft">
                <a href="<?= base_url('/admin') ?>"
                   class="btn btn-dark"
                >Admin Panel</a>
            </div>
            <div class="buttonsRight">
                <button class="btn btn-info"
                        id="sync"
                >sync</button>
            </div>
        </div>
        <h1 style="text-align:center;">Товары из МойСклад (api)</h1>
    </div>
    <?php if (!empty($products)): ?>
        <table class="table table-hover">
            <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Фото</th>
                <th scope="col">ID</th>
                <th scope="col">Название</th>
                <th scope="col">Категория</th>
                <th scope="col">Описание</th>
                <th scope="col">Артикул</th>
                <th scope="col">Цена, &#8381;</th>
                <th scope="col">Остаток</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product) : ?>
                <tr data-id="<?= $product['id'] ?>">
                    <td class="">
                        <input type="checkbox" name="" value="0">
                    </td>
                    <td class="">
                        <img src="<?= $product['image_path'] ?>" alt="">
                    </td>
                    <td class="" style="font-size: 75%;"><?= $product['id'] ?></td>
                    <td class=""><?= $product['name'] ?></td>
                    <td class=""><?= $product['category'] ?></td>
                    <td class=""><?= $product['description'] ?></td>
                    <td class=""><?= $product['article'] ?></td>
                    <td class=""><?= $product['price'] ?></td>
                    <td class=""><?= $product['available'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Нет товаров в базе Мой Склад</p>
    <?php endif; ?>
</div>