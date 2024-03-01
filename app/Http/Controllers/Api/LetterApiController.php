<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppResource;
use App\Http\Resources\LetterResource;
use App\Http\Resources\LettersResource;
use App\Services\LetterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LetterApiController extends Controller
{
    private LetterService $service;

    public function __construct(LetterService $service)
    {
        $this->service = $service;
    }

    public function getLetters(): JsonResponse
    {
        $appEntity = $this->service->getLetters();

        $res = new LettersResource($appEntity->getData());

        return (new AppResource(
            $res,
            $appEntity->getMessage(),
            true,
        ))->response()->setStatusCode(200);
    }

    public function getLetterById(int $id): JsonResponse
    {
        if (!$id) {
            return (new AppResource(
                null,
                'Id surat tidak boleh kosong.',
                false,
            ))->response()->setStatusCode(200);
        }

        if (!is_numeric($id)) {
            return (new AppResource(
                null,
                'Id surat harus berupa angka.',
                false,
            ))->response()->setStatusCode(200);
        }

        $appEntity = $this->service->getLetterById($id);

        $res = null;
        if ($appEntity->getData() != null) {
            $res = new LetterResource($appEntity->getData());
        }

        return (new AppResource(
            $res,
            $appEntity->getMessage(),
            $appEntity->isStatus(),
        ))->response()->setStatusCode(200);
    }

}
