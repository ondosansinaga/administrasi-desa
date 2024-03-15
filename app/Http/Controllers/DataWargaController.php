<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WargaService;
use App\Services\Model\WargaEntity;
use App\Services\DataWargaService;
use App\Models\DataWarga;
use App\Services\Model\Menu;
use Illuminate\Support\Facades\Session;
use App\Helpers\Constants;
use Carbon\Carbon;
use App\Models\Role;
use App\Services\Model\RoleEntity;
use App\Events\WargaUpdated;
use App\Services\UserService;
use App\Services\Model\UserEntity;





class DataWargaController extends Controller
{
    private WargaService $wargaService;

    public function __construct(WargaService $wargaService)
    {
        $this->wargaService = $wargaService;
    }

    public function index()
    {
        $dataWarga = DataWarga::paginate(10); // Ambil semua data dari tabel data_warga
        Session::put('wargaValue', $warga); // Simpan data dalam session
        $title = 'Data Warga'; // Judul halaman
        return view('d-warga', compact('dataWarga', 'title'));
    }

    public function showDataWargaById(Request $request, int $id){
        $isEdit = $request->input('isEdit') ?? false;
        $dest = redirect('/?menu=' . Menu::WARGA->value);

        if (!$id || !is_numeric($id)) {
            return $dest;
        }

        $wargaEntity = $this->wargaService->getWargaById($id);

        if (!$wargaEntity) {
            return $dest->with(
                [
                    'message' => [
                        'error' => 'Warga tidak ditemukan.',
                    ],
                ]
            );
        }

        $warga = $wargaEntity->getData();

        return $dest->with(
            [
                'wargaValue' => $warga,
                'isEdit' => $isEdit,
            ]
        );
    }

    public function updateWargaByid(Request $request, int $id){
        $updatedBy = Session::get(Constants::$KEY_USER_ID);

        $image = $request->file('image') ?? null;
        $nik = $request->input('nik') ?? null;
        $password = $request->input('password') ?? null;
        $name = $request->input('name') ?? null;
        $kk = $request->input('kk') ?? null;
        $rtrw = $request->input('rtrw') ?? null;
        $desa = $request->input('desa') ?? null;
        $kecamatan = $request->input('kecamatan') ?? null;
        $gender = $request->input('gender') ? true : false; // Ensure gender is bool
        $address = $request->input('address') ?? null;
        $ttl = $request->input('birth') ?? null;
        $job = $request->input('job') ?? null;
        $statPerkaw = $request->input('statusPerkawinan');
        $status1 = $request->input('status1') ?? null;
        $status2 = $request->input('status2') ?? null;
        $kewarganegaraan = $request->input('kewarganegaraan') ?? null;
        

        $dest = redirect ('/?menu=' . Menu::WARGA->value);

        if (!$id || !is_numeric($id)) {
            return $dest;
        }

        if ($image && !$image->getSize()) {
            return $dest->with(
                [
                    'message' => [
                        'error' => 'Ukuran gambar tidak boleh lebih dari 2 mb.',
                    ],
                ]
            );
        }

        if(!preg_match(Constants::$BIRTH_PATTERN, $ttl)) {
            return $dest->with([
                'message' => [
                    'error' => 'TTL hanya menerima pola "Tempat,Hari-Bulan-Tahun".',
                ]
            ]);
        }

        

        $imagePath = null;

        if ($image) {
            $imageName = $nik . '.' . 'png';

            $image->storeAs('public/images/profile', $imageName);
            $imagePath = $imageName;
        }

        $wargaEntity = new WargaEntity(
            id: $id,
            name: $name,
            kk: $kk,
            rtrw: $rtrw,
            desa: $desa,
            kecamatan: $kecamatan,
            password: $password,
            address: $address,
            imageUrl: $imagePath,
            updatedAt: now(),
            updatedBy: $updatedBy,
            nik: $nik,
            birthInfo: $ttl,
            jobTitle: $job,
            gender: $gender,
            statusPerkawinana: $statPerkaw, // Ubah menjadi 'statusPerkawinan'
            status1: $status1,
            status2: $status2,
            kewarganegaraan: $kewarganegaraan,
        );

        $appEntity = $this->wargaService->updateWarga($wargaEntity);

        if (!$appEntity->isStatus()) {
            return $dest->with(
                [
                    'message' => [
                        'error' => $appEntity->getMessage(),
                    ],
                ]
            );
        }

        // Membuat instance DataWarga dari WargaEntity
        $dataWarga = $wargaEntity->toModel();

        // Panggil event WargaUpdated setelah proses update
        event(new WargaUpdated($dataWarga));

        return $dest->with(
            [
                'message' => [
                    'success' => $appEntity->getMessage(),
                ],
            ]
        );
    }

