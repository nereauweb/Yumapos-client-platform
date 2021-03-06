<!DOCTYPE html>
<!--
* CoreUI Pro Laravel Bootstrap Admin Template
* @version v3.0.0-alpha.1
* @link https://coreui.io/pro/
* Copyright (c) 2019 creativeLabs Łukasz Holeczek
* License (https://coreui.io/pro/license)
-->

<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
   <title>{{ strpos($_SERVER["SERVER_NAME"],'ping')!== false ? 'Ping' : 'Yumapos' }}</title>
    <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<!-- UIkit CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/css/uikit.min.css" />
{{--	<link rel="stylesheet" href="/css/reset.css" />--}}
    <!-- Icons-->
    <link href="{{ asset('css/free.min.css') }}" rel="stylesheet"  crossorigin> <!-- icons -->
    <!-- Main styles for this application-->
      <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css" crossorigin>
      <link rel="stylesheet" href="{{ asset('css/coreui-chartjs.css') }}">
      <link href="{{ asset('css/pace.min.css') }}" rel="stylesheet">
      <link href="{{ asset('css/flag.min.css') }}" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
      <link rel="stylesheet" href="{{ asset('css/select2-coreui.css') }}">
      <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @yield('css')
	<!-- Custom CSS -->
	<link rel="stylesheet" href="/css/layout.css" />
	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<!-- UIkit JS -->
	<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit-icons.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
	@if (strpos($_SERVER["SERVER_NAME"],'ping')!== false)
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-206868297-2"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());
		  gtag('config', 'UA-206868297-2');
		</script>
	@endif
	@yield('early_javascript')
  </head>
  <style>
	@yield('style')
  </style>
  <body class="c-app c-dark-theme">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    @include('dashboard.shared.nav-builder')


    @include('dashboard.shared.header')

      <div class="c-body">

        <main class="c-main">
            @if (session()->has('status'))
                <div class="container-fluid">
                    <div class="alert @if(session()->get('status') == 'success') alert-success @else alert-danger @endif alert-dismissible fade show" role="alert">
                        <span>{{ session()->get('message') }}</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="container-fluid">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span>{{ session()->get('success') }}</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="container-fluid">
                    <div class="alert  alert-danger  alert-dismissible fade show" role="alert">
                        <span>{{ session()->get('error') }}</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
          @yield('content')

        </main>
      </div>
      @include('dashboard.shared.footer')
    </div>



    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('js/pace.min.js') }}"></script>
    <script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('js/tooltips.js') }}"></script>
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.js') }}"></script>
    <script src="{{ asset('js/coreui-utils.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
      /* 16.12.2019 */
      let selectLocale = document.getElementById("select-locale")
      selectLocale.addEventListener("change", function() {
        document.getElementById('select-locale-form').submit();
      });
    </script>

    @yield('javascript')
  </body>
</html>
