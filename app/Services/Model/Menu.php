<?php

namespace App\Services\Model;

enum Menu: string {
    case BERITA = 'Berita';
    case USERS = 'Pengguna';
    case PENGAJUAN = 'Pengajuan Surat';
    case PROFILE = 'Profil Saya';

    public function page():string {
        return match($this)
        {
            Menu::BERITA => 'd-berita',
            Menu::USERS => 'd-users',
            Menu::PENGAJUAN => 'd-pengajuan-surat',
            Menu::PROFILE => 'd-profile',
        };
    }
}
