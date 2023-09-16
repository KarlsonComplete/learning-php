<?php include __DIR__ . '/../header.php'; ?>
    <main>
        <h2>Authorization</h2>
        <?php if (!empty($error)) : ?>
            <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
        <?php endif; ?>
        <form class="needs-validation" action="/www/users/authorization" method="post">
            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="nickname" class="form-label">Nickname</label>
                    <input type="text" class="form-control" id="nickname" name="nickname" placeholder="nickname" value="<?= $_POST['nickname'] ?? '' ?>">
                </div>

                <div class="col-12">
                    <label for="password" class="form-label">Password <span class="text-body-secondary"></span></label>
                    <input type="password" class="form-control" name="password"  placeholder="" value="<?= $_POST['password'] ?? '' ?>">
                </div>

                <hr class="my-4">

                <input class="w-100 btn btn-primary btn-lg" type="submit" value="Sing Up">
        </form>
    </main>
<?= include __DIR__ . '/../footer.php'; ?>