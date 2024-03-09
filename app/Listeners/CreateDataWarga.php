<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\DataWarga;
use Illuminate\Support\Facades\Log; // Perlu diimpor untuk menggunakan Log


class CreateDataWarga implements ShouldQueue
{
   
    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event)
    {
        $user = $event->userEntity;

        // Log pesan untuk memeriksa apakah event dipicu dan data benar
        Log::info('UserRegistered event triggered.', ['user_entity' => $user]);

        $dataWarga = DataWarga::create([
            'nik' => $user->getNik(),
            'name' => $user->getName(),
            'birth_info' => $user->getBirthInfo(),
            'address' => $user->getAddress(),
            'job_title' => $user->getJobTitle(),
            'user_id' => $user->getId(), // Tambahkan user_id untuk relasi dengan tabel 'users
            'created_by' => $user->getCreatedBy(), // Tambahkan created_by untuk relasi dengan tabel 'users'
            'updated_by' => $user->getUpdatedBy(), // Tambahkan updated_by untuk relasi dengan tabel 'users
            'role_id' => $user->getRoleId(),
            'gender' => $user->getGender(),
        ]);

        // // Set user_id based on the created DataWarga instance
        // $dataWarga->user_id = $user->getId();
        // $dataWarga->save();

        // // Pastikan $dataWarga tidak null sebelum mengatur user_id
        // if ($dataWarga) {
        //     // Set user_id based on the created DataWarga instance
        //     $dataWarga->user_id = $user->getId();
        //     $dataWarga->save();
        // } else {
        //     Log::error('Failed to create DataWarga instance.');
        // }

         // Set user_id based on the created DataWarga instance
         $dataWarga->user()->associate($user->getId())->save();
    }
}
