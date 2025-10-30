<?php if (!empty($products)): ?>
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
<?php endif; ?>

