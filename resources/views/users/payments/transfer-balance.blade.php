@extends('dashboard.base')

@section('content')

	<div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<div style="display: flex; justify-content: space-between; align-items: center;">
					{{ trans('titles.transfer-balance') . ' ' . trans('titles.to') . ': '. $user->name}}
					<div class="pull-right">
						<a href="{{ url('/users/payments/') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('usersmanagement.tooltips.back-users') }}">
							<i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
							{{ trans('titles.return-to-users-list') }}
						</a>
					</div>
				</div>
			</div>

			<div class="card-body">
				{!! Form::open(array('route' => 'users.payments.transfer.do', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}

					{!! csrf_field() !!}

					<div class="form-group has-feedback row {{ $errors->has('amount') ? ' has-error ' : '' }}">
						{!! Form::label('amount', trans('titles.amount').' (€)', array('class' => 'col-md-3 control-label')); !!}
						<div class="col-md-9">
							<div class="input-group">
								{!! Form::number('amount', 0, array('id' => 'amount', 'class' => 'form-control', 'min' => '0', 'step' => '0.01','required' => 'required')) !!}
								<div class="input-group-append">
									<label for="amount" class="input-group-text">
										€
									</label>
								</div>
							</div>
							@if ($errors->has('amount'))
								<span class="help-block">
									<strong>{{ $errors->first('amount') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group has-feedback row {{ $errors->has('details') ? ' has-error ' : '' }}">
						{!! Form::label('details', trans('titles.details'), array('class' => 'col-md-3 control-label')); !!}
						<div class="col-md-9">
							<div class="input-group">
								{!! Form::text('details', NULL, array('id' => 'details', 'class' => 'form-control', 'placeholder' => 'Add payment details')) !!}
							</div>
							@if ($errors->has('details'))
								<span class="help-block">
									<strong>{{ $errors->first('details') }}</strong>
								</span>
							@endif
						</div>
					</div>
					
					{!! Form::hidden('target_id', $user->id); !!}
					
					{!! Form::button(trans('titles.save-payment'), array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
				{!! Form::close() !!}
			</div>

		</div>

	</div>
@endsection

@section('javascript')
	<script src="/js/jquery.maskedinput.js" type="text/javascript"></script>
	<script type="text/javascript">
		$("#date").mask("99/99/9999");
	</script>
@endsection
