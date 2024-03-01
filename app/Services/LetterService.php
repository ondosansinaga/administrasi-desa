<?php

namespace App\Services;

use App\Services\Model\AppEntity;

interface LetterService
{

    public function getLetters(): AppEntity;

    public function getLetterById(int $id): AppEntity;

}
