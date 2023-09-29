<?php

return [
    '~^hello/(.*)$~' => [\MyProject\Controllers\MainController::class, 'sayHello'],
    '~^bye/(.*)$~' => [\MyProject\Controllers\MainController::class, 'sayBye'],
    '~^$~' => [\MyProject\Controllers\MainController::class, 'main'],
    '~^articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'],
    '~^articles/create$~' => [\MyProject\Controllers\ArticlesController::class , 'create'],
    '~^articles/(\d+)/delete$~' => [\MyProject\Controllers\ArticlesController::class, 'delete'],
    '~^users/register$~' => [\MyProject\Controllers\UsersController::class, 'signUp'],
    '~^users/account$~' => [\MyProject\Controllers\UsersController::class, 'account'],
    '~^users/(\d+)/activate/(.+)$~' => [\MyProject\Controllers\UsersController::class, 'activate'],
    '~^users/authorization$~' => [\MyProject\Controllers\UsersController::class, 'login'],
    '~^users/logout$~' => [\MyProject\Controllers\UsersController::class, 'logOut'],
    '~^articles/(\d+)/comments$~' =>  [\MyProject\Controllers\ArticlesController::class, 'comment'],
    '~^comments/(\d+)/edit$~' => [\MyProject\Controllers\CommentsController::class, 'edit'],
    '~^admin$~' => [\MyProject\Controllers\AdminController::class, 'viewAdmin'],
    '~^admin/articles$~' => [\MyProject\Controllers\AdminController::class, 'viewArticles'],
    '~^admin/comments$~' => [\MyProject\Controllers\AdminController::class, 'viewComments'],
    ];