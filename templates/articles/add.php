<?php include __DIR__ . '/../header.php'; ?>
    <main>
        <h1>Cоздание новой статьи</h1>
        <?php if (!empty($error)) : ?>
            <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
        <?php endif; ?>
        <form class="needs-validation" action="/www/articles/create" method="post">
            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="" value="<?= $_POST['name'] ?? '' ?>">
                </div>

                <div class="col-12">
                    <label for="text" class="form-label">Text <span class="text-body-secondary"></span></label>
                    <input type="text" class="form-control" name="text"  placeholder="" value="<?= $_POST['text'] ?? '' ?>">
                </div>

                <hr class="my-4">

                <input class="w-100 btn btn-primary btn-lg" type="submit" value="Create">
        </form>
    </main>
<?php include __DIR__ . '/../footer.php'; ?>