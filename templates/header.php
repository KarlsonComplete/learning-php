<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Мой блог' ?></title>
    <link rel="stylesheet" href="/www/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">
            Мой блог
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">
            <?php if(!empty($user)){ echo 'Привет,' . $user->getNickname() . ' |' ?> <a href="/www/users/logout">Выйти</a><?php } ?>
            <?php if (empty($user)){?><a href="/www/users/authorization">Войти</a> | <a href="/www/users/register">Зарегистрироваться</a> <?php } ?>
        </td>
    </tr>
    <tr>
        <td>
