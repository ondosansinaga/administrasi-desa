<?php

namespace App\Http\Controllers;

use App\Services\Model\Menu;
use App\Services\Model\RequestLetterEntity;
use App\Services\RequestLetterService;
use Illuminate\Http\Request;

class RequestLetterController extends Controller
{
    private RequestLetterService $service;

    public function __construct(RequestLetterService $service)
    {
        $this->service = $service;
    }

    public function updateReqLetterById(Request $request, int $id)
    {
        $doc = $request->file('doc') ?? null;
        $status = $request->input('status') ?? null;

        $dest = redirect('/?menu=' . Menu::PENGAJUAN->value);

        if (!$id || !is_numeric($id)) {
            return $dest;
        }

        if ($doc && !$doc->getSize()) {
            return $dest->with(
                [
                    'message' => [
                        'error' => 'Ukuran dokumen tidak boleh lebih dari 2 mb.',
                    ],
                ]
            );
        }

        $docPath = null;

        $docEntity = $this->service->getRequestLetterById($id);

        if (!$docEntity->isStatus()) {
            return $dest->with(
                [
                    'message' => [
                        'error' => $docEntity->getMessage(),
                    ],
                ]
            );
        }

        $entity = $docEntity->getData();
        $docPrevUrl = $entity->getDocUrl();

        if ($doc) {
            $docName = time() . '.' . 'pdf';

            if ($docPrevUrl) {
                $docName = $docPrevUrl;
            }

            $doc->storeAs('public/documents/', $docName);
            $docPath = $docName;
        }

        $reqLetterEntity = new RequestLetterEntity(
            id: $id,
            userId: $entity->getUserId(),
            letterId: $entity->getLetterId(),
            status: $status,
            docUrl: $docPath,
            dateStatus: now(),
        );

        $appEntity = $this->service->updateRequestLetter($reqLetterEntity);

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
                    'success' => 'Berhasil mengubah data surat pengajuan.',
                ],
            ]
        );
    }

    public function showReqLetterById(Request $request, int $id)
    {
        $isEdit = $request->input('isEdit') ?? false;
        $dest = redirect('/?menu=' . Menu::PENGAJUAN->value);

        if (!$id || !is_numeric($id)) {
            return $dest;
        }

        $appEntity = $this->service->getRequestLetterById($id);

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
                'reqLetterValue' => $user,
                'isEdit' => $isEdit,
            ]
        );
    }

    public function deleteReqLetterById(int $id)
    {
        $dest = redirect('/?menu=' . Menu::PENGAJUAN->value);

        if (!$id || !is_numeric($id)) {
            return $dest;
        }

        $appEntity = $this->service->deleteRequestLetterById($id);

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
                        'success' => 'Berhasil menghapus data surat pengjuan',
                    ]
            ]);
    }

}
