<?php

namespace App\Services;

use App\Services\Model\AppEntity;
use App\Services\Model\UserEntity;
use App\Services\Model\UserType;

interface UserService
{
    public function register(
        UserType   $userType,
        UserEntity $userEntity
    ): AppEntity;

    public function login(string $username, string $password): AppEntity;

    public function getUserById(int $userId): AppEntity;

    public function getUsers(int $page);

    public function forgotPassword(
        string $username,
        string $newPassword
    ): AppEntity;

    public function isUsernameAdmin(string $username): bool;

    public function updateUser(UserEntity $userEntity): AppEntity;

    public function deleteUserById(?int $userId): AppEntity;
}

