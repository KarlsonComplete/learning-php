<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use Myproject\View\View;
use Myproject\Services\Db;

class MainController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('main/main.php', ['articles' => $articles, 'title' => 'Мой блог']);
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