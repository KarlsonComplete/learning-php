<?php

namespace MyProject\Models\Articles;

use Myproject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;

class Article extends ActiveRecordEntity
{

    protected string $name;

    protected string $text;

    protected int $authorId;

    protected string $createdAt;

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
        return (int)$this->authorId;
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