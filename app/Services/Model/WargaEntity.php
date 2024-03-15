<?php

namespace App\Services\Model;

use App\Models\DataWarga;

class WargaEntity
{
    private ?int $id;
    private ?string $username;
    private ?string $password;
    private ?string $imageUrl;
    private ?string $nik;
    private ?string $kk;
    private ?string $rtrw;
    private ?string $desa;
    private ?string $kecamatan;
    private ?string $name;
    private ?string $birthInfo;
    private ?string $address;
    private bool $gender; // Change to no
    private ?string $status1;
    private ?string $status2;
    private ?string $statusPerkawinana;
    private ?string $jobTitle;
    private ?string $kewarganegaraan;
    private ?int $roleId;
    private ?int $createdBy;
    private ?int $updatedBy;
    private ?string $createdAt;
    private ?string $updatedAt;
    private ?RoleEntity $role;

    public function __construct(
        ?int $id = null,
        ?string $username= null,
        ?string $password = null,
        ?string $imageUrl = null , // Tambahkan tanda tanya (?) untuk mengizinkan null
        ?string $nik = null,
        ?string $kk = null,
        ?string $rtrw = null,
        ?string $desa = null,
        ?string $kecamatan = null,
        ?string $name = null,
        ?string $birthInfo = null,
        ?string $address = null,
        bool $gender = true, // Provide a default value here
        ?string $status1 = null,
        ?string $status2 = null,
        ?string $statusPerkawinana = null,
        ?string $jobTitle = null,
        ?string $kewarganegaraan = null,
        ?int $roleId = null,
        int $createdBy = 1,
        int $updatedBy = 1,
        ?string     $createdAt = null,
        ?string     $updatedAt = null,
        ?RoleEntity $role = null
        
        
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->imageUrl = $imageUrl;
        $this->nik = $nik;
        $this->kk = $kk;
        $this->rtrw = $rtrw;
        $this->desa = $desa;
        $this->kecamatan = $kecamatan;
        $this->name = $name;
        $this->birthInfo = $birthInfo;
        $this->address = $address;
        $this->gender = $gender; // Assign the default value here
        $this->status1 = $status1;
        $this->status2 = $status2;
        $this->statusPerkawinana = $statusPerkawinana;
        $this->jobTitle = $jobTitle;
        $this->kewarganegaraan = $kewarganegaraan;
        $this->roleId = $roleId;
        $this->createdBy = $createdBy;
        $this->updatedBy = $updatedBy;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->role = $role;
    }

    // Getter methods for the properties

    // Metode untuk membuat instance WargaEntity dari DataWarga
    public static function fromDataWarga(DataWarga $dataWarga): self
    {

        $roleEntity = new RoleEntity(
            $dataWarga->role->id,
            $dataWarga->role->name,
            $dataWarga->role->created_at,
            $dataWarga->role->updated_at,
        );
        // Mengambil nilai, jika null maka 1
        $createdByValue = $dataWarga->created_by ?? 1;
        $updatedByValue = $dataWarga->updated_by ?? 1;

        $wargaEntity = new self(
            $dataWarga->id,
            $dataWarga->username,
            $dataWarga->password,
            $dataWarga->image_url,
            $dataWarga->nik,
            $dataWarga->kk,
            $dataWarga->rtrw,
            $dataWarga->desa,
            $dataWarga->kecamatan,
            $dataWarga->name,
            $dataWarga->birth_info,
            $dataWarga->address,
            $dataWarga->gender,
            $dataWarga->status_1,
            $dataWarga->status_2,
            // Pengecekan jika statusPerkawinan null, ganti dengan string kosong
            $dataWarga->status_perkawinana,
            $dataWarga->job_title,
            $dataWarga->kewarganegaraan,
            $dataWarga->role_id,
            $createdByValue,
            $updatedByValue,
            role: $roleEntity,
        );

        return $wargaEntity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNik(): string
    {
        return $this->nik ?? ''; // Return empty string if $nik is null
    }

    public function getKk(): string
    {
        return $this->kk ?? '';
    }

    public function getRtrw(): string
    {
        return $this->rtrw ?? '';
    }

    public function getDesa(): string
    {
        return $this->desa ?? '';
    }

    public function getKecamatan(): string
    {
        return $this->kecamatan ?? '';
    }

    public function getName(): string
    {
        return $this->name ?? '';
    }

    public function getBirthInfo(): string
    {
        return $this->birthInfo ?? '';
    }

    public function getAddress(): string
    {
        return $this->address  ?? '';
    }

    public function getGender(): bool
    {
        return $this->gender;
    }

    public function getStatus1(): string
    {
        return $this->status1  ?? '';
    }

    public function getStatus2(): string
    {
        return $this->status2  ?? '';
    }

    public function getStatusPerkawinana(): string
    {
        return $this->statusPerkawinana  ?? '';
    }
    public function getJobTitle(): string
    {
        return $this->jobTitle  ?? '';
    }

    public function getKewarganegaraan(): string
    {
        return $this->kewarganegaraan  ?? '';
    }

    public function getRoleId(): int
    {
        return $this->roleId ?? 0;
    }

    public function setRoleId(?int $roleId): void
    {
        $this->roleId = $roleId;
    }

    public function getCreatedBy(): int
    {
        return $this->createdBy;
    }

    public function getUpdatedBy(): int
    {
        return $this->updatedBy;
    }

    public function getUsername(): string
    {
        return $this->username  ?? '';
    }
    
    public function getPassword(): string
    {
        return $this->password ?? '';
    }
    
    public function getImageUrl(): string
    {
        return $this->imageUrl ?? '';
    }

    public function getRole(): ?RoleEntity
    {
        return $this->role;
    }
    

    

    public function getCreatedAt(): string
    {
        return $this->createdAt  ?? '';
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt  ?? '';
    }

    public function toModel(): DataWarga
    {
        return DataWarga::find($this->id);
    }

    

    // You can add setter methods if needed
}
