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