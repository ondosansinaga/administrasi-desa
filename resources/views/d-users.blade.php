<style>
    .img-profile {
        width: 200px;
        height: 200px;
        border-radius: 8px;
        background: var(--red-primary);
        object-fit: cover;
    }

    .item-user {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-direction: row;
        border-radius: 8px;
        flex-wrap: wrap;

        padding: 10px;
    }

    .item-user-action {
        display: flex;
        flex-direction: row;
        gap: 10px;
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
        object-fit: cover;
        border-radius: 8px;
    }

    .item-user-label {
        font-size: 12px;
    }

    .item-user-value {
        font-weight: bold;
    }

    .list-content {
        height: calc(100vh - (<?= $data->lastPage() == 1 ? '150px': '200px'?>));
        overflow: scroll;
        padding: 10px;
    }

    .small-btn {
        height: 30px;
        padding: 5px 20px;
        font-size: 14px;
    }

    .user-li {
        border-radius: 8px;
        padding: 10px;
        background-color: var(--white-primary);
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
    }

    .list-group {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 20px;
    }


    .warga-header{
    align-items: center;
        background: var(--red-primary);
        border-radius: 16px;
        color: white;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding:14px 20px;
        margin-bottom: 20px;
    }

    .content {
        padding: 20px;


</style>

@php
    $user = Session::get('userValue') ?? null;
@endphp

    <!-- Modal View-->
@if(isset($user))
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pengguna - {{ $user->getUsername() }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img class="img-fluid img-profile"
                         src="{{ $user->getImageUrl() ? url('/storage/images/profile/' . $user->getImageUrl() ): URL::asset('/assets/ic_profile.png') }}"
                         alt="Foto Profil">
                </div>

                <div class="mt-3">
                    <label for="in-nik" class="form-label">NIK</label>
                    <input id="in-nik"
                           class="form-control"
                           value="{{ $user->getNik()  }}"
                           type="text"
                           disabled>
                </div>

                <div class="mt-3">
                    <label for="in-name" class="form-label">Nama</label>
                    <input id="in-name"
                           class="form-control"
                           value="{{ $user->getName()  }}"
                           type="text"
                           disabled>
                </div>

                <div class="mt-3">
                    <label for="in-gender" class="form-label">Jenis Kelamin</label>
                    <select id="in-gender" class="form-select" name="gender" disabled>
                        <option value="1" {{ $user->getGender() == '1'? 'selected' : ''  }}>Laki-Laki</option>
                        <option value="0" {{ $user->getGender() == '0'? 'selected' : ''  }}>Perempuan</option>
                    </select>
                </div>

                <div class="mt-3">
                    <label for="in-address" class="form-label">Alamat</label>
                    <input id="in-address"
                           class="form-control"
                           value="{{ $user->getAddress()  }}"
                           type="text"
                           disabled>
                </div>

                <div class="mt-3">
                    <label for="in-birth" class="form-label">Tempat, Tanggal Lahir</label>
                    <input id="in-birth"
                           class="form-control"
                           value="{{ $user->getBirthInfo()  }}"
                           type="text"
                           disabled>
                </div>

                <div class="mt-3">
                    <label for="in-job" class="form-label">Pekerjaan</label>
                    <input id="in-job"
                           class="form-control"
                           value="{{ $user->getJobTitle()  }}"
                           type="text"
                           disabled>
                </div>
            </div>
        </div>
    </div>
</div>

@endif

<!-- Modal Edit-->
@if(isset($user))
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pengguna - {{ $user->getUsername() }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('users.update', $user->getId()) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label for="in-image" class="form-label">Foto</label>
                    <input id="in-image"
                           name="image"
                           class="form-control"
                           type="file"
                           accept=".png, .jpg, .jpeg"
                           value="{{ $user->getImageUrl() }}"
                    >

                    <div class="mt-3">
                        <label for="in-nik" class="form-label">NIK</label>
                        <input id="in-nik"
                               name="nik"
                               class="form-control"
                               value="{{ $user->getNik() }}"
                               type="text"
                        >
                    </div>

                    <div class="mt-3">
                        <label for="in-name" class="form-label">Nama</label>
                        <input id="in-name"
                               name="name"
                               class="form-control"
                               value="{{ $user->getName() }}"
                               type="text"
                        >
                    </div>

                    <div class="mt-3">
                        <label for="in-gender" class="form-label">Jenis Kelamin</label>
                        <select id="in-gender"
                                name="gender"
                                class="form-select"
                        >
                            <option value="1" {{ $user->getGender() == '1' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="0" {{ $user->getGender() == '0' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label for="in-address" class="form-label">Alamat</label>
                        <input id="in-address"
                               name="address"
                               class="form-control"
                               value="{{ $user->getAddress() }}"
                               type="text"
                        >
                    </div>

                    <div class="mt-3">
                        <label for="in-birth" class="form-label">Tempat, Tanggal Lahir</label>
                        <input id="in-birth"
                               name="birth"
                               class="form-control"
                               value="{{ $user->getBirthInfo() }}"
                               type="text"
                        >
                    </div>

                    <div class="mt-3">
                        <label for="in-job" class="form-label">Pekerjaan</label>
                        <input id="in-job"
                               name="job"
                               class="form-control"
                               value="{{ $user->getJobTitle() }}"
                               type="text"
                        >
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
    <h3>{{$title}}</h3>
</div>


<div class="mt-4 content">
    <ul class="list-group">
        @forelse($data as $d)
            <li class="justify-content-between align-items-start mb-3 user-li">
                <div class="item-user">
                    <img class="item-user-image me-3"
                         src="{{ $d->getImageUrl() ? url('/storage/images/profile/' . $d->getImageUrl() ): URL::asset('/assets/ic_profile.png') }}"
                         alt="{{ $d->getImageUrl()  }}">

                    <div class="item-user-content">
                        <div class="mb-2">
                            <span class="item-user-label">NIK:</span>
                            <span class="item-user-value">{{ $d->getNik() }}</span>
                        </div>

                        <div class="mb-2">
                            <span class="item-user-label">Nama:</span>
                            <span class="item-user-value">{{ $d->getName() }}</span>
                        </div>

                        <div>
                            <span class="item-user-label">Tipe Akun:</span>
                            <span class="item-user-value">{{ $d->getRole()->getName() }}</span>
                        </div>
                    </div>
                </div>

                <div class="item-user-action mt-2">
                    <form method="POST" action="{{ route('users.show', $d->getId()) }}">
                        @csrf
                        <button class="btn btn-primary me-2" type="submit">Lihat</button>
                        <input type="hidden" name="isEdit" value="{{ false }}">
                    </form>

                    @if($d->getRole()->getId() != 1)
                        <form method="POST" action="{{ route('users.show', $d->getId()) }}">
                            @csrf
                            <button class="btn btn-primary me-2" type="submit">Ubah</button>
                            <input type="hidden" name="isEdit" value="{{ true }}">
                        </form>

                        <form method="POST" action="{{ route('users.delete', $d->getId()) }}">
                            @csrf
                            <button class="btn btn-danger" type="submit">Hapus</button>
                        </form>
                    @endif
                </div>
            </li>
        @empty
            <li class="list-group-item">{{ $title }} kosong</li>
        @endforelse
    </ul>
</div>


    <div class="mt-3">
        {{ $data->onEachSide(1)->links() }}
    </div>
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
        let viewUser = {!! json_encode($user) !!};

        if (!viewUser) return;

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
</script>
