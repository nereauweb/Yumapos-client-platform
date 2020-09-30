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
								<dt class="col-sm-5">Total amount<dt><dd class="col-sm-7">{{ $operations->sum('original_amount') }} €</dd>
								<dt class="col-sm-5">Total commissions<dt><dd class="col-sm-7">{{ $operations->sum('commission') }} €</dd>
							</dl>
						</div>
						{!! Form::open(array('route' => 'admin.agent.operations', 'method' => 'GET', 'role' => 'form', 'class' => 'needs-validation uk-margin-bottom')) !!}
							{!! csrf_field() !!}
							<div class="uk-grid-small" uk-grid>
								<div class="uk-width-expand">
									<fieldset class="form-group">
									<label>DateRangePicker</label>
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
									<th>Operation ID</th>
									<th>Original operation ID</th>
									<th>Agent</th>
									<th>Point</th>
									<th>Original amount</th>
									<th>Applied percentage</th>
									<th>Agent commission</th>
								</tr>
							</thead>
							<tbody>
							@if($operations->count()>0)
							@foreach($operations as $operation)
									<tr>
										<td>{{ $operation->created_at }}</td>
										<td>{{ $operation->id }}</td>
										<td>{{ $operation->service_operation_id }}</td>
										<td>{{ $operation->user->name }}</td>
										<td>{{ $operation->pointOperation->user->name }}</td>
										<td>{{ round($operation->original_amount,2) }}&nbsp;&euro;</td>
										<td>{{ round($operation->applied_percentage,2) }}&nbsp;%</td>
										<td>{{ round($operation->commission,2) }}&nbsp;&euro;</td>
									</tr>
							@endforeach
							@endif
							</tbody>
						</table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
	</script>
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
			console.log($("#date_begin").val());
			console.log($("#date_end").val());
		  });
		});
	</script>
@endsection