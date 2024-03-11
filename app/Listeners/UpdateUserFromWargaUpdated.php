<?php

namespace App\Listeners;

use App\Events\WargaUpdated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUserFromWargaUpdated
{
    /**
     * Handle the event.
     *
     * @param  WargaUpdated  $event
     * @return void
     */
    public function handle(WargaUpdated $event)
    {
        // Ambil data warga dari event
        $warga = $event->warga;

        // Cari user berdasarkan user_id dari data warga
        $user = User::find($warga->user_id);

        if ($user) {
            // Update nama user dengan nama dari data warga
            $user->name = $warga->name;
            $user->address = $warga->address;
            $user->job_title = $warga->job_title;
            $user->birth_info = $warga->birth_info;
            $user->nik = $warga->nik;
            // Tambahkan logika update field lain sesuai kebutuhan

            // Simpan perubahan pada user
            $user->save();
        }
    }
}