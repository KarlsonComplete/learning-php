<?php

namespace MyProject\Controllers;

use Myproject\Exception\ForbiddenException;
use Myproject\Exception\InvalidArgumentException;
use Myproject\Exception\NotFoundException;
use Myproject\Exception\UnauthorizedException;
use MyProject\Models\Articles\Article;


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

        if ($this->user === null)
        {
            throw new UnauthorizedException();
        }

        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('Недостаточно прав пользователя!');
        }

        if (!empty($_POST))
        {
            try {
                $article->edit($_POST);
            }catch (InvalidArgumentException $invalidArgumentException) {
                $this->view->renderHtml('articles/edit.php', ['error' => $invalidArgumentException->getMessage(), 'article' => $article]);
                return;
            }

            header('Location /www/articles/' . $article->getId() . '/edit', true, 302);
            exit();
        }
        $this->view->renderHtml('articles/edit.php', ['article' => $article]);
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
    }

    public function delete(int $articleId): void
    {
        $articles = Article::getById($articleId);

        $articles->drop();
    }


}