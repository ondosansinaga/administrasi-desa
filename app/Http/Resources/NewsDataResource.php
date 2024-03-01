<?php

namespace App\Http\Resources;

use App\Services\Model\NewsEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin NewsEntity
 */
class NewsDataResource extends JsonResource
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
            'title' => $this->getTitle(),
            'content' => $this->getContent(),
            'imageUrl' => $this->getImageUrl(),
            'user' => new UserResource($this->getUser()),
            'createdAt' => $this->getCreatedAt(),
        ];
    }
}
