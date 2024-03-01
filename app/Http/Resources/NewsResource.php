<?php

namespace App\Http\Resources;

use App\Services\Model\NewsEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @mixin NewsEntity
 */
class NewsResource extends ResourceCollection
{
    public static $wrap = 'data';

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => NewsDataResource::collection($this->collection),
        ];
    }
}
