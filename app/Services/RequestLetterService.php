<?php

namespace App\Services;

use App\Services\Model\AppEntity;
use App\Services\Model\RequestLetterEntity;

interface RequestLetterService
{
    public function createRequestLetter(
        RequestLetterEntity $requestLetterEntity
    ): AppEntity;

    public function updateRequestLetter(
        RequestLetterEntity $requestLetterEntity
    ): AppEntity;

    public function getRequestLetters(?int $page);

    public function getRequestLetterById(int $id): AppEntity;
    public function getRequestLettersByUserId(int $userId, int $page);

    public function deleteRequestLetterById(int $id): AppEntity;
}
