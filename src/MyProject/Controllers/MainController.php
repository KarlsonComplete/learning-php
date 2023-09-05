<?php

namespace MyProject\Controllers;

use Myproject\View\View;
use Myproject\Services\Db;

class MainController
{
    private $view;

    private $db;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->db = new Db();
    }

    public function main()
    {
    /*    $articles = [
            ['name' => 'Статья 1', 'text' => 'Текст статьи 1'],
            ['name' => 'Статья 2', 'text' => 'Текст статьи 2'],
        ];
        $this->view->renderHtml('main/main.php', ['articles' => $articles, 'title' => 'Мой блог']);
    */
        $articles = $this->db->query('SELECT * FROM`articles`;');
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