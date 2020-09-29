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
                            <h3>Calls {{date("d/m/Y",strtotime($date_begin))}} - {{date("d/m/Y",strtotime($date_end))}}</h3>
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
						{!! Form::open(array('route' => 'admin.report.calls', 'method' => 'GET', 'role' => 'form', 'class' => 'needs-validation uk-margin-bottom')) !!}
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
										<th>ID</th>
										<th>Date</th>
										<th>User</th>
										<th>Type</th>
										<th>Path</th>
										<th>Parameters</th>
										<th>Log</th>
										<th>Answer</th>
									</tr>
								</thead>
								<tbody>
								@if($operations->count()>0)
								@foreach($operations as $operation)
										<tr>
											<td>{{ $operation->id }}</td>
											<td>{{ date("d/m/Y H:i:s",strtotime($operation->created_at)) }}</td>
											<td>{{ $operation->user_id ? $operation->user->name : '' }}</td>
											<td>{{ $operation->type }}</td>
											<td>{{ $operation->path }}</td>
											<td>{{ $operation->parameters }}</pre></td>
											<td>{{ $operation->log }}</td>
											<td>{{ $operation->raw_answer }}</pre></td>
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