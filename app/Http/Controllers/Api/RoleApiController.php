<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppResource;
use App\Http\Resources\RoleDataResource;
use App\Http\Resources\RolesResource;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;

class RoleApiController extends Controller
{
    private RoleService $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    public function getRoles(): JsonResponse
    {
        $roles = $this->service->getAll();

        $jsonRoles = new RolesResource($roles);

        return (new AppResource(
            $jsonRoles,
            'Berhasil mendapatkan data.',
            true
        ))->response()->setStatusCode(200);
    }

    public function getRoleById($id): JsonResponse
    {
        if (!$id) {
            return (new AppResource(
                null,
                'Role Id tidak boleh kosong.',
                false,
            ))->response()->setStatusCode(200);
        }

        if (!is_numeric($id)) {
            return (new AppResource(
                null,
                'Role Id harus berupa angka.',
                false,
            ))->response()->setStatusCode(200);
        }

        $role = $this->service->getById($id);

        if (!$role) {
            return (new AppResource(
                null,
                'Role tidak ditemukan.',
                false,
            ))->response()->setStatusCode(200);
        }

        $roleJson = new RoleDataResource($role);

        return (new AppResource(
            $roleJson,
            'Role ditemukan.',
            true,
        ))->response()->setStatusCode(200);
    }

}
