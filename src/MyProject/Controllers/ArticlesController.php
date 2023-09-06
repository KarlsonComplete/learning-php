<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use Myproject\Services\Db;
use Myproject\View\View;
use const http\Client\Curl\Versions\ARES;

class ArticlesController
{
    private $view;

    private $db;

    /**
     * @param $view
     */
    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->db = new Db();
    }

    public function view(int $articleId)
    {
        $result = $this->db->query(
            'SELECT * FROM`articles` WHERE id = :id;',
            [':id' => $articleId],
            Article::class
        );

        if ($result === [])
        {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

       $this->view->renderHtml('articles/view.php', ['article' => $result[0]]);
    }


}