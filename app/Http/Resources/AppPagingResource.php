<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppPagingResource extends JsonResource
{
    private ?string $message;
    private bool $status;
    private mixed $data;
    public static $wrap = 'data';

    public function __construct(
        $resource,
        ?string $message,
        bool $status,
        mixed $data,
    )
    {
        parent::__construct($resource);
        $this->message = $message;
        $this->status = $status;
        $this->data = $data;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $res = $this->data;

        if ($res != null && method_exists($res, 'jsonSerialize')) {
            $js = $res->jsonSerialize();
            if (isset($js['data'])) {
                $res = $js['data'];
            }
        }

        return [
            'pageInfo' => [
                "currentPage" => $this->resource->currentPage(),
                "from" => $this->resource->firstItem(),
                "lastPage" => $this->resource->lastPage(),
                "perPage" => $this->resource->perPage(),
                "to" => $this->resource->lastItem(),
                "total" => $this->resource->total(),
            ],
            'data' => $res,
            'message' => $this->message,
            'status' => $this->status,
        ];
    }
}
