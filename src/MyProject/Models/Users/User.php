<?php

namespace MyProject\Models\Users;

use Myproject\Exception\InvalidArgumentException;
use Myproject\Models\ActiveRecordEntity;

class User extends ActiveRecordEntity
{
    protected string $nickname;

    protected string $email;

    protected int $isConfirmed;

    protected string $role;

    protected string $passwordHash;

    protected string $authToken;

    protected string $createdAt;

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getAuthToken(): string
    {
        return $this->authToken;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function isActivated(): bool
    {
        return $this->isConfirmed;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }


    public static function login(array $userData): User
    {
        if (empty($userData['password'])) {
            throw new InvalidArgumentException('Введите пароль');
        }

        if (mb_strlen($userData['password']) < 5) {
            throw new InvalidArgumentException('Пароль должен быть не менее 5 символов');
        }

        $user = static::findOneByColumn('nickname', $userData['nickname']);

        if ($user === null) {
            throw new InvalidArgumentException('Пользователь с таким nickname не найден');
        }

        if ($user->isAdmin() && $userData['password'] === $user->getPasswordHash())
        {
        }
        else{
            if (!password_verify($userData['password'], $user->getPasswordHash())) {
                throw new InvalidArgumentException('Неправильный пароль');
            }
        }

        if (!$user->isActivated()) {
            throw new InvalidArgumentException('Пользователь не подтверждён');
        }

        $user->refreshAuthToken();
        $user->save();

        return $user;
    }

    public static function signUp(array $userData): User
    {

        if (static::findOneByColumn('nickname', $userData['nickname']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким nickname уже существует');
        }

        if (static::findOneByColumn('email', $userData['email']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким email уже существует');
        }

        if (!preg_match('/^[a-zA-Z0-9]+$/', $userData['nickname'])) {
            throw new InvalidArgumentException('nickname может состоять только из символов латинского алфавита и цифр');
        }

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email некорректен');
        }

        if (mb_strlen($userData['password']) < 8) {
            throw new InvalidArgumentException('Пароль должен быть не менее 8 символов');
        }

        if (empty($userData['nickname'])) {
            throw new InvalidArgumentException('Не передан nickname');
        }

        if (empty($userData['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }

        if (empty($userData['password'])) {
            throw new InvalidArgumentException('Не передан password');
        }

        $user = new User();

        $user->nickname = $userData['nickname'];
        $user->email = $userData['email'];
        $user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->isConfirmed = false;
        $user->role = 'user';
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->createdAt = date('c');
        $user->save();

        return $user;

    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function activate(): void
    {
        $this->isConfirmed = true;
        $this->save();
    }

    private function refreshAuthToken(): void
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }

    protected static function getTableName(): string
    {
        return 'users';
    }
}