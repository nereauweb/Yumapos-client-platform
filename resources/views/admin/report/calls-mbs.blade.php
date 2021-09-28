@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@livewireStyles()
@section('content')
@livewire('api-call-mbs')
@endsection
@livewireScripts()
@section('javascript')
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<script type="text/javascript">
		$(function() {
		  $('#daterange').daterangepicker({
			opens: 'left'
		  }, function(start, end, label) {
			$("#date_begin").val(start.format('YYYY-MM-DD'));
			$("#date_end").val(end.format('YYYY-MM-DD'));
		  });
		});
	</script>
@endsection