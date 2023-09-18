<?php

namespace MyProject\Models\Articles;

use Myproject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;
use Myproject\Exception\InvalidArgumentException;

class Article extends ActiveRecordEntity
{

    protected string $name;

    protected string $text;

    protected ?int $authorId = null;

    protected ?string $createdAt = null;

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param int $authorId
     */
    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    public static function create(array $articlesData, User $author):Article
    {
        if (empty($articlesData['name']))
        {
            throw new InvalidArgumentException('Введите название статьи');
        }
        if (empty($articlesData['text']))
        {
            throw new InvalidArgumentException('Введите текст');
        }

        $article = new Article();

        $article->setAuthorId($author->id);
        $article->setName($articlesData['name']);
        $article->setText($articlesData['text']);

        $article->save();

        return $article;
    }

    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }


}