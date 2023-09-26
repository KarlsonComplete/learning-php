<?php include __DIR__ . '/../header.php' ?>
<?php foreach ($articles as $article): ?>
    <h2><a href="/www/articles/<?= $article->getId() ?>"><?= $article->getName() ?></a></h2>
    <p><?= $article->getShortText() ?></p>
    <?php if (!empty($user) && $user->isAdmin()){ ?>
    <a href="/www/articles/<?= $article->getId() ?>/edit">Редактировать статью</a>
    <?php }?>
    <hr>
<?php endforeach; ?>
<?php include __DIR__ . '/../footer.php' ?>