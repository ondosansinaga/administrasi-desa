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
        

        // Mendapatkan $formatDate dari data yang diperlukan, misalnya dari $user
        $formatDate = date("d F Y", strtotime($user->getDateRequest()));

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
            ]
        );
    }

    public function cetakSurat($id)
    {
        $appEntity = $this->service->getRequestLetterById($id);

        if (!$appEntity->isStatus()) {
            return redirect('/?menu=' . Menu::PENGAJUAN->value)->with(
                [
                    'message' =>
                        [
                            'error' => $appEntity->getMessage(),
                        ]
                ]
            );
        }

        $user = $appEntity->getData();

         // Array untuk mengubah nama bulan menjadi kalimat
        $bulanKalimat = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        // Mendapatkan $formatDate dari data yang diperlukan, misalnya dari $user
        $formatDate = date("d F Y", strtotime($user->getDateRequest()));

        // Pisahkan tanggal, bulan, dan tahun
        list($hari, $bulan, $tahun) = explode(' ', $formatDate);
        // Ubah bulan menjadi kalimat menggunakan array $bulanKalimat
        $bulan = $bulanKalimat[$bulan];
        // Gabung kembali menjadi format "Hari-Bulan-Tahun"
        $formatDate = $hari . ' ' . $bulan . ' ' . $tahun;


        return view('cetak.surat-permohonan', [
            'reqLetterValue' => $user,
            'formatDate' => $formatDate, // Kirim $formatDate ke view

        ]);
    }

}