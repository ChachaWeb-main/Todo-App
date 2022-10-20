<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- ******************************************************************************
    現状 style.cssやscript.jsをすべてのページで読み込んでいる。
    トップページ以外（アカウント作成ページやログインページなど）では使わないため、
    トップページのみで読み込めるように修正、子ビューで個別のファイルを読み込む。
    1. 親ビューにおいて、ファイルを読み込みたい位置に@stackを記述する
    2. 子ビューにおいて、@push ～ @endpush内にファイルを読み込むコードを記述する
    ****************************************************************************** --}}
    {{-- 独自CSS --}}
    @stack('styles')
</head>

<body>
    <div id="app">
        {{-- 部品化したヘッダーの呼び出し --}}
        @include('layouts.header')

        <main class="py-4">
            {{-- メインページの表示 index.blade.php --}}
            @yield('content')
        </main>

        {{-- 部品化したフッターの呼び出し --}}
        @include('layouts.footer')
    </div>

    {{-- 独自JS --}}
    @stack('scripts')
</body>
</html>
