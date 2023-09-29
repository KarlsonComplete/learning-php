<?php include __DIR__ . '/../header.php'; ?>

<?php if(empty($user->getImgName())){ ?>
    <div class="col-auto d-none d-lg-block">

        <img class="bd-placeholder-img" width="200" height="250">
    </div>
    <form enctype="multipart/form-data" action="/www/users/account" method="post" >
        Выберите файл для загрузки вашего фото фотографии:
        <input type="file" name="userfile">
        <input type="submit" value="Загрузить">
    </form>
    <hr>
<?php }else{ ?>

    <img class="bd-placeholder-img" src="/src/img/<?php echo $user->getImgName(); ?>" width="200" height="250">

    <form enctype="multipart/form-data" action="/www/users/account" method="post" >
        Выберите файл для загрузки вашего фото фотографии:
        <input type="file" name="userfile">
        <input type="submit" value="Загрузить">
    </form>
<?php }?>
<?= include __DIR__ . '/../footer.php' ?>