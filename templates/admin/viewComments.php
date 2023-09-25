<?php include __DIR__ . '/../header.php'; ?>
<?php foreach ($comments as $comment) { ?>
    <p><?= $comment->getComments() ?></p>
    <?php if ((!empty($user)) && $user->isAdmin()){?>
        <p><a class="link-offset-1" href="/www/comments/<?php echo $comment->getId() ?>/edit">Редактировать комментарий</a></p>
    <?php } ?>
<?php } ?>
<?php include __DIR__ . '/../footer.php'; ?>