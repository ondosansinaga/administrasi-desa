<?php

namespace App\Services\Impl;

use App\Models\DataWarga;
use App\Services\WargaService;
use App\Services\Model\WargaEntity;
use App\Services\Model\AppEntity;
use Illuminate\Support\Facades\Log;


class WargaServiceImpl implements WargaService {
    
    //Semua Warga
    public function getWarga(?int $page): mixed {
        $perPage = 10;
        $wargas = DataWarga::latest()->paginate($perPage, ['*'], 'page', $page);
        $wargaEntities = $wargas->map(function ($warga){

             // Log pesan sebelum membuat instance WargaEntity
             Log::info('Creating WargaEntity from DataWarga', ['data_warga' => $warga]);

            return WargaEntity::fromDataWarga($warga);

             // Log pesan setelah membuat instance WargaEntity
             Log::info('WargaEntity created', ['warga_entity' => $wargaEntity]);

             return $wargaEntity;
        });

        return $wargaEntities;
    }

    //Warga berdasarkan Id
    public function getWargaById(?int $id): AppEntity{
        $warga = DataWarga::find($id);

        if (!$warga) {
            return AppEntity::error('Warga dengan Id'. $id . 'tidak ditemukan');
        }

        $wargaEntity = WargaEntity::fromDataWarga($warga);
        return AppEntity::success('Berhasil mendapatkan data warga', $wargaEntity);
    }

    //Update Warga
    public function updateWarga(WargaEntity $wargaEntity): AppEntity{
        $id = $wargaEntity->getId();
        $warga = DataWarga::find($id);

        if (!$warga) {
            return AppEntity::error('Warga dengan Id '. $id . 'tidak ditemukan');
        }

        $warga->update([
            'nik' => $wargaEntity->getNik() ?? $warga->nik,
            'password' => $wargaEntity->getPassword() ?? $warga->password,
            'imageUrl' => $wargaEntity->getImageUrl() ?? $warga->imageUrl,
            'name' => $wargaEntity->getName() ?? $warga->name,
            'birth_info' => $wargaEntity->getBirthInfo() ?? $warga->birth_info,
            'address' => $wargaEntity->getAddress() ?? $warga->address,
            'status_1' => $wargaEntity->getStatus1() ?? $warga->status1,
            'status_2' => $wargaEntity->getStatus2() ?? $warga->status2,
            'status_perkawinana' => $wargaEntity->getStatusPerkawinana() ?? $warga->status_perkawinana,
            'job_title' => $wargaEntity->getJobTitle() ?? $warga->job_title,
            'kewarganegaraan' => $wargaEntity->getKewarganegaraan() ?? $warga->kewarganegaraan,
            'updated_at' => now(),
            'updated_by' => $wargaEntity->getUpdatedBy(),
        ]);

        return AppEntity::success('Berhasil mengubah data warga', null);
    }

    //Tambah Warga
    public function createWarga(WargaEntity $wargaEntity): AppEntity{
        $warga = DataWarga::create([
            'username' => $wargaEntity->getUsername(),
            'password' => $wargaEntity->getPassword(),
            'nik' => $wargaEntity->getNik(),
            'name' => $wargaEntity->getName(),
            'birth_info' => $wargaEntity->getBirthInfo(),
            'address' => $wargaEntity->getAddress(),
            'gender' => $wargaEntity->getGender(),
            'status_1' => $wargaEntity->getStatus1(),
            'status_2' => $wargaEntity->getStatus2(),
            'status_perkawinana' => $wargaEntity->getStatusPerkawinana(),
            'job_title' => $wargaEntity->getJobTitle(),
            'kewarganegaraan' => $wargaEntity->getKewarganegaraan(),
            'role_id' => $wargaEntity->getRoleId(),
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => $wargaEntity->getCreatedBy(),
            'updated_by' => $wargaEntity->getUpdatedBy(),
        ]);

        return AppEntity::success('Berhasil menambahkan data warga', WargaEntity::fromDataWarga($warga));
    }

    //Hapus Warga By Id
    public function deleteWargaById(?int $id): AppEntity{
        $warga = DataWarga::find($id);

        if (!$warga) {
            return AppEntity::error('Warga dengan Id'. $id . 'tidak ditemukan');
        }

        $warga->delete();
        return AppEntity::success('Berhasil menghapus data warga dengan Id '. $id. '.', null);
    }

}


