<?php

namespace App\Services\Impl;

use App\Models\Role;
use App\Services\Model\RoleEntity;
use App\Services\RoleService;

class RoleServiceImpl implements RoleService
{
    public function getAll(): array
    {
        return Role::all()->map(function ($e) {
            return new RoleEntity(
                $e->id,
                $e->name,
                $e->created_at,
                $e->updated_at
            );
        })->all();
    }

    public function getById(int $id): ?RoleEntity
    {
        $role = Role::query()
            ->where('id', $id)
            ->first();

        if (!$role) return null;

        return new RoleEntity(
            $role->id,
            $role->name,
            $role->created_at,
            $role->updated_at
        );
    }

    public function isAdmin(int $id): bool
    {
        $role = $this->getById($id);

        if (!$role) return false;

        return $role->getId() == 1;
    }
}
