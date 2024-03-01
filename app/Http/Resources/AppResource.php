<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppResource extends JsonResource
{
    private ?string $message;
    private bool $status;

    public function __construct(?JsonResource $resource, ?string $message, bool $status)
    {
        parent::__construct($resource);

        $this->message = $message;
        $this->status = $status;
    }

    public static $wrap = 'data';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $res = $this->resource;

        if ($res != null && method_exists($res, 'jsonSerialize')) {
            $js = $res->jsonSerialize();
            if (isset($js['data'])) {
                $res = $js['data'];
            }
        }

        return [
            'data' => $res,
            'message' => $this->message,
            'status' => $this->status,
        ];
    }
}
