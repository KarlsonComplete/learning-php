<?php

namespace MyProject\Controllers;

use Myproject\Exception\ForbiddenException;
use Myproject\Exception\InvalidArgumentException;
use Myproject\Exception\NotFoundException;
use Myproject\Exception\UnauthorizedException;
use MyProject\Models\Articles\Article;
use Myproject\Models\Users\UsersAuthService;
use Myproject\View\View;


class ArticlesController extends AbstractController
{
    public function view(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $this->view->renderHtml('articles/view.php', ['article' => $article]);
    }

    public function edit(int $articleId)
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $article->setName('Новое ');
        $article->setText('Новый текст ');

        $article->save();

    }

    public function create(): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('Недостаточно прав пользователя!');
        } else {
            if (!empty($_POST)) {
                try {
                    $article = Article::create($_POST, $this->user);
                } catch (InvalidArgumentException $invalidArgumentException) {
                    $this->view->renderHtml('articles/add.php', ['error' => $invalidArgumentException->getMessage()]);
                    return;
                }
                header('Location: /www/articles/' . $article->getId(), true, 302);
                exit();
            }
        }
        $this->view->renderHtml('articles/add.php');
        /*$newArticle = new Article();
        $newArticle->setName('Новое название ');
        $newArticle->setText('Новый текст статьи ');
        $newArticle->setAuthorId(1);
        $newArticle->setCreatedAt(date('c'));

        $articleId = $newArticle->save();
        $this->view($articleId);*/
    }

    public function delete(int $articleId): void
    {
        $articles = Article::getById($articleId);

        $articles->drop();
    }


}