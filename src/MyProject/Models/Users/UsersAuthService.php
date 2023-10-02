<?php

namespace Myproject\Models\Users;

use Myproject\Exception\InvalidArgumentException;
use Myproject\Models\ActiveRecordEntity;

class UsersAuthService extends User
{
    public static function login(array $userData): ActiveRecordEntity
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

        if ($user->isAdmin() && $userData['password'] === $user->getPasswordHash()) {
        } else {
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

    public static function createToken(User $user): void
    {
        $token = $user->getId() . ':' . $user->getAuthToken();
        setcookie('token', $token, 0, '/', '', false, true);
    }

    public static function getUserByToken()
    {
        $token = $_COOKIE['token'] ?? '';

        if (empty($token))
        {
            return null;
        }

        [$userId, $authToken] = explode(':', $token,2);

        $user = User::getById((int) $userId);

        if ($user === null)
        {
            return null;
        }

        if ($user->getAuthToken() !== $authToken)
        {
            return null;
        }

        return $user;
    }

    public static function deleteToken()
    {
        setcookie('token', '', time() - 3600, '/');
    }
}