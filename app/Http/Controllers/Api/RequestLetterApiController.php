<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestLetterCreateRequest;
use App\Http\Requests\RequestLetterUpdateRequest;
use App\Http\Resources\AppPagingResource;
use App\Http\Resources\AppResource;
use App\Http\Resources\RequestLetterResource;
use App\Http\Resources\RequestLettersResource;
use App\Services\Model\RequestLetterEntity;
use App\Services\RequestLetterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RequestLetterApiController extends Controller
{

    private RequestLetterService $service;

    public function __construct(RequestLetterService $service)
    {
        $this->service = $service;
    }

    public function createRequestLetter(RequestLetterCreateRequest $request): JsonResponse
    {
        $data = $request->validated();

        $userId = $data['userId'] ?? null;
        $letterId = $data['letterId'] ?? null;
        $dateRequest = $data['dateRequest'] ?? null;

        $reqLetterEntity = new RequestLetterEntity(
            userId: $userId,
            letterId: $letterId,
            dateRequest: $dateRequest,
        );

        $appEntity = $this->service->createRequestLetter($reqLetterEntity);

        return (new AppResource(
            null,
            $appEntity->getMessage(),
            $appEntity->isStatus(),
        ))->response()->setStatusCode(200);
    }

    public function updateRequestLetter(RequestLetterUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        $checkReqLetterId = $this->checkReqLetterId($id);
        if ($checkReqLetterId) {
            return $checkReqLetterId;
        }

        $status = $data['status'] ?? null;
        $doc = $data['doc'] ?? null;

        $docPath = null;

        if ($doc) {
            $docName = $id . '.' . 'pdf';

            $doc->storeAs('public/documents', $docName);
            $docPath = $docName;
        }

        $reqLetterEntity = new RequestLetterEntity(
            id: $id,
            status: $status,
            docUrl: $docPath,
        );

        $appEntity = $this->service->updateRequestLetter($reqLetterEntity);

        return (new AppResource(
            null,
            $appEntity->getMessage(),
            $appEntity->isStatus(),
        ))->response()->setStatusCode(200);
    }

    public function getRequestLetters(Request $request): JsonResponse
    {
        $page = $request->query('page', 1);

        $rqPagination = $this->service->getRequestLetters($page);

        $data = new RequestLettersResource($rqPagination);

        $res = new AppPagingResource(
            $rqPagination,
            'Berhasil mendapatkan data.',
            true,
            $data
        );

        return ($res)
            ->response()
            ->setStatusCode(200);
    }

    public function getRequestLettersByUserId(Request $request, int $userId): JsonResponse
    {
        $page = $request->query('page', 1);

        $rqPagination = $this->service->getRequestLettersByUserId($userId, $page);

        if (!$rqPagination) {
            return (new AppResource(
                null,
                "User tidak ditemukan.",
                false,
            ))->response()->setStatusCode(200);
        }

        $data = new RequestLettersResource($rqPagination);

        $res = new AppPagingResource(
            $rqPagination,
            'Berhasil mendapatkan data.',
            true,
            $data
        );

        return ($res)
            ->response()
            ->setStatusCode(200);
    }

    public function getRequestLetterById(int $id): JsonResponse
    {
        $checkReqLetterId = $this->checkReqLetterId($id);
        if ($checkReqLetterId) {
            return $checkReqLetterId;
        }

        $appEntity = $this->service->getRequestLetterById($id);

        $res = $appEntity->getData();
        if ($res) {
            $res = new RequestLetterResource($res);
        }

        return (new AppResource(
            $res,
            $appEntity->getMessage(),
            $appEntity->isStatus(),
        ))->response()->setStatusCode(200);
    }

    public function deleteRequestLetterById(int $id): JsonResponse
    {
        $checkReqLetterId = $this->checkReqLetterId($id);
        if ($checkReqLetterId) {
            return $checkReqLetterId;
        }

        $appEntity = $this->service->deleteRequestLetterById($id);

        return (new AppResource(
            null,
            $appEntity->getMessage(),
            $appEntity->isStatus(),
        ))->response()->setStatusCode(200);
    }

    private function checkReqLetterId(?int $id): ?JsonResponse
    {
        if (!$id) {
            return (new AppResource(
                null,
                'Id pengajuan surat tidak boleh kosong.',
                false,
            ))->response()->setStatusCode(200);
        }

        if (!is_numeric($id)) {
            return (new AppResource(
                null,
                'Id pengajuan surat harus berupa angka.',
                false,
            ))->response()->setStatusCode(200);
        }

        return null;
    }

}
