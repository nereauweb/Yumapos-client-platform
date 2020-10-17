@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')

	<div class="container-fluid">
        <div class="card">
            <div class="card-header">

                <div style="display: flex; justify-content: space-between; align-items: center;">

				<span id="card_title">
					Payments
				</span>

                    <div class="btn-group pull-right btn-group-xs">
                        <a class="dropdown-item" href="/users/payments/create">
                            <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                            Add payment
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <h1>Payments</h1>

                <div class="table-responsive users-table ">
                    <table class="table table-bordered col-filtered-datatable">
                        <thead class="thead">
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Details</th>
                            <th>Approved</th>
                        </tr>
                        </thead>
                        <tbody id="users_table">
                        @foreach($payments as $payment)
                            <tr>
                                <td>
                                    <span style="display:none;">{{ date("Y-m-d H:i:s",strtotime($payment->date)) }}</span>
                                    {{ date("d/m/Y",strtotime($payment->date)) }}
                                </td>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ $payment->details }}</td>
                                <td>{!! $payment->approved == 1 ? '<i class="cil-check-alt"></i>':'<i class="cil-x"></i>' !!}</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                </div>
                <div class="uk-margin-top">
                    {!! Form::open(array('route' => 'users.payments.export', 'method' => 'GET', 'role' => 'form', 'class' => 'needs-validation uk-margin-bottom')) !!}
                    {!! csrf_field() !!}
                    {!! Form::button('Export', array('class' => 'btn btn-success','type' => 'submit' )) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

	@include('modals.modal-delete')

@endsection

@section('javascript')
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>
@endsection
