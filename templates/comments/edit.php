<?php include __DIR__ . '/../header.php'; ?>
<h3>Редактор комментария</h3>
<?php if (!empty($error)) : ?>
    <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
<?php endif; ?>
<form action="/www/comments/<?= $comments->getId() ?>/edit" method="post">
        <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a comment here" name="comments"
                      style="height: 100px"><?= $comments->getComments()?></textarea>
            <label for="comments">Комментарии</label>
        </div>
        <hr class="my-4">
        <input class="w-100 btn btn-primary btn-lg" type="submit" value="Отправить">
</form>
<?php include __DIR__ . '/../footer.php'; ?>