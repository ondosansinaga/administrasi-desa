<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Services\Model\AppEntity;
use App\Services\Model\RoleEntity;
use App\Services\Model\UserEntity;
use App\Services\Model\UserType;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Support\Facades\App;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Event;

class UserServiceImpl implements UserService
{

    private RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function register(
        UserType   $userType,
        UserEntity $userEntity
    ): AppEntity
    {
        $username = $userEntity->getUsername();
        $nik = $userEntity->getNik();

        $user = User::query()
            ->where('username', $username)
            ->orWhere('nik', $nik)
            ->first();

        if ($user) {
            return AppEntity::error('Username atau nik sudah ada, harap gunakan data lain.');
        }

        $creatorId = $userEntity->getCreatedBy();

        if ($creatorId) {
            $creator = $this->getUserById($creatorId);

            if (!$creator->isStatus()) {
                return AppEntity::error($creator->getMessage());
            }
        }

        $newUser = User::create([
            'username' => $userEntity->getUsername(),
            'password' => $userEntity->getPassword(),
            'name' => $userEntity->getName(),
            'address' => $userEntity->getAddress(),
            'nik' => $userEntity->getNik(),
            'job_title' => $userEntity->getJobTitle(),
            'birth_info' => $userEntity->getBirthInfo(),
            'gender' => $userEntity->getGender(),
            'role_id' => $userType->value,
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => $userEntity->getCreatedBy(),
            'updated_by' => $userEntity->getUpdatedBy(),
        ]);

        $userEntity = UserEntity::fromUser($newUser);

        // Kirim event UserRegistered dengan melewatkan objek UserEntity
        Event::dispatch(new UserRegistered($userEntity));

        return AppEntity::success('Berhasil membuat akun.', $userEntity);
    }

    public function login(string $username, string $password): AppEntity
    {
        $user = $this->getUserBy('username', $username);

        if (!$user) {
            return AppEntity::error('User dengan username ' . $username . ' tidak ditemukan.');
        }

        if ($user->password != $password) {
            return AppEntity::error('Password yang anda masukan salah.');
        }

        $userEntity = UserEntity::fromUser($user);

        return AppEntity::success('username', $userEntity);
    }

    public function getUserById(int $userId): AppEntity
    {
        $user = $this->getUserBy('id', $userId);

        if (!$user) {
            return AppEntity::error('User dengan id ' . $userId . ' tidak ditemukan.');
        }

        $userEntity = UserEntity::fromUser($user);
        return AppEntity::success('Berhasil mendapatkan data.', $userEntity);
    }

    public function getUsers(int $page)
    {
        $users = User::latest()->paginate(perPage: 10, page: $page);
        $users->getCollection()->transform(function ($user) {
            return UserEntity::fromUser($user);
        });
        return $users;
    }

    public function forgotPassword(
        string $username,
        string $newPassword,
    ): AppEntity
    {
        $user = $this->getUserBy('username', $username);

        if (!$user) {
            return AppEntity::error('User dengan username ' . $username . ' tidak ditemukan.');
        }

        $user->update([
            'password' => $newPassword,
            'updated_at' => now(),
            'updated_by' => $user->id,
        ]);

        return AppEntity::success('Berhasil mengubah password.', $user);
    }

    public function isUsernameAdmin(string $username): bool
    {
        $user = $this->getUserBy('username', $username);

        if (!$user) {
            return false;
        }

        $userEntity = UserEntity::fromUser($user);

        $roleId = $userEntity->getRole()->getId();

        return $this->roleService->isAdmin($roleId);
    }

    public function updateUser(UserEntity $userEntity): AppEntity
    {
        $userId = $userEntity->getId();

        $user = $this->getUserBy('id', $userId);

        if (!$user) {
            return AppEntity::error('User dengan id ' . $userId . ' tidak ditemukan.');
        }

        $nik = $userEntity->getNik();

        $userNik = $this->getUserBy('nik', $nik);

        if ($userNik) {
            if ($userNik->id != $userId) {
                return AppEntity::error('User dengan nik ' . $nik . ' sudah terdaftar.');
            }
        }

        $user->update([
            'name' => $userEntity->getName() ?? $user->name,
            'password' => $userEntity->getPassword() ?? $user->password,
            'address' => $userEntity->getAddress() ?? $user->address,
            'image_url' => $userEntity->getImageUrl() ?? $user->image_url,
            'updated_at' => now(),
            'updated_by' => $userEntity->getUpdatedBy(),
            'nik' => $userEntity->getNik() ?? $user->nik,
            'birth_info' => $userEntity->getBirthInfo() ?? $user->birth_info,
            'job_title' => $userEntity->getJobTitle() ?? $user->job_title,
            'gender' => $userEntity->getGender() ?? $user->gender,
        ]);

        return AppEntity::success('Berhasil mengubah profil.', null);
    }

    public function deleteUserById(?int $userId): AppEntity
    {
        $user = $this->getUserBy('id', $userId);

        if (!$user) {
            return AppEntity::error('User dengan id ' . $userId . ' tidak ditemukan.');
        }

        $user->delete();

        return AppEntity::success('Berhasil menghapus user dengan id ' . $userId . '.', null);
    }

    private function getUserBy(string $columName, mixed $value): ?User
    {
        $user = User::query()
            ->where($columName, $value)
            ->first();

        return $user;
    }
}
