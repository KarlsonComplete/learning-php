<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article;
use Myproject\Models\Comments\Comment;

class AdminController extends AbstractController
{
    public function viewArticles()
    {
        if ($this->user->getRole() === 'admin')
        {
           $articles = Article::findAll(' ORDER BY created_at DESC ');

           $this->view->renderHtml('admin/viewArticles.php', ['articles' => $articles]);
        }else
        {
            echo 'Enemy';
        }
    }

    public function viewComments()
    {
        if ($this->user->getRole() === 'admin')
        {
            $comments = Comment::findAll(' ORDER BY created_at DESC ');

            $this->view->renderHtml('admin/viewComments.php', ['comments' => $comments]);
        }else
        {
            echo 'Enemy';
        }
    }

    public function viewAdmin(): void
    {
        if ($this->user->getRole() === 'admin')
        {
            echo 'Hi admin';
        }else
        {
            echo 'Enemy';
        }
      $this->view->renderHtml('admin/viewAdmin.php');
    }

}