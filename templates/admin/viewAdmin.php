<?php include __DIR__ . '/../header.php'; ?>

<?php if (!empty($error)) : ?>
    <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
<?php endif; ?>

    <p><a href="/www/admin/articles">Список статей</a></p>

    <p><a href="/www/admin/comments">Комментарии</a></p>

<?php include __DIR__ . '/../footer.php'; ?>