<?php

namespace MyProject\Controllers;

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

        /*$reflector = new \ReflectionObject($article);
        $properties = $reflector->getProperties();
        $propertiesName = [];
        foreach ($properties as $property)
        {
            $propertiesName[] = $property->name;
        }
        var_dump($propertiesName);*/


        if ($article === null)
        {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

       $this->view->renderHtml('articles/view.php', ['article' =>$article]);
    }

    public function edit(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null)
        {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }
        $article->setName('Новое название статьи');
        $article->setText('Новый текст статьи');

        $article->save();

         //$edits = Article::edit($propertiesName);
    }


}