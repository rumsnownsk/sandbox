<!-- страница админки -->
<div class="container">
    <div class="headContent">

        <div class="buttons">
            <div class="buttonsLeft">
                <a href="<?= base_url('/') ?>" class="btn btn-dark" style="margin-left: 20px;">Home Page</a>
            </div>

            <div class="buttonsRight">
                <a href="<?= base_url('/admin/sync') ?>" class="btn btn-warning" style="margin-left: 20px;">Common Sync</a>
            </div>
        </div>

        <h1>Main Admin panel</h1>
    </div>
    <div class="mainContent">

        <select class="select-css">
            <option value="" disabled selected hidden>This is a native select element</option>
            <option>Apples</option>
            <option>Bananas</option>
            <option>Grapes</option>
            <option>Oranges</option>
        </select>

    </div>
</div>
