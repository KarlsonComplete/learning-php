<?php

namespace MyProject\Models\Users;

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

    protected ?string $imgName = null;

    /**
     * @return string|null
     */
    public function getImgName(): string|null
    {
        return $this->imgName;
    }

    /**
     * @param string $imgName
     */
    public function setImgName(string $imgName): void
    {
        $this->imgName = $imgName;
    }

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

    public static function updatePhoto(User $user, string $imgFileName, string $uploaded_file, string $destination_path): void
    {
        $moved = move_uploaded_file($uploaded_file, $destination_path . $imgFileName);
        if ($moved) {
            echo "Successfully uploaded";
        } else {
            echo "Not uploaded because of error #" . $_FILES['userfile']['error'];
        }
        $user->setImgName($imgFileName);
        $user->save();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    protected function refreshAuthToken(): void
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }

    protected static function getTableName(): string
    {
        return 'users';
    }
}