<?php

namespace Myproject\Models\Comments;

use Myproject\Exception\InvalidArgumentException;
use Myproject\Models\ActiveRecordEntity;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;

class Comment extends ActiveRecordEntity
{

    protected int $authorId;

    protected int  $articleId;

    protected string $comments;

    protected ?string $createdAt = null;

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @param int $authorId
     */
    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    /**
     * @return int
     */
    public function getArticleId(): int
    {
        return $this->articleId;
    }

    /**
     * @param int $articleId
     */
    public function setArticleId(int $articleId): void
    {
        $this->articleId = $articleId;
    }

    /**
     * @return string
     */
    public function getComments(): string
    {
        return $this->comments;
    }

    /**
     * @param string $comments
     */
    public function setComments(string $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }


    public static function create(array $commentsData,User $author, Article $article): Comment
    {
        if (empty($commentsData['comments']))
        {
            throw new InvalidArgumentException('Невозможно отправить пустой комментарий');
        }

        $comment = new Comment();

        $comment->setAuthorId($author->id);
        $comment->setArticleId($article->id);
        $comment->setComments($commentsData['comments']);

        $comment->save();

        return $comment;
    }

    public function edit(array $commentsData):Comment
    {
        if (empty($commentsData['comments']))
        {
            throw new InvalidArgumentException('Невозможно отправить пустой комментарий');
        }
        if ($commentsData['comments'] === $this->getComments())
        {
            throw new InvalidArgumentException('Вы пытаетесь сохранить тот же комментарий');
        }

        $this->setComments($commentsData['comments']);
        $this->setCreatedAt(date('c'));

        $this->save();

        return $this;
    }

    public static function getCommentsByArticleId($articleId): ?array
    {
        return self::getArrayById($articleId,'article_id');
    }

    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    protected static function getTableName(): string
    {
       return 'comments';
    }
}