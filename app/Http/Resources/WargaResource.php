<?php

namespace App\Http\Resources\WargaResource;

use App\Services\Model\WargaEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin UserEntity
 */
class WargaResource extends JsonResource
{

    public static $wrap = 'data';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
            'imageUrl' => $this->getImageUrl(),
            'nik' => $this->getNik(),
            'name' => $this->getName(),
            'birthInfo' => $this->getBirthInfo(),
            'address' => $this->getAddress(),   
            'jobTitle' => $this->getJobTitle(),
            'gender' => $this->getGender(),
            'createdAt' => $this->getCreatedAt(),
            'updatedAt' => $this->getUpdatedAt(),
            'status1' => $this->getStatus1(),
            'status2' => $this->getStatus2(),
            'status_perkawinan' => $this->getStatusPerkawinan(),
            'kewarganegaraan' => $this->getKewarganegaraan(),
            'user_id' => $this->getUserId(),
            'role_id' => $this->getRoleId(),
            'created_by' => $this->getCreatedBy(),
            'updated_by' => $this->getUpdatedBy(),
        ];
    }
}