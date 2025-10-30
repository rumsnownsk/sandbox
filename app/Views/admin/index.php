<!-- страница админки -->
<div class="container">
    <div class="headContent">

        <div class="buttons">
            <div class="buttonsLeft">
                <a href="<?= base_url('/') ?>" class="btn btn-dark" style="margin-left: 20px;">Home Page</a>
            </div>

            <div class="buttonsRight">
                <a href="<?= base_url('/admin/sync') ?>" class="btn btn-warning" style="margin-left: 20px;">Common
                    Sync</a>
            </div>
        </div>

        <h1>Main Admin panel</h1>
    </div>
    <div class="mainContent">

        <div class="selectArea">
            <?php if (!empty($warehouses)): ?>
                <select id="select_wh" class="select-css">
                    <option value="" disabled selected hidden>select warehouse</option>
                    <?php foreach ($warehouses as $warehouse) : ?>
                        <option value='<?= $warehouse['id'] ?>'><?= $warehouse['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>

            <?php if (!empty($categories)): ?>
                <select id="select_categories" class="select-css">
                    <option value="" disabled selected hidden>select category</option>
                    <option value="0">- View all -</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value='<?= $category['id'] ?>'><?= $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>

        </div>

        <table id="tbody_products" class="table table-hover">
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
            <tbody></tbody>
        </table>


    </div>
</div>
