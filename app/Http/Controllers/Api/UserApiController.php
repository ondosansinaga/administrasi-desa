<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPassRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\AppPagingResource;
use App\Http\Resources\AppResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;
use App\Services\Model\UserEntity;
use App\Services\Model\UserType;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserApiController extends Controller
{

    private UserService $service;

    public function __construct(
        UserService $service,
    )
    {
        $this->service = $service;
    }

    public function getUserById($userId): JsonResponse
    {
        $checkUserId = $this->checkUserId($userId);
        if ($checkUserId) {
            return $checkUserId;
        }

        $appEntity = $this->service->getUserById($userId);

        $user = $appEntity->getData();

        if ($user == null) {
            return (new AppResource(
                null,
                $appEntity->getMessage(),
                $appEntity->isStatus(),
            ))->response()->setStatusCode(200);
        }

        $res = new UserResource($user);

        return (new AppResource(
            $res,
            $appEntity->getMessage(),
            $appEntity->isStatus(),
        ))->response()->setStatusCode(200);
    }

    public function getUsers(Request $request): JsonResponse
    {
        $page = $request->query('page', 1);

        $userPagination = $this->service->getUsers($page);

        $data = new UsersResource($userPagination);

        $res = new AppPagingResource(
            $userPagination,
            'Berhasil mendapatkan data.',
            true,
            $data
        );

        return ($res)
            ->response()
            ->setStatusCode(200);
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;
        $name = $data['name'] ?? null;
        $address = $data['address'] ?? null;
        $nik = $data['nik'] ?? null;
        $birthInfo = $data['birthInfo'] ?? null;
        $jobTitle = $data['jobTitle'] ?? null;
        $gender = $data['gender'] ?? null;
        $roleId = $data['roleId'] ?? null;
        $creatorId = $data['creatorId'] ?? null;

        $userEntity = new UserEntity(
            username: $username,
            password: $password,
            name: $name,
            address: $address,
            roleId: $roleId,
            createdBy: $creatorId,
            updatedBy: $creatorId,
            nik: $nik,
            birthInfo: $birthInfo,
            jobTitle: $jobTitle,
            gender: $gender,
        );

        $userType = UserType::tryFrom($roleId) ?? UserType::ADMIN;

        $appEntity = $this->service->register($userType, $userEntity);

        $res = null;
        if ($appEntity->getData() != null) {
            $res = new UserResource($appEntity->getData());
        }

        return (new AppResource(
            $res,
            $appEntity->getMessage(),
            $appEntity->isStatus(),
        ))->response()->setStatusCode(200);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        if ($this->service->isUsernameAdmin($username)) {
            return (new AppResource(
                null,
                'Admin tidak diperkenankan masuk ke sistem mobile.',
                false,
            ))->response()->setStatusCode(200);
        }

        $appEntity = $this->service->login($username, $password);

        $res = null;
        if ($appEntity->getData() != null) {
            $res = new UserResource($appEntity->getData());
        }

        return (new AppResource(
            $res,
            $appEntity->getMessage(),
            $appEntity->isStatus(),
        ))->response()->setStatusCode(200);
    }

    public function forgotPassword(ForgotPassRequest $request): JsonResponse
    {
        $data = $request->validated();

        $username = $data['username'] ?? null;
        $newPassword = $data['newPassword'] ?? null;

        if ($this->service->isUsernameAdmin($username)) {
            return (new AppResource(
                null,
                'Admin tidak diperkenankan mengubah password di sistem mobile.',
                false,
            ))->response()->setStatusCode(200);
        }

        $appEntity = $this->service->forgotPassword($username, $newPassword);

        return (new AppResource(
            null,
            $appEntity->getMessage(),
            $appEntity->isStatus(),
        ))->response()->setStatusCode(200);
    }

    public function updateProfile(UserRequest $request, int $userId): JsonResponse
    {
        $data = $request->validated();

        $checkUserId = $this->checkUserId($userId);
        if ($checkUserId) {
            return $checkUserId;
        }

        $nik = $data['nik'] ?? null;
        $name = $data['name'] ?? null;
        $jobTitle = $data['jobTitle'] ?? null;
        $birthInfo = $data['birthInfo'] ?? null;
        $address = $data['address'] ?? null;
        $gender = $data['gender'] ?? null;
        $image = $data['image'] ?? null;

        $imagePath = null;

        if ($image) {
            $imageName = $nik . '.' . 'png';

            $image->storeAs('public/images/profile', $imageName);
            $imagePath = $imageName;
        }

        $userEntity = new UserEntity(
            id: $userId,
            name: $name,
            address: $address,
            imageUrl: $imagePath,
            updatedAt: now(),
            updatedBy: $userId,
            nik: $nik,
            birthInfo: $birthInfo,
            jobTitle: $jobTitle,
            gender: $gender,
        );

        $appEntity = $this->service->updateUser($userEntity);

        return (new AppResource(
            null,
            $appEntity->getMessage(),
            $appEntity->isStatus(),
        ))->response()->setStatusCode(200);
    }

    public function deleteUserById(int $userId): JsonResponse
    {
        $checkUserId = $this->checkUserId($userId);
        if ($checkUserId) {
            return $checkUserId;
        }

        $appEntity = $this->service->deleteUserById($userId);

        return (new AppResource(
            null,
            $appEntity->getMessage(),
            $appEntity->isStatus(),
        ))->response()->setStatusCode(200);
    }

    private function checkUserId(?int $userId): ?JsonResponse
    {
        if (!$userId) {
            return (new AppResource(
                null,
                'User Id tidak boleh kosong.',
                false,
            ))->response()->setStatusCode(200);
        }

        if (!is_numeric($userId)) {
            return (new AppResource(
                null,
                'User Id harus berupa angka.',
                false,
            ))->response()->setStatusCode(200);
        }

        return null;
    }



}
