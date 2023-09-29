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

<?php } else { ?>
    <p>Для добавления комментариев, пожалуйста,
        <a href="/www/users/authorization">авторизуйтесь</a> или
        <a href="/www/users/register">зарегистрируйтесь</a></p>
<?php } ?>

<?php if (!empty($comments)) { ?>
    <hr class="my-4">
    <h3>Комментарии</h3>
    <hr class="my-4">
    <?php foreach ($comments as $comment) {
        ?>
        <div id="comment<?php echo $comment->getId() ?>" class="media d-block d-md-flex mt-1 font09">
            <div class="media-body text-md-left ml-md-2 ml-0">
                <div class="mb-0 mt-0 font-weight-bold font08">
                    <img src="/src/img/<?php echo $comment->getAuthor()->getImgName();?>" width="50" height="50" alt="">
                    <a href=""><?php echo $comment->getAuthor()->getNickname() ?></a>
                    <span style="font-weight: 100;"
                          class="ml-2 hideOnMobile font07"><?php echo $comment->getCreatedAt() ?></span>
                </div>
                <div id="Comment<?php echo $comment->getId() ?>Text"><p><?php echo $comment->getComments() ?></p></div>
               <?php if ((!empty($user)) && ($user->getNickname() === $comment->getAuthor()->getNickname() || $user->isAdmin())){?>
                    <p><a class="link-offset-1" href="/www/comments/<?php echo $comment->getId() ?>/edit">Редактировать комментарий</a></p>
                <?php } ?>
            </div>
        </div>
        <hr class="my-4">
    <?php } ?>
<?php } ?>
<?php include __DIR__ . '/../footer.php'; ?>