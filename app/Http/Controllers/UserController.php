<?php

namespace App\Http\Controllers;

use App\Helpers\Constants;
use App\Services\Model\Menu;
use App\Services\Model\UserEntity;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function updateUserById(Request $request, int $id)
    {
        $updatedBy = Session::get(Constants::$KEY_USER_ID);

        $image = $request->file('image') ?? null;
        $nik = $request->input('nik') ?? null;
        $name = $request->input('name') ?? null;
        $gender = $request->input('gender') ?? null;
        $address = $request->input('address') ?? null;
        $ttl = $request->input('birth') ?? null;
        $job = $request->input('job') ?? null;
        $password = $request->input('password') ?? null;

        $dest = redirect('/?menu=' . Menu::USERS->value);

        if (!$id || !is_numeric($id)) {
            return $dest;
        }

        if ($image && !$image->getSize()) {
            return $dest->with(
                [
                    'message' => [
                        'error' => 'Ukuran gambar tidak boleh lebih dari 2 mb.',
                    ],
                ]
            );
        }

        if(!preg_match(Constants::$BIRTH_PATTERN, $ttl)) {
            return $dest->with([
                'message' => [
                    'error' => 'TTL hanya menerima pola "Tempat,Hari-Tanggal-Bulan".',
                ]
            ]);
        }

        $imagePath = null;

        if ($image) {
            $imageName = $nik . '.' . 'png';

            $image->storeAs('public/images/profile', $imageName);
            $imagePath = $imageName;
        }

        $userEntity = new UserEntity(
            id: $id,
            password: $password,
            name: $name,
            address: $address,
            imageUrl: $imagePath,
            updatedAt: now(),
            updatedBy: $updatedBy,
            nik: $nik,
            birthInfo: $ttl,
            jobTitle: $job,
            gender: $gender,
        );

        $appEntity = $this->service->updateUser($userEntity);

        if (!$appEntity->isStatus()) {
            return $dest->with([
                'message' => [
                    'error' => $appEntity->getMessage(),
                ]
            ]);
        }

        return $dest->with(
            [
                'message' => [
                    'success' => 'Berhasil mengubah data user.',
                ],
            ]
        );

    }

    public function showUserById(Request $request, int $id)
    {
        $isEdit = $request->input('isEdit') ?? false;
        $dest = redirect('/?menu=' . Menu::USERS->value);

        if (!$id || !is_numeric($id)) {
            return $dest;
        }

        $appEntity = $this->service->getUserById($id);

        if (!$appEntity->isStatus()) {
            return $dest->with(
                [
                    'message' =>
                        [
                            'error' => $appEntity->getMessage(),
                        ]
                ]
            );
        }

        $user = $appEntity->getData();

        return $dest->with(
            [
                'userValue' => $user,
                'isEdit' => $isEdit,
            ]
        );
    }

    public function deleteUserById(int $id)
    {
        $dest = redirect('/?menu=' . Menu::USERS->value);

        if (!$id || !is_numeric($id)) {
            return $dest;
        }

        $appEntity = $this->service->deleteUserById($id);

        if (!$appEntity->isStatus()) {
            return $dest->with(
                [
                    'message' =>
                        [
                            'error' => $appEntity->getMessage(),
                        ]
                ]
            );
        }

        return $dest->with(
            [
                'message' =>
                    [
                        'success' => 'Berhasil menghapus data pengguna',
                    ]
            ]);
    }

}
