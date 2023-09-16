<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use Myproject\Models\Users\UsersAuthService;
use Myproject\View\View;

class MainController extends AbstractController
{
    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', ['articles' => $articles, 'title' => 'Мой блог', 'user' => UsersAuthService::getUserByToken()]);
    }

    public function sayHello(string $name)
    {
        $this->view->renderHtml('main/hello.php', ['name' => $name, 'title' => 'Страница приветствия']);
    }

    public function sayBye(string $name)
    {
        echo 'Пока ' . $name;
    }

}