<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="format-detection" content="telephone=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title')</title>
  <link href="{{ mix('css/vender.css') }}" rel="stylesheet"/>
  <link href="{{ mix('css/voss.css') }}" rel="stylesheet"/>
  @yield('style')
  <script src="{{ mix('js/vender.js')}}"></script>
  <script src="{{ mix('js/voss.js')}}"></script>
  <script src="{{ mix('js/voss_ajax.js')}}"></script>
  @yield('js')
<!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-22118792-1"></script>
  <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
          dataLayer.push(arguments);
      }

      gtag('js', new Date());

      gtag('config', 'UA-22118792-1');
  </script>
  <link rel="icon" type="image/png" href="{{ ext_asset('/favicon.png') }}">
</head>
<body>
<div id="layer">
  <header class="@if(\App\Libs\Voss\VossAccessManager::isAgentTestSite()){{ "agent_test" }}@endif">
    <div class="left_info"><img class="logo" src="{{ ext_asset('/images/logo.png') }}"/></div>
    <div class="right_info">
    @if ( !is_null(request()->route()) && ends_with(request()->route()->getName(), 'login') )
        <img class="logo" src="{{ ext_asset('/images/company_name.png') }}"/>
      @else
        <div class="login_data">@yield('login_data')</div>
    @endif
    </div>
    <div class="line"></div>
  </header>
  <nav>
    <div class="breadcrumb">@yield('breadcrumb')</div>
  </nav>
  <div class="container">
    @yield('content')
  </div>
  <footer>
    <p>Copyright © {{ \App\Libs\DateUtil::now('Y') }}日本クルーズ客船株式会社. All Rights Reserved.</p>
  </footer>
</div>
</body>
<form id="holiday_form" action="{{ ext_route('holiday.list') }}" method="get"></form>
</html>