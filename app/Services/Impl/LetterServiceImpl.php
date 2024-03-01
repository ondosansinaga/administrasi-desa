<?php

namespace App\Services\Impl;

use App\Models\Letter;
use App\Services\LetterService;
use App\Services\Model\AppEntity;
use App\Services\Model\LetterEntity;

class LetterServiceImpl implements LetterService
{

    public function getLetters(): AppEntity
    {
        $letters = Letter::all()->map(function ($e) {
            return LetterEntity::fromLetter($e);
        });

        return AppEntity::success("Berhasil mendapatkan data.", $letters);
    }

    public function getLetterById(int $id): AppEntity
    {
        $letter = Letter::query()
            ->where('id', $id)
            ->first();

        if (!$letter) {
            return AppEntity::error('Surat dengan id ' . $id . ' tidak ditemukan.');
        }

        $letterEntity = LetterEntity::fromLetter($letter);

        return AppEntity::success("Berhasil mendapatkan data.", $letterEntity);
    }
}
