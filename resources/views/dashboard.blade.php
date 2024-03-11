@extends('root')

@section('title', 'Dashboard')

@section('body')
<div>
<div class="header">
    <div class="logo-section">
        <img class="logo" src="{{ URL::asset('/assets/ic_logo.png') }}" alt="Logo">
        <div class="ms-4">
            <h5>{{ $appName }}</h5>
            @if(isset($user))
            <h6>Halo, {{ $user->getName() }}</h6>
            @endif
        </div>
    </div>

    <form method="GET" action="{{ route('dashboard.logout') }}">
        @csrf
        <button class="btn btn-danger" type="submit">Logout</button>
    </form>
</div>


    <div class="container-fluid">
        <div class="row root-section">
        <div class="col-md-3 navbar">
    <h5 class="menu-title">MENU</h5>
    <ul class="list-unstyled mt-3">
        @foreach($menus as $m)
        @php
        $menuA = $m == $activeMenu;
        @endphp
        <li class="mb-2">
            <form method="GET" action="{{ route('dashboard') }}">
                @csrf
                <button class="btn {{ $menuA ? 'btn-active' : 'btn-primary' }} w-100" type="submit"
                    name="menu" value="{{ $m }}">{{ $m }}</button>
            </form>
        </li>
        @endforeach
    </ul>
</div>

            <div class="col content">
                @php
                $message = Session::get('message') ?? null
                @endphp
                @foreach($menus as $m)
                @if($m == $activeMenu)
                @include($m->page(), [
                'title'=> $activeMenu,
                'data' => $data ?? [],
                'message' => $message
                ])
                @break
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('head')
<style>
   .header {
    background-color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 45px 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Efek shadow mengarah ke bawah */
    position: relative; /* Coba tambahkan position relative */
    z-index: 1000; /* Contoh z-index, sesuaikan jika diperlukan */
    height: 60px; /* Contoh tinggi elemen */
}


    .logo {
        width: 50px;
        height: 60px;
    }

    .logo-section {
        display: flex;
        align-items: center;
    }

    .navbar {
        background-color: white;
        /* Mengatur lebar navbar */
        width: 250px; /* Atur sesuai keinginan Anda */
        /* Menghapus border dan rounded */
        border: 1px solid #f3f2f2;
        border-radius: 0;
        padding: 20px;
        height: calc(100vh - 100px);
        overflow-y: auto;
        box-shadow: 0 0px 40px  rgba(0, 0, 0, 0.1);
        flex-direction: column;
        flex-wrap: nowrap;
        align-content: center;
        justify-content: flex-start;
        align-items: stretch;
    }

    .navbar .btn-active {
        background-color: #212529; /* Warna biru yang lebih terang */
        color: white;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        width: 100%;
    }

    .content {
        background-color: white;
        /* Menghapus border dan rounded */
        border: none;
        border-radius: 0;
        padding: 20px;
        height: calc(100vh - 100px);
        overflow-y: auto;
    }

    .menu-title {
        text-align: center;
        margin-bottom: 15px;
        color: #333;
    }

    .btn {
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        width: 100%;
    }
</style>
@endsection




