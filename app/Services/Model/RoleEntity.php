<?php

namespace App\Services\Model;
class RoleEntity
{
    private int $id;
    private string $name;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(
        int    $id,
        string $name,
        string $createdAt,
        string $updatedAt,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

}
