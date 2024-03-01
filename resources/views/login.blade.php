@extends('root')

@section('title', $title)

@section('body')

    <div class="container-fluid">
        <div class="row vh-100">
            <div class="col section-logo">
                <img class="logo" src="{{URL::asset('/assets/ic_logo.png')}}" alt="Logo">
                <br>
                <h1 class="title">Aplikasi Administrasi <br/> Desa Ringin Sari</h1>
            </div>
            <div class="col section-form">
                @if(isset($errorGlobalMessage))
                    <div class="alert alert-danger" role="alert">
                        {{ $errorGlobalMessage  }}
                    </div>
                @endif

                @php
                    $errorSession = Session::get('errorGlobalMessage');
                @endphp

                @if(isset($errorSession))
                    <div class="alert alert-danger" role="alert">
                        {{ $errorSession  }}
                    </div>
                @endif

                <h3 class="title-login">{{ $title }}</h3>
                <br>
                <div id="login-form" class="login-form">
                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        {{--Username--}}
                        <label for="in-username" class="label">Username</label>
                        <input id="in-username"
                               class="my-input"
                               type="text"
                               placeholder="Masukan username anda"
                               aria-label="Username"
                               name="username"
                               value="{{ $username  }}">
                        <div id='msg-username'>
                            @if(isset($errorMessage['username']))
                                <p>{{$errorMessage['username']}}</p>
                            @endif
                        </div>

                        {{--Password--}}
                        <label for="in-pass" class="label mt-2">Password</label>
                        <input id="in-pass"
                               class="my-input"
                               type="password"
                               placeholder="Masukan password anda"
                               aria-label="Password"
                               name="password"
                               value="{{ $password }}">
                        <div id='msg-pass'>
                            @if(isset($errorMessage['password']))
                                <p>{{$errorMessage['password']}}</p>
                            @endif
                        </div>

                        <input class="my-btn-primary mt-3" type="submit" value="Login">
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
        .label {
            color: black;
            font-weight: bold;
        }

        .login-form {
            width: 70%;
            background: white;
            border-radius: 16px;
            padding: 16px;
        }

        .logo {
            width: 240px;
        }

        .section-logo {
            align-items: center;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px 10px;
        }

        .section-form {
            align-items: center;
            background: var(--red-primary);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px 10px;
        }

        .title {
            text-align: center;
            font-weight: bold;
        }

        .title-login {
            color: white;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .logo {
                width: 140px;
            }

            .login-form {
                width: 90%;
            }
        }
    </style>
@endsection
