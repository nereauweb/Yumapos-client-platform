@extends('dashboard.base')

@section('content')

	<div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<div style="display: flex; justify-content: space-between; align-items: center;">
					{{ trans('titles.add-new-payment') }}
					<div class="pull-right">
						<a href="{{ url('/users/payments/') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('usersmanagement.tooltips.back-users') }}">
							<i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
							{{ trans('titles.rtp-list') }}
						</a>
					</div>
				</div>
			</div>

			<div class="card-body">
				{!! Form::open(array('route' => 'users.payments.store', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation', 'enctype' => 'multipart/form-data')) !!}

					{!! csrf_field() !!}
					
					@if (strpos($_SERVER["SERVER_NAME"],'ping')!== false &&Auth::user()->id==14 && Auth::user()->parent_id != 0 )
						<input type="hidden" name="type" value="4">
						<input type="hidden" name="target_id" value="{{Auth::user()->parent_id}}">
					@else
						<input type="hidden" name="type" value="1"> 
					@endif

					<div class="form-group has-feedback row {{ $errors->has('date') ? ' has-error ' : '' }}">
						{!! Form::label('date', trans('titles.date'), array('class' => 'col-md-3 control-label')); !!}
						<div class="col-md-9">
							<div class="input-group">
								{!! Form::text('date', date('d m Y'), array('id' => 'date', 'class' => 'form-control', 'placeholder' => 'Date','required' => 'required')) !!}
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

					<div class="form-group has-feedback row {{ $errors->has('file') ? ' has-error ' : '' }}">
						<div class="col-md-3 control-label">
							{{trans('titles.file-upload')}}
						</div>
						<div class="col-md-9">
							<div class="">
								<input type="file" class="" id="" name="document">
							</div>
							@if ($errors->has('document'))
								<span class="help-block">
									<strong>{{ $errors->first('document') }}</strong>
								</span>
							@endif
						</div>
					</div>
					@if($active)
						{!! Form::button(trans('titles.save-payment'), array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
					@else
						<div class="alert alert-danger ">
							<span>Attenzione: è già presente un'operazione recente. Attendi 5 minuti prima di effettuare un nuovo invio, se necessario.</span>
						</div>
					@endif
				{!! Form::close() !!}
			</div>

		</div>

	</div>
	
	<div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
						<div class="uk-flex uk-flex-middle uk-flex-center">
							<h1>{{ trans('titles.info') }}</h1>
						</div>
                    </div>
					<div class="uk-padding">
						@if(strpos($_SERVER["SERVER_NAME"],'ping')!== false)
						<dl class="row">
							<dt class="col-sm-5">{{ trans('titles.support') }}</dt>
							<dd class="col-sm-7">
								<ul class="uk-list">
									<li><i class="c-icon cil-phone"></i> +39 3396908512 / +39 3484321116 (whatsapp)</li>
									<li><i class="c-icon cil-at"></i> playluxsrls@gmail.com </li>
								</ul>
							</dd>
						</dl>
						<dl class="row">
							<dt class="col-sm-5">{{ trans('titles.bank-details') }}</dt>
							<dd class="col-sm-7">IT06 S030 6905 1101 0000 0017 585 <br>PLAYLUX S.R.L.</dd>
						</dl>	
						@else
						<dl class="row">
							<dt class="col-sm-5">{{ trans('titles.support') }}</dt>
							<dd class="col-sm-7">
								<ul class="uk-list">
									<li><i class="c-icon cil-phone"></i> +39 391 386 4315 </li>
									<li><i class="c-icon cil-at"></i> info@yumapos.it </li>
								</ul>
							</dd>
						</dl>
						<dl class="row">
							<dt class="col-sm-5">{{ trans('titles.bank-details') }}</dt>
							<dd class="col-sm-7">IT 70 U 07601 15800 001050287018 <br>AL.MO.MA. DI MANUELA MANCARELLA & C S.A.S</dd>
						</dl>
						@endif
					</div>
                </div>
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
