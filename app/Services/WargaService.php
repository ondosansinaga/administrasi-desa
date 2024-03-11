<?php

namespace App\Services;

use App\Services\Model\AppEntity;
use App\Services\Model\WargaEntity;

interface WargaService
{
    public function getWarga(?int $page);

    public function getWargaById(?int $id): AppEntity;

    public function updateWarga(WargaEntity $wargaEntity): AppEntity;

    public function createWarga(WargaEntity $wargaEntity): AppEntity;

    public function deleteWargaById(?int $id): AppEntity;
}
