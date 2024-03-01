<?php

namespace App\Services;

use App\Services\Model\RoleEntity;

interface RoleService {

    public function getAll(): array;

    public function getById(int $id): ?RoleEntity;

    public function isAdmin(int $id): bool;

}
