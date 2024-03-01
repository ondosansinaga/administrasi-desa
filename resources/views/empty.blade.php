@extends('root')

@section('title', 'Not Found')

@section('body')
    <div class="container vh-100 center">
        <img class="logo" src="{{URL::asset('/assets/ic_logo.png')}}" alt="Logo">
        <h1 class="mt-4">Halaman tidak ditemukan</h1>
    </div>
@endsection

@section('head')
    <style>
        .center {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .logo {
            width: 240px;
        }
    </style>
@endsection
