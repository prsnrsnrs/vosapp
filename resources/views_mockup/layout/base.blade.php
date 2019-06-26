<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection" content="telephone=no">
    <title>@yield('title')</title>
    <link href="{{ mix('css/base.css') }}" rel="stylesheet" />
    @yield('style')
    @yield('js')
</head>
<body>
<header>
  <div style="text-align: left;"><img src="{{ asset('/images/logo.png') }}"/></div>
    @if(preg_match('/login/', Request::path()) || Request::path() == '/')
    <div style="text-align: right;"><img src="{{ asset('/images/company_name.png') }}" style="height: 40px"/></div>
    @endif
    <div class="line"></div>
</header>
<nav>
    <div class="breadcrumb">@yield('breadcrumb')</div>
    <div class="login_data">@yield('login_data')</div>
</nav>
<div class="container">
    @yield('content')
</div>
<footer>
    <p>Copyright © 2018日本クルーズ客船株式会社. All Rights Reserved.</p>
</footer>
</body>
</html>