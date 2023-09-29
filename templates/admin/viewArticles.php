<?php include __DIR__ . '/../header.php'; ?>
<?php foreach ($articles as $article) { ?>
    <h1><?= $article->getName() ?></h1>
    <p><?= $article->getShortText() ?></p>
    <p>Автор: <?= $article->getAuthor()->getNickname() ?></p>
    <?php if (!empty($user) && $user->isAdmin()) { ?><p><a class="link-offset-1"
                                                           href="/www/articles/<?= $article->getId() ?>
    /edit">Редактировать статью</a></p>
    <?php } ?>
<?php } ?>
<?php include __DIR__ . '/../footer.php'; ?>