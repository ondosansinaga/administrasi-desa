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
        flex-direction: column;
        gap: 20px;
        justify-content: space-between;
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
                    <div style="text-align: center;">
                        <img class="img-profile"
                             src="{{ $user->getImageUrl() ? url('/storage/images/profile/' . $user->getImageUrl() ): URL::asset('/assets/ic_profile.png') }}"
                             alt="Foto Profil">
                    </div>

                    <label for="in-nik" class="label mt-2">NIK</label>
                    <input id="in-nik"
                           class="my-input"
                           value="{{ $user->getNik()  }}"
                           type="text"
                           disabled>

                    <label for="in-name" class="label mt-2">Nama</label>
                    <input id="in-name"
                           class="my-input"
                           value="{{ $user->getName()  }}"
                           type="text"
                           disabled>

                    <label for="in-gender" class="label mt-2">Jenis Kelamin</label>
                    <select id="in-gender" class="form-select" name="gender" disabled>
                        <option value="1" {{ $user->getGender() == '1'? 'selected' : ''  }}>Laki-Laki</option>
                        <option value="0" {{ $user->getGender() == '0'? 'selected' : ''  }}>Perempuan</option>
                    </select>

                    <label for="in-address" class="label mt-2">Alamat</label>
                    <input id="in-address"
                           class="my-input"
                           value="{{ $user->getAddress()  }}"
                           type="text"
                           disabled>

                    <label for="in-birth" class="label mt-2">Tempat, Tanggal Lahir</label>
                    <input id="in-birth"
                           class="my-input"
                           value="{{ $user->getBirthInfo()  }}"
                           type="text"
                           disabled>

                    <label for="in-job" class="label mt-2">Pekerjaan</label>
                    <input id="in-job"
                           class="my-input"
                           value="{{ $user->getJobTitle()  }}"
                           type="text"
                           disabled>

                    <!-- <label for="in-username" class="label mt-2">Username</label>
                    <input id="in-username"
                           class="my-input"
                           value="{{ $user->getUsername()  }}"
                           type="text"
                           disabled> -->

                    <!-- <label for="in-password" class="label mt-2">Password</label>
                    <input id="in-password"
                           class="my-input"
                           value="{{ $user->getPassword()  }}"
                           type="text"
                           disabled> -->
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
                <form method="POST"
                      action="{{ route('users.update', $user->getId()) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label for="in-image" class="label">Foto</label>
                        <input
                            id="in-image"
                            name="image"
                            class="my-input"
                            type="file"
                            value="{{ $user->getImageUrl()  }}"
                            accept=".png, .jpg, .jpeg">

                        <label for="in-nik" class="label mt-2">NIK</label>
                        <input id="in-nik"
                               name="nik"
                               class="my-input"
                               value="{{ $user->getNik()  }}"
                               type="text">

                        <label for="in-name" class="label mt-2">Nama</label>
                        <input id="in-name"
                               name="name"
                               class="my-input"
                               value="{{ $user->getName()  }}"
                               type="text">

                        <label for="in-gender" class="label mt-2">Jenis Kelamin</label>
                        <select id="in-gender" class="form-select" name="gender">
                            <option value="1" {{ $user->getGender() == '1'? 'selected' : ''  }}>Laki-Laki</option>
                            <option value="0" {{ $user->getGender() == '0'? 'selected' : ''  }}>Perempuan</option>
                        </select>

                        <label for="in-address" class="label mt-2">Alamat</label>
                        <input id="in-address"
                               name="address"
                               class="my-input"
                               value="{{ $user->getAddress()  }}"
                               type="text">

                        <label for="in-birth" class="label mt-2">Tempat, Tanggal Lahir</label>
                        <input id="in-birth"
                               name="birth"
                               class="my-input"
                               value="{{ $user->getBirthInfo()  }}"
                               type="text">

                        <label for="in-job" class="label mt-2">Pekerjaan</label>
                        <input id="in-job"
                               name="job"
                               class="my-input"
                               value="{{ $user->getJobTitle()  }}"
                               type="text">

                        <!-- <label for="in-username" class="label mt-2">Username</label>
                        <input id="in-username"
                               name="username"
                               class="my-input"
                               value="{{ $user->getUsername()  }}"
                               type="text"
                               disabled> -->

                        <!-- <label for="in-password" class="label mt-2">Password</label>
                        <input id="in-password"
                               name="password"
                               class="my-input"
                               value="{{ $user->getPassword()  }}"
                               type="text"> -->
                    </div>
                    <div class="modal-footer">
                        <div>
                            <input
                                type="submit"
                                value="Update"
                                class="btn my-btn-primary"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<div>
    <h3>{{ $title  }}</h3>
</div>

<div class="mt-2">
    <ul class="list-content">
        @forelse($data as $d)
            <li class="item-user mb-2">
                <img class="item-user-image"
                     src="{{ $d->getImageUrl() ? url('/storage/images/profile/' . $d->getImageUrl() ): URL::asset('/assets/ic_profile.png') }}"
                     alt="{{ $d->getImageUrl()  }}">

                <div class="item-user-content ms-3">
                    <div>
                        <label for="in-a-nik" class="item-user-label">NIK</label>
                        <p class="item-user-value" id="in-a-nik">{{ $d->getNik() }}</p>
                    </div>

                    <div class="mt-1">
                        <label for="in-a-name" class="item-user-label">Nama</label>
                        <p class="item-user-value" id="in-a-name">{{ $d->getName() }}</p>
                    </div>

                    <!-- <div class="mt-1">
                        <label for="in-a-username" class="item-user-label">Username</label>
                        <p class="item-user-value" id="in-a-username">{{ $d->getUsername() }}</p>
                    </div> -->

                    <!-- <div class="mt-1">
                        <label for="in-a-password" class="item-user-label">Password</label>
                        <p class="item-user-value" id="in-a-password">{{ $d->getPassword() }}</p>
                    </div> -->

                    <div class="mt-1">
                        <label for="in-a-role" class="item-user-label">Tipe Akun</label>
                        <p class="item-user-value" id="in-a-role">{{ $d->getRole()->getName() }}</p>
                    </div>
                </div>

                <div class="item-user-action ms-2">
                    <form method="POST" action="{{ route('users.show', $d->getId())  }}">
                        @csrf
                        <input class="my-btn-secondary small-btn"
                               type="submit"
                               value="Lihat">
                        <input type="text" name="isEdit" value="{{false}}" hidden/>
                    </form>

                    @if($d->getRole()->getId() != 1)
                        <form method="POST" action="{{ route('users.show', $d->getId())  }}">
                            @csrf
                            <input class="my-btn-secondary small-btn"
                                   type="submit"
                                   value="Ubah">
                            <input type="text" name="isEdit" value="{{true}}" hidden/>
                        </form>

                        <form method="POST" action="{{ route('users.delete', $d->getId())  }}">
                            @csrf
                            <input class="my-btn-secondary small-btn"
                                   type="submit"
                                   value="Hapus">
                        </form>
                    @endif
                </div>
            </li>
        @empty
            <h6>{{$title}} kosong</h6>
        @endforelse
    </ul>

    <div>
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
