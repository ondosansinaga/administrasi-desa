@extends('root')

@section('title', $title)

@section('body')

<div class="container-fluid">
    <div class="row vh-100 justify-content-center align-items-center">
        <div class="col-md-6 text-center mb-4">
            <img class="logo" src="{{ URL::asset('/assets/ic_logo.png') }}" alt="Logo">
            <h1 class="title">Aplikasi Administrasi Desa Ringin Sari</h1>
        </div>
        <div class="col-md-3">
            @if(isset($errorGlobalMessage))
                <div class="alert alert-danger" role="alert">
                    {{ $errorGlobalMessage }}
                </div>
            @endif

            @php
                $errorSession = Session::get('errorGlobalMessage');
            @endphp

            @if(isset($errorSession))
                <div class="alert alert-danger" role="alert">
                    {{ $errorSession }}
                </div>
            @endif

            <div id="login-form" class="login-form">
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    {{--Username--}}
                    <div class="mb-3">
                        <label for="in-username" class="form-label">Username</label>
                        <input id="in-username"
                               class="form-control"
                               type="text"
                               placeholder="Masukan username anda"
                               aria-label="Username"
                               name="username"
                               value="{{ $username }}">
                        @if(isset($errorMessage['username']))
                            <div class="invalid-feedback d-block">
                                {{ $errorMessage['username'] }}
                            </div>
                        @endif
                    </div>

                    {{--Password--}}
                    <div class="mb-3">
                        <label for="in-pass" class="form-label">Password</label>
                        <input id="in-pass"
                               class="form-control"
                               type="password"
                               placeholder="Masukan password anda"
                               aria-label="Password"
                               name="password"
                               value="{{ $password }}">
                        @if(isset($errorMessage['password']))
                            <div class="invalid-feedback d-block">
                                {{ $errorMessage['password'] }}
                            </div>
                        @endif
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            console.log('login-js-loaded');

            resetInputMessage('in-username', 'msg-username');
            resetInputMessage('in-pass', 'msg-pass');
        });
    </script>
@endsection

@section('head')
    <style>
     .logo {
        width: 200px;
        margin-bottom: 20px;
    }

    .title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .login-form {
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .logo {
            width: 150px;
        }
    }

    .row{
        display: flex;
        flex-direction: column;
        flex-wrap: nowrap;
    }
    </style>
@endsection
