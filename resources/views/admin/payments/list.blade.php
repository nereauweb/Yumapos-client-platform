@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@livewireStyles()
@section('content')
<div class="container-fluid">
	@livewire('payment')
</div>
@include('modals.modal-delete')
@endsection

@livewireScripts()

