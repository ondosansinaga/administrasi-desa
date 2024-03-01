<?php

namespace App\Services\Model;

class AppEntity {
    private ?string $message;
    private bool $status;
    private mixed $data;

    public function __construct(
        ?string $message,
        bool $status,
        mixed $data,
    )
    {
        $this->message = $message;
        $this->status = $status;
        $this->data = $data;
    }

    public static function success(string $message, mixed $data):AppEntity
    {
        return new AppEntity(
            message: $message,
            status: true,
            data: $data,
        );
    }

    public static function error(string $message):AppEntity
    {
        return new AppEntity(
            message: $message,
            status: false,
            data: null,
        );
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function isStatus(): bool
    {
        return $this->status;
    }

    public function getData(): mixed
    {
        return $this->data;
    }


}
