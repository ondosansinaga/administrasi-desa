@extends('root')

@section('title', 'Dashboard')

@section('head')
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
        margin-left: 30px;
    }

    .status-value-modal-edit{
        margin-left: 30px;
    }
    
    .container {
    display: flex;
    flex-wrap: wrap;
}

.data-box {
    width: calc(30% - 20px);
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
        
        color: white;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 10px 20px;
        margin-bottom: 20px;
}


    </style>
@endsection

@section('body')
<div class="warga-header d-flex justify-content-between align-items-center">
     <!-- Link Kembali dan Judul -->
     <div class="d-flex align-items-center">
        <a href="{{ route('dashboard') }}" class="btn btn-light me-3">Kembali</a>
        <h3 class="mb-0">Hasil Pencarian Data Warga</h3>
    </div>

    <!-- Form Pencarian -->
    <form action="{{ route('searchWarga') }}" method="GET" class="row g-3 align-items-center">
        <div class="col-auto">
            <label for="kk" class="visually-hidden">Search by No.KK</label>
            <input type="text" class="form-control" id="kk" name="kk" placeholder="Search by No.KK...">
        </div>
        <!-- <div class="col-auto">
            <button type="submit" class="btn btn-primary">Search</button>
        </div> -->
    </form>
</div>

    <div class="row container">
        @forelse($dataWarga as $warga)
            <div class="data-box">
                <div class="data-info">
                    <div class="info-item">
                        <div class="info-label">NIK:</div>
                        <div class="info-value">{{ $warga->nik }}</div>
                    </div>
    
                    <div class="info-item">
                        <div class="info-label">No.KK:</div>
                        <div class="info-value">{{ $warga->kk }}</div>
                    </div>
    
                    <div class="info-item">
                        <div class="info-label">Nama:</div>
                        <div class="info-value">{{ $warga->name }}</div>
                    </div>
    
                    <div class="info-item">
                        <div class="info-label">Status:</div>
                        <div class="info-item-status">
                            <p class="info-value">{{ $warga->status_1 }}</p>
                            <p>{{ $warga->status_2 }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="item-user-action mt-2">
                    <form method="POST" action="{{ route('warga.show', $warga->id) }}">
                        @csrf
                        <button class="btn btn-primary me-2" type="submit">Lihat</button>
                        <input type="hidden" name="isEdit" value="{{ false }}">
                    </form>
    
                    <form method="POST" action="{{ route('warga.show', $warga->id) }}">
                        @csrf
                        <button class="btn btn-primary me-2" type="submit">Ubah</button>
                        <input type="hidden" name="isEdit" value="{{ true }}">
                    </form>
    
                    <form method="POST" action="{{ route('warga.delete', $warga->id) }}">
                        @csrf
                        <button class="btn btn-danger" type="submit">Hapus</button>
                    </form>
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
@endsection

