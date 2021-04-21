@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="/hyperspace/assets/css/main.css" />
	<noscript><link rel="stylesheet" href="/hyperspace/assets/css/noscript.css" /></noscript>
@endsection

@section('content')
<!-- Header -->
	<header id="header">
		<a href="index.html" class="title">Hyperspace</a>
		<nav>
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a href="{{url('/page')}}" class="active">Generic</a></li>
			</ul>
		</nav>
	</header>

<!-- Wrapper -->
	<div id="wrapper">

		<!-- Main -->
			<section id="main" class="wrapper" uk-height-viewport="offset-top: true">
				<div class="inner">
					<h1 class="major">Test</h1>
<?php

$url = 'https://mbspay.it/webservicesmbspay/webservicesmbs.php';
$data = [
	'Firma' => md5('1'.''.'!AlmjKma3Wi94w!'), 
	'key2' => 'value2'

];

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */ }

var_dump($result);

?>
				</div>
			</section>

	</div>

<!-- Footer -->
	<footer id="footer" class="wrapper alt">
		<div class="inner">
			<ul class="menu">
				<li>&copy; Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
			</ul>
		</div>
	</footer>


@endsection

@section('endpage scripts')
<!-- Scripts -->
	<script src="/hyperspace/assets/js/jquery.min.js"></script>
	<script src="/hyperspace/assets/js/jquery.scrollex.min.js"></script>
	<script src="/hyperspace/assets/js/jquery.scrolly.min.js"></script>
	<script src="/hyperspace/assets/js/browser.min.js"></script>
	<script src="/hyperspace/assets/js/breakpoints.min.js"></script>
	<script src="/hyperspace/assets/js/util.js"></script>
	<script src="/hyperspace/assets/js/main.js"></script>
@endsection