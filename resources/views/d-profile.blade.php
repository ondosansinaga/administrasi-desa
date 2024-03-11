<style>
    .img-profile {
        width: 100%;
        height: 500px;
        border-radius: 8px;
        background: var(--red-primary);
        object-fit: cover;
    }

    .warga-header{
    align-items: center;
        background: var(--red-primary);
        border-radius: 16px;
        color: white;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 14px 20px;
        margin-bottom: 20px;
}

</style>

<div class="warga-header">
    <h3>{{ $title  }}</h3>
</div>

@php
    $isEdit = Session::get('isEdit') ?? false;
@endphp

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<div class="mt-4 profile-section">
    <div class="row">
        <div class="col-md-4 img-profile-section">

            <!-- Tombol untuk membuka modal -->
            <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#imageModal">
                <img class="img-profile img-fluid"
                     src="{{ $data->getImageUrl() ? url('/storage/images/profile/' . $data->getImageUrl()) : URL::asset('/assets/ic_profile.png') }}"
                     alt="Foto Profil">
            </button>

            <!-- Modal untuk menampilkan foto profil -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel">Foto Profil</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img class="img-fluid"
                                 src="{{ $data->getImageUrl() ? url('/storage/images/profile/' . $data->getImageUrl()) : URL::asset('/assets/ic_profile.png') }}"
                                 alt="Foto Profil">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 info-profile-section mt-3 mt-md-0">
            <form method="POST"
                  action="{{ route('profile.update', $data->getId()) }}"
                  enctype="multipart/form-data">
                @csrf

                @if($isEdit)
                    <div class="mb-3">
                        <label for="in-image" class="form-label">Foto</label>
                        <input id="in-image"
                               name="image"
                               class="form-control"
                               type="file"
                               accept=".png, .jpg, .jpeg">
                    </div>
                @endif

                <div class="mb-3">
                    <label for="in-nik" class="form-label {{ $isEdit ? 'mt-2' : '' }}">NIK</label>
                    <input id="in-nik"
                           name="nik"
                           class="form-control"
                           value="{{ $data->getNik() }}"
                           type="text"
                           {{ $isEdit ? '' : 'disabled' }}>
                </div>

                <div class="mb-3">
                    <label for="in-name" class="form-label mt-2">Nama</label>
                    <input id="in-name"
                           name="name"
                           class="form-control"
                           value="{{ $data->getName() }}"
                           type="text"
                           {{ $isEdit ? '' : 'disabled' }}>
                </div>

                <div class="mb-3">
                    <label for="in-gender" class="form-label mt-2">Jenis Kelamin</label>
                    <select id="in-gender"
                            name="gender"
                            class="form-select"
                            {{ $isEdit ? '' : 'disabled' }}>
                        <option value="1" {{ $data->getGender() == '1' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="0" {{ $data->getGender() == '0' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="in-address" class="form-label mt-2">Alamat</label>
                    <input id="in-address"
                           name="address"
                           class="form-control"
                           value="{{ $data->getAddress() }}"
                           type="text"
                           {{ $isEdit ? '' : 'disabled' }}>
                </div>

                <div class="mb-3">
                    <label for="in-birth" class="form-label mt-2">Tempat, Tanggal Lahir</label>
                    <input id="in-birth"
                           name="birth"
                           class="form-control"
                           value="{{ $data->getBirthInfo() }}"
                           type="text"
                           {{ $isEdit ? '' : 'disabled' }}>
                </div>

                <div class="mb-3">
                    <label for="in-job" class="form-label mt-2">Pekerjaan</label>
                    <input id="in-job"
                           name="job"
                           class="form-control"
                           value="{{ $data->getJobTitle() }}"
                           type="text"
                           {{ $isEdit ? '' : 'disabled' }}>
                </div>

                <div class="mb-3">
                    <label for="in-username" class="form-label mt-2">Username</label>
                    <input id="in-username"
                           class="form-control"
                           value="{{ $data->getUsername() }}"
                           type="text"
                           disabled>
                </div>

                @if($isEdit)
                    <div class="mb-3">
                        <label for="in-password" class="form-label mt-2">Password</label>
                        <input id="in-password"
                               name="password"
                               class="form-control"
                               value="{{ $data->getPassword() }}"
                               type="password">
                    </div>
                @endif

                <input id="btn-save-hidden" class="btn btn-primary mt-2" type="submit" value="Save" hidden>
            </form>
        </div>
    </div>

    <div class="profile-action-section mt-3">
        @if(!$isEdit)
            <form method="POST" action="{{ route('profile.edit',['isEdit'=>true]) }}">
                @csrf
                <button class="btn btn-primary" type="submit">Update</button>
            </form>
        @endif

        @if($isEdit)
            <form method="POST" action="{{ route('profile.edit',['isEdit'=>false]) }}">
                @csrf
                <button class="btn btn-secondary mt-2" type="submit">Cancel</button>
            </form>

            <button id="btn-save" class="btn btn-primary mt-2" type="submit">Save</button>
        @endif
    </div>
</div>



<script type="text/javascript">
    window.addEventListener('load', function () {
        messageDialog();
        handleSaveClick();
    });

    function handleSaveClick() {
        let btnSave = document.getElementById('btn-save-hidden');

        document.getElementById('btn-save')?.addEventListener('click', function () {
            btnSave?.click();
        });
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
</script>

