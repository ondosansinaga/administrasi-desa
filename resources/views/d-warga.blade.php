<style>
    .img-profile {
        width: 200px;
        height: 200px;
        border-radius: 8px;
        background: var(--red-primary);
        object-fit: contain;
    }

    .item-user {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: row;
        border-radius: 8px;
        box-shadow: 0 0 4px grey;
        padding: 10px;
    }

    .item-user-action {
        display: flex;
        flex-direction: row;
        gap: 20px;
        justify-content: center;
    }

    .item-user-content {
        display: flex;
        flex: 1;
        flex-direction: column;
        justify-content: start;
    }

    .item-user-image {
        width: 200px;
        height: 200px;
        background-color: var(--red-primary);
        object-fit: contain;
        border-radius: 8px;
    }

    .item-user-label {
        font-size: 12px;
    }

    .item-user-value {
        font-weight: bold;
    }

    .small-btn {
        height: 30px;
        padding: 5px 20px;
        font-size: 14px;
    }

   

    .status-value-modal{
        margin-left: 10px;
    }

    .status-value-modal-edit{
        margin-left: 30px;
    }
    
    .container {
    display: flex;
    flex-wrap: wrap;
}

.data-box {
    width: calc(25% - 20px);
    padding: 30px;
    margin: 10px;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

.data-info {
    margin-bottom: 20px;
}

.info-item {
    display: flex;
    align-items: center;
    margin-bottom: 6px;
}

.info-label {
    width: 70px;
    font-weight: bold;
}

.info-value {
    flex: 1;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1); /* Garis pembatas */
    margin-bottom: 8px;
}

.data-action {
    text-align: left;
}

.info-item-status {
    width: 100%;
    margin-left: 20px;
}

.row {
    margin-right: 0;
}

.tambah-warga{
    width: 100px;
}

.warga-header{
    align-items: center;
        background: var(--red-primary);
        border-radius: 16px;
        color: white;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 10px 20px;
        margin-bottom: 20px;
}


    

</style>

@php
    $warga = Session::get('wargaValue') ?? null;
@endphp





