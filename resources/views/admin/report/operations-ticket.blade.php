@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection


@section('early_javascript')
	<script>
		function details(operationID) {
			event.preventDefault();
			$('#details-modal').load('/admin/report/'+operationID+'/details/ #content');
			UIkit.modal('#details-modal').show();
		}
	</script>
@endsection

@section('content')
	@livewireStyles()
    <div class="container-fluid">
        <div class="row">
			@livewire('operation-ticket')
        </div>
    </div>
	@livewireScripts()
	<div id="details-modal" uk-modal></div>
@endsection

@section('javascript')
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endsection
