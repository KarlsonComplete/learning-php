<?php

namespace MyProject\Models\Articles;

use MyProject\Models\Users\User;

class Article
{

    private int $id;

    private string $name;

    private string $text;

    private int $authorId;

    private string $createdAt;

    public function __set($name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function underscoreToCamelCase($name)
    {
        $str = str_replace('_', '', ucwords($name,'_'));
        $str = lcfirst($str);
        return $str;
    }


}