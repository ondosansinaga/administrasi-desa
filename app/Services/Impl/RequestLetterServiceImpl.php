<?php

namespace App\Services\Impl;

use App\Models\RequestLetter;
use App\Services\Model\AppEntity;
use App\Services\Model\RequestLetterEntity;
use App\Services\RequestLetterService;
use App\Services\UserService;

class RequestLetterServiceImpl implements RequestLetterService
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function createRequestLetter(RequestLetterEntity $requestLetterEntity): AppEntity
    {
        $requestLetter = RequestLetter::create([
            'user_id' => $requestLetterEntity->getUserId(),
            'letter_id' => $requestLetterEntity->getLetterId(),
            'request_date' => $requestLetterEntity->getDateRequest(),
            'status' => 0,
            'status_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $newReqLetter = RequestLetterEntity::fromRequestLetter($requestLetter);

        return AppEntity::success('Berhasil menambah pengajuan surat.', $newReqLetter);
    }

    public function updateRequestLetter(RequestLetterEntity $requestLetterEntity): AppEntity
    {
        $id = $requestLetterEntity->getId();
        $requestLetter = $this->requestLetterBy('id', $id);
        if (!$requestLetter) {
            return AppEntity::error('Pengajuan surat dengan id ' . $id . ' tidak ditemukan.');
        }

        $requestLetter->update(
            [
                'status' => $requestLetterEntity->getStatus() ?? $requestLetter->status,
                'doc_url' => $requestLetterEntity->getDocUrl() ?? $requestLetter->doc_url,
                'status_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $newReqLetter = RequestLetterEntity::fromRequestLetter($requestLetter);

        return AppEntity::success('Berhasil mengubah pengajuan surat.', $newReqLetter);
    }

    public function getRequestLetters(?int $page)
    {
        $requestLetters = RequestLetter::paginate(perPage: 5, page: $page);

        $requestLetters->getCollection()->transform(function ($reqLetter) {
            return RequestLetterEntity::fromRequestLetter($reqLetter);
        });

        return $requestLetters;
    }

    public function getRequestLetterById(int $id): AppEntity
    {
        $requestLetter = $this->requestLetterBy('id', $id);
        if (!$requestLetter) {
            return AppEntity::error('Pengajuan surat dengan id ' . $id . ' tidak ditemukan.');
        }

        $entity = RequestLetterEntity::fromRequestLetter($requestLetter);

        return AppEntity::success('Berhasil mendapatkan data.', $entity);
    }

    public function deleteRequestLetterById(int $id): AppEntity
    {
        $requestLetter = $this->requestLetterBy('id', $id);
        if (!$requestLetter) {
            return AppEntity::error('Pengajuan surat dengan id ' . $id . ' tidak ditemukan.');
        }

        $requestLetter->delete();

        return AppEntity::success('Berhasil menghapus pengajuan surat dengan id ' . $id . '.', null);
    }

    public function getRequestLettersByUserId(
        int $userId,
        int $page,
    )
    {
        $userEntity = $this->userService->getUserById($userId);
        if (!$userEntity->isStatus()) {
            return null;
        }

        $requestLetters = RequestLetter::where('user_id', $userId)
            ->latest()
            ->paginate(perPage: 5, page: $page);

        $requestLetters->getCollection()
            ->transform(function ($reqLetter) {
                return RequestLetterEntity::fromRequestLetter($reqLetter);
            });

        return $requestLetters;
    }

    private function requestLetterBy(string $column, mixed $value): ?RequestLetter
    {
        $requestLetter = RequestLetter::query()
            ->where($column, $value)
            ->first();

        return $requestLetter;
    }
}
