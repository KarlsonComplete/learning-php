<?php

namespace MyProject\Controllers;

use Myproject\Exception\NotFoundException;
use MyProject\Models\Articles\Article;
use Myproject\View\View;


class ArticlesController
{
    private View $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null)
        {
            throw new NotFoundException();
        }

       $this->view->renderHtml('articles/view.php', ['article' =>$article]);
    }

    public function edit(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null)
        {
            throw new NotFoundException();
        }

            $article->setName('Новое ');
            $article->setText('Новый текст ');

            $article->save();

    }

    public function create(): void
    {
        $newArticle = new Article();
        $newArticle->setName('Новое название ');
        $newArticle->setText('Новый текст статьи ');
        $newArticle->setAuthorId(1);
        $newArticle->setCreatedAt(date('c'));

        $articleId = $newArticle->save();
        $this->view($articleId);
    }

    public function delete(int $articleId): void
    {
        $articles = Article::getById($articleId);

        $articles->drop();
    }


}