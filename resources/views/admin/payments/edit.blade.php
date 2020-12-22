@extends('dashboard.base')

@section('content')

	<div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<div style="display: flex; justify-content: space-between; align-items: center;">
					{{ trans('titles.update-payment') }}
					<div class="pull-right">
						<a href="{{ url('/admin/payments/') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('usersmanagement.tooltips.back-users') }}">
							<i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
							{{ trans('titles.rtl-payments') }}
						</a>
					</div>
				</div>
			</div>
			<div class="card-body">
				{!! Form::open(array('route' => ['admin.payments.update', $payment->id], 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation', 'enctype' => 'multipart/form-data')) !!}
                    @method('PUT')
                    {!! csrf_field() !!}
					<div class="form-group has-feedback row {{ $errors->has('date') ? ' has-error ' : '' }}">
						{!! Form::label('date', trans('titles.date'), array('class' => 'col-md-3 control-label')); !!}
						<div class="col-md-9">
							<div class="input-group">
								{!! Form::text('date', date('d/m/Y', strtotime($payment->date)), array('id' => 'date', 'class' => 'form-control', 'placeholder' => 'Date','required' => 'required')) !!}
							</div>
							@if ($errors->has('date'))
								<span class="help-block">
									<strong>{{ $errors->first('date') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group has-feedback row {{ $errors->has('amount') ? ' has-error ' : '' }}">
						{!! Form::label('amount', trans('titles.amount').' (€)', array('class' => 'col-md-3 control-label')); !!}
						<div class="col-md-9">
							<div class="input-group">
								{!! Form::number('amount', $payment->amount, array('id' => 'amount', 'class' => 'form-control', 'min' => '0', 'step' => '0.01','required' => 'required')) !!}
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
								{!! Form::text('details', $payment->details, array('id' => 'details', 'class' => 'form-control', 'placeholder' => 'Add payment details')) !!}
							</div>
							@if ($errors->has('details'))
								<span class="help-block">
									<strong>{{ $errors->first('details') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group has-feedback row {{ $errors->has('file') ? ' has-error ' : '' }}">
						<div class="col-md-3 control-label">
							{{ trans('titles.file-upload') }}
						</div>
						<div class="col-md-9">
							<div class="custom-file">
								<div class="custom-file">
									<input type="file" class="custom-file-input" id="customFile" name="document">
									<label class="custom-file-label" for="customFile">{{ trans('titles.choose-file') }}</label>
								</div>
							</div>
							@if ($errors->has('document'))
								<span class="help-block">
									<strong>{{ $errors->first('document') }}</strong>
								</span>
							@endif
						</div>
					</div>

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
