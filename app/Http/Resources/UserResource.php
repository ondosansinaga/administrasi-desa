<?php

namespace App\Http\Resources;

use App\Services\Model\UserEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin UserEntity
 */
class UserResource extends JsonResource
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
            'nik' => $this->getNik(),
            'name' => $this->getName(),
            'birthInfo' => $this->getBirthInfo(),
            'jobTitle' => $this->getJobTitle(),
            'address' => $this->getAddress(),
            'gender' => $this->getGender(),
            'role' => new RoleDataResource($this->getRole()),
            'imageUrl' => $this->getImageUrl(),
        ];
    }
}
