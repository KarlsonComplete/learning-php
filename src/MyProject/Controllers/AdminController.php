<?php

namespace MyProject\Controllers;

use Myproject\Exception\UnauthorizedException;
use MyProject\Models\Articles\Article;
use Myproject\Models\Comments\Comment;

class AdminController extends AbstractController
{
    public function viewArticles()
    {
        if ($this->user === null || !$this->user->isAdmin()) {
            throw new UnauthorizedException();
        }
        $articles = Article::findAll(' ORDER BY created_at DESC ');

        $this->view->renderHtml('admin/viewArticles.php', ['articles' => $articles]);

    }

    public function viewComments()
    {
        if ($this->user === null || !$this->user->isAdmin()) {
            throw new UnauthorizedException();
        }
        $comments = Comment::findAll(' ORDER BY created_at DESC ');

        $this->view->renderHtml('admin/viewComments.php', ['comments' => $comments]);

    }


    public function viewAdmin(): void
    {

        if ($this->user === null || !$this->user->isAdmin()) {
            throw new UnauthorizedException();
        }

        $this->view->renderHtml('admin/viewAdmin.php');
    }


}