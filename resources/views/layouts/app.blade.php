<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

	<!-- UIkit CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/css/uikit.min.css" />

	<!-- UIkit JS -->
	<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit-icons.min.js"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
	@yield('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.basictable/1.1.0/basictable.min.css" integrity="sha512-uhJBKXu91y+d352XFs3H4pleDOkpv8cB44hZ1AR7GSkU/ic5/hoSxFYFsVqSZSV+e2fcyq00HKeetcRn78JdTg==" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.basictable/1.1.0/jquery.basictable.js" integrity="sha512-nWpIKXCKNcC4VHVCWrWEUdaolGZTe84yIp10hGHjME3g9gBlhJzpPNRKWHUTilZ3zbcPQptz20DDNb+W4aXuWA==" crossorigin="anonymous"></script>
	@yield('css')
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
	@yield('endpage scripts')
    <script>
        $('table').basictable('start');
    </script>
</body>
</html>
