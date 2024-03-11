<?php

namespace App\Http\Resources\WargarsResource;

use App\Services\Model\WargaEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin UserEntity
 */
class WargarsResource extends ResourceCollection{
    public static $wrap = 'data';

     /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => WargaResource::collection($this->collection)
        ];
    }
}