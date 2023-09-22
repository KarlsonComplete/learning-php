<?php

namespace MyProject\Controllers;

use Myproject\Exception\InvalidArgumentException;
use Myproject\Models\Comments\Comment;

class CommentsController extends AbstractController
{
    public function edit($commentsId): void
    {
        $comments = Comment::getById($commentsId);
        if (!empty($_POST))
        {
            try {
                $comments->edit($_POST);
            } catch (InvalidArgumentException $invalidArgumentException) {
                $this->view->renderHtml('comments/edit.php', ['error' => $invalidArgumentException->getMessage(),'comments' => $comments]);
                return;
            }
            header('Location: http://learning-php/www/articles/'.$comments->getArticleId());
            die();
        }

        $this->view->renderHtml('comments/edit.php', ['comments' => $comments]);
    }
}