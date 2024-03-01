<?php

namespace App\Services\Model;

use App\Models\User;

class UserEntity
{
    private ?string $id;
    private ?string $username;
    private ?string $password;
    private ?string $name;
    private ?string $nik;
    private ?string $birthInfo;
    private ?string $jobTitle;
    private bool $gender;
    private ?string $address;
    private ?string $imageUrl;
    private ?string $createdAt;
    private ?string $updatedAt;
    private ?int $roleId;
    private ?int $createdBy;
    private ?int $updatedBy;
    private ?RoleEntity $role;

    public function __construct(
        ?string $id = null,
        ?string     $username = null,
        ?string     $password = null,
        ?string     $name = null,
        ?string     $address = null,
        ?string     $imageUrl = null,
        ?string     $createdAt = null,
        ?string     $updatedAt = null,
        ?int        $roleId = null,
        ?string     $createdBy = null,
        ?string     $updatedBy = null,
        ?string     $nik = null,
        ?string     $birthInfo = null,
        ?string     $jobTitle = null,
        bool        $gender = true,
        ?RoleEntity $role = null,
    )
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
        $this->address = $address;
        $this->imageUrl = $imageUrl;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->roleId = $roleId;
        $this->createdBy = $createdBy;
        $this->updatedBy = $updatedBy;
        $this->nik = $nik;
        $this->birthInfo = $birthInfo;
        $this->jobTitle = $jobTitle;
        $this->gender = $gender;
        $this->role = $role;
    }

    public static function fromUser(User $user): UserEntity
    {
        $roleEntity = new RoleEntity(
            $user->role->id,
            $user->role->name,
            $user->role->created_at,
            $user->role->updated_at,
        );

        return new UserEntity(
            id: $user->id,
            username: $user->username,
            password: $user->password,
            name: $user->name,
            address: $user->address,
            imageUrl: $user->image_url,
            createdAt: $user->created_at,
            updatedAt: $user->updated_at,
            roleId: $user->role_id,
            createdBy: $user->created_by,
            updatedBy: $user->updated_by,
            nik: $user->nik,
            birthInfo: $user->birth_info,
            jobTitle: $user->job_title,
            gender: $user->gender,
            role: $roleEntity,
        );
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getNik(): ?string
    {
        return $this->nik;
    }

    public function getBirthInfo(): ?string
    {
        return $this->birthInfo;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function getGender(): bool
    {
        return $this->gender;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function getCreatedBy(): ?int
    {
        return $this->createdBy;
    }

    public function getUpdatedBy(): ?int
    {
        return $this->updatedBy;
    }

    public function getRole(): ?RoleEntity
    {
        return $this->role;
    }

}
