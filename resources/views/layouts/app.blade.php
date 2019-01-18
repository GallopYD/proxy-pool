<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <meta name="keywords" content="{{config('app.keywords')}}"/>
    <meta name="description" content="{{config('app.description')}}"/>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ route('index',[],false) }}">
                {{config('app.name')}}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item @if(!\Illuminate\Support\Facades\Request::route()->quality || \Illuminate\Support\Facades\Request::route()->quality == 'premium') active @endif">
                        <a class="nav-link" href="{{route('index',['quality'=>'premium'],false)}}">优质代理</a>
                    </li>
                    <li class="nav-item @if(\Illuminate\Support\Facades\Request::route()->quality == 'stable') active @endif">
                        <a class="nav-link" href="{{route('index',['quality'=>'stable'],false)}}">稳定代理</a>
                    </li>
                    <li class="nav-item @if(\Illuminate\Support\Facades\Request::route()->quality == 'common') active @endif">
                        <a class="nav-link" href="{{route('index',['quality'=>'common'],false)}}">普通代理</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" target="_blank" href="https://github.com/GallopYD/proxy-pool">GitHub<img
                                    class="github-logo" src="{{asset('images/github.jpg')}}"></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        @yield('content')

        <div class="text-center">
            {{--<p>--}}
            {{--友情链接：<a href="http://tool.357.im/">域名工具</a>--}}
            {{--</p>--}}
            <span style="color: red">声明：本网站所有代理IP均采集于网络，请勿用于非法途径，违者后果自负！</span><br>
            <script type="text/javascript"
                    src="https://s23.cnzz.com/z_stat.php?id=1275295247&web_id=1275295247"></script>
        </div>
    </main>
</div>
@yield('js')
</body>
</html>