<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Warga</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('warga.add') }}">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input id="nik" name="nik" class="form-control" type="text" required>
                    </div>

                    <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input id="username" name="username" class="form-control" type="text" required>
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="in-password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" id="in-passwordAdd">
                            <span class="input-group-text" id="togglePasswordAdd" style="cursor: pointer;">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input id="name" name="name" class="form-control" type="text" required>
                    </div>

                    <div class="mb-3">
                            <label for="birth" class="form-label">Tempat/Tanggal Lahir</label>
                            <input id="birth" name="birth" class="form-control" type="text" required>
                    </div>

                    <div class="mb-3">
                    <label for="in-gender" class="form-label">Jenis Kelamin</label>
                        <select name="gender" id="in-gender" class="form-select">
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="1">Laki-Laki</option>
                            <option value="0">Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <input id="address" name="address" class="form-control" type="text" required>
                    </div>


                    <div class="mb-3">
                        <div class="row align-items-center">
                            <div class="col-1">
                                <label for="edit-status" class="form-label">Status</label>
                            </div>
                            <div class="col status-value-modal-edit">
                                <select name="status1" id="status1" class="form-select" onchange="disablePlaceholderOption('edit-status1')">
                                    <option value="" disabled selected>Pilih Status 1</option>
                                    <option value="Kelahiran">Kelahiran</option>
                                    <option value="Masuk" >Masuk</option>
                                    <option value="Keluar" >Keluar</option>
                                    <option value="Kematian" >Kematian</option>
                                </select>
                            </div>
                            <div class="col status-value-modal">
                                <select name="status2" id="status2" class="form-select" onchange="disablePlaceholderOption('edit-status2')">
                                    <option value="" disabled selected>Pilih Status 2</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif" >Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit-job" class="form-label">Pekerjaan</label>
                        <input name="job" type="text" class="form-control" id="edit-job">
                    </div>

                    <div class="mb-4">
                        <label for="edit-statPerkaw" class="form-label">Status Perkawinan</label>
                        <select type="text" name="statusPerkawinan" id="edit-statPerkaw" class="form-select" onchange="disablePlaceholderOption()">
                            <option value="" disabled selected>Pilih Status Perkawinan</option>
                            <option value="Belum Kawin" >Belum Kawin</option>
                            <option value="Kawin">Kawin</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit-kewarganegaraan" class="form-label">Kewarganegaraan</label>
                        <input name="kewarganegaraan" type="text" class="form-control" id="edit-kewarganegaraan">
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal View -->
@if(isset($warga))
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="modalViewLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Warga - {{$warga->getName()}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="in-nik" class="form-label">NIK</label>
                    <input type="text" class="form-control" id="in-nik" value="{{ $warga->getNik() }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="in-username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="in-nik" value="{{ $warga->getUsername() }}" disabled>
                </div>

                <div class="mb-3 position-relative">
                    <label for="in-password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="in-passwordView" value="{{ $warga->getPassword() }}" disabled>
                        <span class="input-group-text" id="togglePasswordView" style="cursor: pointer;">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>



                <div class="mb-3">
                    <label for="in-name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="in-name" value="{{ $warga->getName() }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="in-birth" class="form-label">Tempat/Tanggal Lahir</label>
                    <input type="text" class="form-control" id="in-birth" value="{{ $warga->getBirthInfo() }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="in-gender" class="form-label">Jenis Kelamin</label>
                    <select name="gender" id="in-gender" class="form-select" disabled>
                        <option value="1"{{ $warga->getGender() == '1' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="0"{{ $warga->getGender() == '0' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="in-address" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="in-address" value="{{ $warga->getAddress() }}" disabled>
                </div>

                <div class="mb-3">
                    <div class="row align-items-center">
                        <div class="col-1">
                            <label for="status" class="form-label">Status</label>
                        </div>
                        <div class="col status-value-modal">
                            <input type="text" class="status-value mb-1 form-control" value="{{ $warga->getStatus1() }}" disabled>
                            <input type="text" class="status-value mb-1 form-control" value="{{ $warga->getStatus2() }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="in-job" class="form-label">Pekerjaan</label>
                    <input type="text" class="form-control" id="in-statusPerkawinan" value="{{ $warga->getJobTitle() }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="in-statusPerkawinan" class="form-label">Status Perkawinan</label>
                    <input type="text" class="form-control" id="in-statusPerkawinan" value="{{ $warga->getStatusPerkawinana() }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="in-kewarganegaraan" class="form-label">Kewarganegaraan</label>
                    <input type="text" class="form-control" id="in-kewarganegaraan" value="{{ $warga->getKewarganegaraan() }}" disabled>
                </div>

                
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal Edit -->
@if(isset($warga))
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Warga - {{ $warga->getName() }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('warga.update', $warga->getId()) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="edit-nik" class="form-label">NIK</label>
                        <input id="edit-nik" name="nik" class="form-control" value="{{ $warga->getNik() }}" type="text">
                    </div>

                   
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Nama</label>
                        <input id="name" name="name" class="form-control" value="{{ $warga->getName() }}" type="text">
                    </div>

                    <div class="mb-3">
                        <label for="edit-birth" class="form-label">Tempat/Tanggal Lahir</label>
                        <input name="birth" type="text" class="form-control" id="edit-birth" value="{{ $warga->getBirthInfo() }}">
                    </div>

                    <div class="mb-3">
                        <label for="edit-address" class="form-label">Alamat</label>
                        <input name="address" type="text" class="form-control" id="edit-address" value="{{ $warga->getAddress() }}">
                    </div>
                    
                    <div class="mb-4">
                        <label for="edit-statPerkaw" class="form-label">Status Perkawinan</label>
                        <select type="text" name="statusPerkawinan" id="edit-statPerkaw" class="form-select" onchange="disablePlaceholderOption()">
                            <option value="" disabled selected>Pilih Status Perkawinan</option>
                            <option value="Belum Kawin" {{ $warga->getStatusPerkawinana() === 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="Kawin" {{ $warga->getStatusPerkawinana() === 'Kawin' ? 'selected' : '' }}>Kawin</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <div class="row align-items-center">
                            <div class="col-1">
                                <label for="edit-status" class="form-label">Status</label>
                            </div>
                            <div class="col status-value-modal-edit">
                                <select name="status1" id="edit-status1" class="form-select" onchange="disablePlaceholderOption('edit-status1')">
                                    <option value="" disabled selected>Pilih Status 1</option>
                                    <option value="Kelahiran" {{ $warga->getStatus1() == "Kelahiran" ? 'selected' : '' }}>Kelahiran</option>
                                    <option value="Masuk" {{ $warga->getStatus1() == "Masuk" ? 'selected' : '' }}>Masuk</option>
                                    <option value="Keluar" {{ $warga->getStatus1() == "Keluar" ? 'selected' : '' }}>Keluar</option>
                                    <option value="Kematian" {{ $warga->getStatus1() == "Kematian" ? 'selected' : '' }}>Kematian</option>
                                </select>
                            </div>
                            <div class="col status-value-modal">
                                <select name="status2" id="edit-status2" class="form-select" onchange="disablePlaceholderOption('edit-status2')">
                                    <option value="" disabled selected>Pilih Status 2</option>
                                    <option value="Aktif" {{ $warga->getStatus2() == "Aktif" ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tidak Aktif" {{ $warga->getStatus2() == "Tidak Aktif" ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit-job" class="form-label">Pekerjaan</label>
                        <input name="job" type="text" class="form-control" id="edit-job" value="{{ $warga->getJobTitle() }}">
                    </div>

                    <div class="mb-3">
                        <label for="edit-kewarganegaraan" class="form-label">Kewarganegaraan</label>
                        <input name="kewarganegaraan" type="text" class="form-control" id="edit-kewarganegaraan" value="{{ $warga->getKewarganegaraan() }}">
                    </div>

                </div>
                <div class="modal-footer">
                    <div>
                        <input type="submit" value="Update" class="btn btn-primary"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<div class="warga-header">
    <h3>Data Warga</h3>
    <div>
        <input class="my-btn-secondary"
               type="button"
               value="Tambah"
               data-bs-toggle="modal"
               data-bs-target="#addModal">
    </div>
</div>

<!-- Show All -->
<div class="row container">
    @forelse($data as $d)
        <div class="data-box">
            <div class="data-info">
                <div class="info-item">
                    <div class="info-label">NIK:</div>
                    <div class="info-value">{{ $d->getNik() }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Nama:</div>
                    <div class="info-value">{{ $d->getName() }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Status:</div>
                    <div class="info-item-status">
                        <p class="info-value">{{ $d->getStatus1() }}</p>
                        <!-- <div class="status1"></div> -->
                        <p>{{ $d->getStatus2() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="item-user-action mt-2">
                <form method="POST" action="{{ route('warga.show', $d->getId()) }}">
                    @csrf
                    <button class="btn btn-primary me-2" type="submit">Lihat</button>
                    <input type="hidden" name="isEdit" value="{{ false }}">
                </form>

                @if($d->getRole()->getId() != 1)
                    <form method="POST" action="{{ route('warga.show', $d->getId()) }}">
                        @csrf
                        <button class="btn btn-primary me-2" type="submit">Ubah</button>
                        <input type="hidden" name="isEdit" value="{{ true }}">
                    </form>

                    <form method="POST" action="{{ route('warga.delete', $d->getId()) }}">
                            @csrf
                            <button class="btn btn-danger" type="submit">Hapus</button>
                        </form>
                    
                @endif
            </div>
        </div>
    @empty
        <div class="data-box">
            <div class="data-info">
                <div class="info-item">
                    <div class="info-value">Data Warga Kosong</div>
                </div>
            </div>
        </div>
    @endforelse
</div>




@php
    $isEdit = Session::get('isEdit') ?? false;
@endphp

<script type="text/javascript">
    window.addEventListener('load', function () {
        userDialog();
        messageDialog();
    });

    function userDialog() {
        let isEdit = {!! json_encode($isEdit) !!};
        let viewWarga = {!! json_encode($warga) !!};

        if (!viewWarga) return;

        if (isEdit) {
            console.log('edit');
            let modal = new bootstrap.Modal(document.getElementById('editModal'), {
                keyboard: false,
                backdrop: 'static'
            });
            modal.show();
        } else {
            console.log('view');
            let modal = new bootstrap.Modal(document.getElementById('viewModal'), {
                keyboard: false,
                backdrop: 'static'
            });
            modal.show();
        }
    }

    function messageDialog() {
        let message = {!! json_encode($message) !!};
        let successMessage = message?.success ?? null;
        let errorMessage = message?.error ?? null;

        if (successMessage) {
            showSuccessMessage(successMessage)
        }

        if (errorMessage) {
            showErrorMessage(errorMessage)
        }
    }

    function disablePlaceholderOption() {
        var selectElement = document.getElementById("edit-statPerkaw");
        var placeholderOption = selectElement.options[0];

        // Jika opsi pertama terpilih, nonaktifkan opsi "Pilih Status Perkawinan"
        if (placeholderOption.selected) {
            placeholderOption.disabled = true;
        }
    }

    function disablePlaceholderOption(selectId) {
        var selectElement = document.getElementById(selectId);
        var placeholderOption = selectElement.options[0];

        // Jika opsi pertama terpilih, nonaktifkan opsi "Pilih Status 1" atau "Pilih Status 2"
        if (placeholderOption.selected) {
            placeholderOption.disabled = true;
        }
    }

    const togglePasswordAdd = document.querySelector('#togglePasswordAdd');
        const passwordInputAdd = document.querySelector('#in-passwordAdd');

        togglePasswordAdd.addEventListener('click', function() {
            const type = passwordInputAdd.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInputAdd.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        const togglePasswordView = document.querySelector('#togglePasswordView');
        const passwordInputView = document.querySelector('#in-passwordView');

        togglePasswordView.addEventListener('click', function() {
            const type = passwordInputView.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInputView.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    
</script>



