    <?php if (!empty($works)) : ?>
        <?php foreach ($works as $work) : ?>
            <div class="work_item">
                <img src="/images/works/<?= $work['photoName'] ?>" alt="паспорт фасадов"
                     class="lastWork_img">
                <p class="work_item_title"><?= $work['title'] ?></p>
                <p class="work_item_date">Выдано: <?= $work['timeCreate'] ?></p>
<!--                <p class="work_item_date">id: --><?//= $work['id'] ?><!--</p>-->
<!--                <p class="work_item_date">categoryId: --><?//= $work['category_id'] ?><!--</p>-->
            </div>
        <?php endforeach;
    endif; ?>
