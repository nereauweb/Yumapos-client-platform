@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>{{ $user_name }} operations {{date("d/m/Y",strtotime($date_begin))}} - {{date("d/m/Y",strtotime($date_end))}}</h3>
                        </div>
                    </div>
                    <div class="card-body">
						<div class="uk-padding-small">
							<dl class="row">						
								<dt class="col-sm-5">Operations<dt><dd class="col-sm-7">{{ $operations->count() }}</dd>
								<dt class="col-sm-5">Total User discounts<dt><dd class="col-sm-7">{{ $operations->sum('user_discount') }} €</dd>
								<dt class="col-sm-5">Total Commissions<dt><dd class="col-sm-7">{{ $operations->sum('platform_commission') }} €</dd>
								<dt class="col-sm-5">Total gross Plaform gains<dt><dd class="col-sm-7">{{ $operations->sum('platform_total_gain') }} €</dd>
								<dt class="col-sm-5">Total net Platform gains<dt><dd class="col-sm-7">{{ $operations->sum('platform_total_gain') - $operations->sum('user_discount') }} €</dd>
							</dl>
						</div>
						{!! Form::open(array('route' => 'admin.report.operations', 'method' => 'GET', 'role' => 'form', 'class' => 'needs-validation uk-margin-bottom')) !!}
							{!! csrf_field() !!}
							<div class="uk-grid-small" uk-grid>
								<div class="uk-width-expand">
									<fieldset class="form-group">
									<label>Date range</label>
									<div class="input-group">
										<span class="input-group-prepend">
											<span class="input-group-text">
												<i class="cil-calendar"></i>
											</span>
										</span>
										<input class="form-control" id="daterange" type="text">
										<input type="hidden" name="date_begin" id="date_begin">
										<input type="hidden" name="date_end" id="date_end">										
									</div>
									</fieldset>	
								</div>
								<div class="uk-width-auto">
									<fieldset class="form-group">
									<label>User</label>
									<div class="input-group">
										<span class="input-group-prepend">
											<span class="input-group-text">
												<i class="cil-user"></i>
											</span>
										</span>
										<select class="form-control custom-select" name="user">
											<option value="0" @if($user_id==0) selected @endif>All users</option>
											@foreach ($users as $list_user_id => $list_user_name)
												<option value="{{ $list_user_id }}" @if($user_id==$list_user_id) selected @endif>{{ $list_user_name }}</option>												
											@endforeach
										</select>
									</div>
									</fieldset>	
								</div>
								<div class="uk-width-auto uk-flex uk-flex-bottom">
									{!! Form::button('Commit', array('class' => 'btn btn-success','type' => 'submit' )) !!}
								</div>
							</div>
						{!! Form::close() !!}
						<div style="overflow:auto;">
							<table class="table table-striped table-bordered col-filtered-datatable" id="admin-table">
								<thead>
									<tr>
										<th>Date</th>
										<th>User</th>
										<th>Operation ID</th>
										<th>Reloadly trans. ID</th>
										<th>API call ID</th>
										<th>Country</th>
										<th>Operator</th>
										<th>Phone number</th>
										<th>Expected destination amount</th>
										<th>&Delta; Paid/Sent amount</th>
										<th>Commission</th>
										<th>Gross platform gain</th>
										<th>User discount</th>
										<th>Net platform gain</th>
									</tr>
								</thead>
								<tbody>
								@if($operations->count()>0)
								@foreach($operations as $operation)
									<tr>
										<td>{{ date("d/m/Y H:i:s",strtotime($operation->created_at)) }}</td>
										<td>{{ $operation->user->name }} [Id {{ $operation->user->id }}]</td>
										<td>{{ $operation->id }}</td>
										<td>{{ $operation->reloadly_transactionId }}</td>
										<td>{{ $operation->api_reloadly_calls_id }}</td>
										<td>{{ $operation->request_country_iso }}</td>
										<td>{{ $operation->reloadly_operation->operatorName }}</td>
										<td>{{ $operation->request_recipient_phone }}</td>
										<td>{{ round($operation->final_expected_destination_amount,2) }}&nbsp;{{ $operation->reloadly_operation->deliveredAmountCurrencyCode }}</td>
										<td>{{ round($operation->final_amount - $operation->user_gain - $operation->sent_amount,2) }}&nbsp;&euro;</td>
										<td>{{ round($operation->platform_commission,2) }}&nbsp;&euro;</td>
										<td>{{ round($operation->platform_total_gain,2) }}&nbsp;&euro;</td>
										<td>{{ round($operation->user_discount,2) }}&nbsp;&euro;</td>
										<td>{{ round($operation->platform_total_gain - $operation->user_discount,2) }}&nbsp;&euro;</td>
									</tr>
								@endforeach
								@endif
								</tbody>
							</table>
						</div>						
						<div class="uk-margin-top">
							{!! Form::open(array('route' => 'admin.report.operations.export', 'method' => 'GET', 'role' => 'form', 'class' => 'needs-validation uk-margin-bottom')) !!}
								{!! csrf_field() !!}	
									{!! Form::button('Export', array('class' => 'btn btn-success','type' => 'submit' )) !!}
									<input type="hidden" name="date_begin" value="{{date("Y-m-d",strtotime($date_begin))}}">
									<input type="hidden" name="date_end" value="{{date("Y-m-d",strtotime($date_end))}}">		
							{!! Form::close() !!}			
							{!! Form::open(array('route' => 'admin.report.operations.export.simple', 'method' => 'GET', 'role' => 'form', 'class' => 'needs-validation uk-margin-bottom')) !!}
								{!! csrf_field() !!}	
									{!! Form::button('Formatted export', array('class' => 'btn btn-success','type' => 'submit' )) !!}
									<input type="hidden" name="date_begin" value="{{date("Y-m-d",strtotime($date_begin))}}">
									<input type="hidden" name="date_end" value="{{date("Y-m-d",strtotime($date_end))}}">		
							{!! Form::close() !!}						
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<script type="text/javascript">
		$(function() {
		  $('#daterange').daterangepicker({
			opens: 'left',
			locale: {
			  format: 'DD/MM/YYYY'
			}
		  }, function(start, end, label) {
			$("#date_begin").val(start.format('YYYY-MM-DD'));
			$("#date_end").val(end.format('YYYY-MM-DD'));
			console.log($("#date_begin").val());
			console.log($("#date_end").val());
		  });
		});
	</script>
@endsection