<style>
    .img-profile {
        width: 200px;
        height: 200px;
        border-radius: 8px;
        background: var(--red-primary);
        object-fit: contain;
    }

    .img-profile-section {
        display: flex;
        align-items: center;
        flex-direction: column;
        flex: 1;
    }

    .info-profile-section {
        display: flex;
        flex-direction: column;
        width: 50%;
        height: calc(100vh - 200px);
        overflow: scroll;
        flex: 2;
    }

    .profile-section {
        display: flex;
        flex-direction: row;
    }

    .profile-action-section {
        margin-top: 20px;
        margin-left: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
</style>

<div>
    <h3>{{ $title  }}</h3>
</div>

@php
    $isEdit = Session::get('isEdit') ?? false;
@endphp

<div class="mt-4 profile-section">
    <div class="img-profile-section">

        <img class="img-profile"
             src="{{ $data->getImageUrl() ? url('/storage/images/profile/' . $data->getImageUrl() ): URL::asset('/assets/ic_profile.png') }}"
             alt="Foto Profil">

    </div>

    <div class="info-profile-section ms-1">
        <form method="POST"
              action="{{ route('profile.update',$data->getId()) }}"
              enctype="multipart/form-data">
            @csrf

            @if($isEdit)
                <label for="in-image" class="label">Foto</label>
                <input
                    id="in-image"
                    name="image"
                    class="my-input"
                    type="file"
                    accept=".png, .jpg, .jpeg">
            @endif

            <label for="in-nik" class="label  {{ $isEdit ? 'mt-2' : ''}}">NIK</label>
            <input id="in-nik"
                   name="nik"
                   class="my-input"
                   value="{{ $data->getNik()  }}"
                   type="text"
                {{ $isEdit ? '' : 'disabled'  }}>

            <label for="in-name" class="label mt-2">Nama</label>
            <input id="in-name"
                   name="name"
                   class="my-input"
                   value="{{ $data->getName()  }}"
                   type="text"
                {{ $isEdit ? '' : 'disabled'  }}>

            <label for="in-gender" class="label mt-2">Jenis Kelamin</label>
            <select id="in-gender" class="form-select" name="gender" {{ $isEdit ? '' : 'disabled'  }}>
                <option value="1" {{ $data->getGender() == '1'? 'selected' : ''  }}>Laki-Laki</option>
                <option value="0" {{ $data->getGender() == '0'? 'selected' : ''  }}>Perempuan</option>
            </select>

            <label for="in-address" class="label mt-2">Alamat</label>
            <input id="in-address"
                   name="address"
                   class="my-input"
                   value="{{ $data->getAddress()  }}"
                   type="text"
                {{ $isEdit ? '' : 'disabled'  }}>

            <label for="in-birth" class="label mt-2">Tempat, Tanggal Lahir</label>
            <input id="in-birth"
                   name="birth"
                   class="my-input"
                   value="{{ $data->getBirthInfo()  }}"
                   type="text"
                {{ $isEdit ? '' : 'disabled'  }}>

            <label for="in-job" class="label mt-2">Pekerjaan</label>
            <input id="in-job"
                   name="job"
                   class="my-input"
                   value="{{ $data->getJobTitle()  }}"
                   type="text"
                {{ $isEdit ? '' : 'disabled'  }}>

            <label for="in-username" class="label mt-2">Username</label>
            <input id="in-username"
                   class="my-input"
                   value="{{ $data->getUsername()  }}"
                   type="text"
                   disabled>

            <label for="in-password" class="label mt-2">Password</label>
            <input id="in-password"
                   class="my-input"
                   value="{{ $data->getPassword()  }}"
                   type="text"
                {{ $isEdit ? '' : 'disabled'  }}>

            <input id="btn-save-hidden" class="my-btn-primary mt-2" type="submit" value="Save" hidden>
        </form>
    </div>

    <div class="profile-action-section">
        @if(!$isEdit)
            <form method="POST" action="{{ route('profile.edit',['isEdit'=>true]) }}">
                @csrf
                <input class="my-btn-primary" type="submit" value="Update">
            </form>
        @endif

        @if($isEdit)
            <form method="POST" action="{{ route('profile.edit',['isEdit'=>false]) }}">
                @csrf
                <input class="my-btn-secondary" type="submit" value="Cancel">
            </form>

            <input id="btn-save" class="my-btn-primary mt-2" type="submit" value="Save">
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

