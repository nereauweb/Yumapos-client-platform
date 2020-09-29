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
					<h1 class="major">A Generic Page</h1>
					<span class="image fit"><img src="images/pic04.jpg" alt="" /></span>
					<p>Donec eget ex magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque venenatis dolor imperdiet dolor mattis sagittis. Praesent rutrum sem diam, vitae egestas enim auctor sit amet. Pellentesque leo mauris, consectetur id ipsum sit amet, fergiat. Pellentesque in mi eu massa lacinia malesuada et a elit. Donec urna ex, lacinia in purus ac, pretium pulvinar mauris. Curabitur sapien risus, commodo eget turpis at, elementum convallis elit. Pellentesque enim turpis, hendrerit tristique.</p>
					<p>Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque venenatis dolor imperdiet dolor mattis sagittis. Praesent rutrum sem diam, vitae egestas enim auctor sit amet. Pellentesque leo mauris, consectetur id ipsum sit amet, fersapien risus, commodo eget turpis at, elementum convallis elit. Pellentesque enim turpis, hendrerit tristique lorem ipsum dolor.</p>
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