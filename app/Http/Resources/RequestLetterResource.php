<?php

namespace App\Http\Resources;

use App\Services\Model\RequestLetterEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin RequestLetterEntity
 */
class RequestLetterResource extends JsonResource
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
            'status' => $this->getStatus(),
            'docUrl' => $this->getDocUrl(),
            'dateRequest' => $this->getDateRequest(),
            'dateStatus' => $this->getDateStatus(),
            'user' => new UserResource($this->getUser()),
            'letter' => new LetterResource($this->getLetter()),
        ];
    }
}
