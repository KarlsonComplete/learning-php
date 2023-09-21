<?php include __DIR__ . '/../header.php'; ?>
    <h1><?= $article->getName() ?></h1>
    <p><?= $article->getText() ?></p>
    <p>Автор: <?= $article->getAuthor()->getNickname() ?></p>
<?php if (!empty($user) && $user->isAdmin()) { ?>
    <p><a class="link-offset-1" href="/www/articles/<?= $article->getId() ?>
    /edit">Редактировать статью</a></p>
<?php } ?>
<?php if (!empty($user)) { ?>
    <form action="/www/articles/<?= $article->getId() ?>/comments" method="post">
        <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a comment here" name="comments"
                      style="height: 100px"></textarea>
            <label for="comments">Комментарии</label>
        </div>
        <hr class="my-4">
        <input class="w-100 btn btn-primary btn-lg" type="submit" value="Отправить">
    </form>
<?php } ?>
<?php include __DIR__ . '/../footer.php'; ?>