    public function deleteWargaById(int $id){
        $dest = redirect('/?menu=' . Menu::WARGA->value);

        if (!$id || !is_numeric($id)) {
            return $dest;
        }

        $appEntity = $this->wargaService->deleteWargaById($id);

        return $dest->with(
            [
                'message' => [
                    'success' => $appEntity->getMessage(),
                ],
            ]
        );
    }

    public function tambahWarga(Request $request)
    {
        $nik = $request->input('nik') ?? null;
        $kk = $request->input('kk') ?? null;
        $rtrw = $request->input('rtrw') ?? null;
        $desa = $request->input('desa') ?? null;
        $kecamatan = $request->input('kecamatan') ?? null;
        $name = $request->input('name') ?? null;
        $username = $request->input('username') ?? null;
        $password = $request->input('password') ?? null;
        $ttl = $request->input('birth') ?? null;
        $gender = $request->input('gender') ?? null;
        $address = $request->input('address') ?? null;
        $status1 = $request->input('status1') ?? null;
        $status2 = $request->input('status2') ?? null;
        $job = $request->input('job') ?? null;
        $perkawinana = $request->input('statusPerkawinan') ?? null;
        $kewarganegaraan = $request->input('kewarganegaraan') ?? null;
        $creatorId = Session::get(Constants::$KEY_USER_ID);
    
        $dest = redirect('/?menu=' . Menu::WARGA->value);
    
        if (!$creatorId) {
            return redirect('/login');
        }
    
        $role = Role::find(2); // Mendapatkan data role dengan ID 2 (Warga)
    
        if (!$role) {
            return $dest->with(
                [
                    'message' => [
                        'error' => 'Role tidak ditemukan.',
                    ],
                ]
            );
        }
    
        // Membuat objek RoleEntity dari objek Role
        $roleEntity = new RoleEntity(
            $role->id,
            $role->name,
            $role->created_at,
            $role->updated_at,
            
        );
    
        $wargaEntity = new WargaEntity(
            nik: $nik,
            kk: $kk,
            rtrw: $rtrw,
            desa: $desa,
            kecamatan: $kecamatan,
            name: $name,
            username: $username,
            password: $password,
            birthInfo: $ttl,
            gender: $gender,
            address: $address,
            status1: $status1,
            status2: $status2,
            jobTitle: $job,
            statusPerkawinana: $perkawinana,
            kewarganegaraan: $kewarganegaraan,
            createdAt: now(),
            createdBy: $creatorId,
            updatedBy: $creatorId,
            roleId: 2, // Menggunakan objek RoleEntity sebagai parameter role
        );
    
        $appEntity = $this->wargaService->createWarga($wargaEntity);
    
        if (!$appEntity->isStatus()) {
            return $dest->with(
                [
                    'message' => [
                        'error' => 'Gagal menambahkan warga.',
                    ],
                ]
            );
        }
    
        return $dest->with(
            [
                'message' => [
                    'success' => 'Berhasil menambahkan warga.',
                ],
            ]
        );
    }


    public function searchWarga(Request $request)
    {
        $kk = $request->input('kk') ?? null;

        // Query untuk mencari data berdasarkan Nomor KK
        $dataWarga = DataWarga::where('kk', 'LIKE', "%$kk%")->paginate(10);

        $title = 'Hasil Pencarian Data Warga'; // Judul halaman
        
        return view('search-warga', compact('dataWarga', 'title'));
    }
    

    



}