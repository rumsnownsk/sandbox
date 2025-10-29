<ul class="menu">
    <li class="menu__item"><a href="<?= base_url('/') ?>">главная</a></li>
    <li class="menu__item"><a href="<?= base_url('/law') ?>">закон</a></li>
    <li class="menu__item"><a href="<?= base_url('/works') ?>">готовые паспорта</a></li>
    <li class="menu__item"><a href="<?= base_url('/procedure') ?>">порядок получения паспорта</a></li>
    <li class="menu__item"><a href="<?= base_url('/service') ?>">дополнительные услуги</a></li>
    <li class="menu__item"><a href="<?= base_url('/contacts') ?>">контакты</a></li>
    <?php if (\PHPFrw\Auth::isAuth()): ?>
    <li class="menu__item"><a class="admin_button" href="<?= base_url('/admin') ?>">Админка</a></li>
    <?php endif; ?>
</ul>
