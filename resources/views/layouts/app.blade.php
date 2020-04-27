<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Instagram</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.3.9/jquery.jscroll.js" defer></script>
    <script type="text/javascript"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a href="{{ url('/') }}">
                    <img src="/Instagram_Logo.png">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @if(Auth::check())
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active ml-5">
                                <a class="nav-link" href="/search">検索</a>
                            </li>
                        </ul>
                    @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">登録</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a href="/profile/{{ Auth::user()->id }}">
                                    @if(Auth::user()->profile->profileImage())
                                        <img src="data:img/png;base64,{{ Auth::user()->profile->profileImage() }}" class="post-profile-icon round-img">
                                    @else
                                        <img src="/Psy0tMpnjUQIbumb25Csi1XLLdhLV2QWT2R3K4Zh.jpeg" class="post-profile-icon round-img">
                                    @endif
                                     <span class="caret"></span>
                                </a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @if (session('flash_message'))
            <div class="flash_message  bg-success text-center py-3 my-0">
                {{ session('flash_message') }}
            </div>
        @endif

        <main class="py-4 bg-light">
            @yield('content')
        </main>

    </div>

</body>
</html>
