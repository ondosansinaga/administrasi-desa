@extends('root')

@section('title','Dashboard')

@section('body')
    <div>
        <div class="my-header">
            <div class="logo-section">
                <img class="logo" src="{{URL::asset('/assets/ic_logo.png')}}" alt="Logo">
                <div class="ms-4">
                    <h5>{{ $appName  }}</h5>
                    @if(isset($user))
                        <h6>Halo, {{ $user->getName()  }}</h6>
                    @endif
                </div>
            </div>

            <form method="GET" action="{{ route('dashboard.logout') }}">
                @csrf
                <input class="my-btn-secondary" type="submit" value="Logout">
            </form>
        </div>

        <div class="container-fluid">
            <div class="row root-section">
                <div class="col-2 my-navbar">
                    <h5 class="menu-title">Menu</h5>
                    <ul class="mt-1">
                        @foreach($menus as $m)
                            @php
                                $menuA = $m == $activeMenu;
                            @endphp
                            <li class="mb-2">
                                <form method="GET" action="{{route('dashboard')}}">
                                    @csrf
                                    <input class="{{ $menuA ?  'my-btn-secondary' : 'my-btn-primary' }}" type="submit"
                                           value="{{ $m  }}" name="menu">
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col my-content">
                    @php
                       $message =  Session::get('message') ?? null
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
        .menu-title {
            text-align: center;
        }

        .my-footer {
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--red-primary);
            height: 80px;
            width: 100vw;
            color: white;
        }

        .my-header {
            background: var(--red-primary);
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            width: 100vw;
            height: 80px;
            padding: 10px 20px;
        }

        .my-navbar {
            background: var(--red-primary);
            color: white;
            margin: 10px;
            border-radius: 16px;
            border: 1px solid var(--red-primary-light);
            padding: 20px 10px;
            height: calc(100vh - (100px));
            overflow: scroll;
        }

        .my-content {
            margin: 10px;
        }

        .logo {
            width: 50px;
            height: 50px;
        }

        .logo-section {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .root-section {
            height: calc(100vh - (90px));
        }

    </style>
@endsection
