@extends('dashboard.base')

@section('content')

	<div class="card">
		<div class="card-header">
			<div style="display: flex; justify-content: space-between; align-items: center;">
				Crea nuovo gruppo agenti
				<div class="pull-right">
					<a href="{{ url('/admin/groups/') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('usersmanagement.tooltips.back-users') }}">
						<i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
						Torna alla lista gruppi
					</a>
				</div>
			</div>
		</div>

		<div class="card-body">
			{!! Form::open(array('route' => 'admin.groups.store', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}

				{!! csrf_field() !!}

				<div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
					{!! Form::label('name', 'Nome', array('class' => 'col-md-3 control-label')); !!}
					<div class="col-md-9">
						<div class="input-group">
							{!! Form::text('name', NULL, array('id' => 'name', 'class' => 'form-control', 'placeholder' => 'Nome','required' => 'required')) !!}
						</div>
						@if ($errors->has('name'))
							<span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
						@endif
					</div>
				</div>
											
				<div class="form-group has-feedback row {{ $errors->has('slug') ? ' has-error ' : '' }}">
					{!! Form::label('slug', 'Slug', array('class' => 'col-md-3 control-label')); !!}
					<div class="col-md-9">
						<div class="input-group">
							{!! Form::text('slug', NULL, array('id' => 'slug', 'class' => 'form-control', 'placeholder' => 'Slug','required' => 'required')) !!}
						</div>
						@if ($errors->has('slug'))
							<span class="help-block">
								<strong>{{ $errors->first('slug') }}</strong>
							</span>
						@endif
					</div>
				</div>
				
				<div class="form-group has-feedback row {{ $errors->has('discount') ? ' has-error ' : '' }}">
					{!! Form::label('discount', 'Discount %', array('class' => 'col-md-3 control-label')); !!}
					<div class="col-md-9">
						<div class="input-group">
							{!! Form::number('discount', 0, array('id' => 'discount', 'class' => 'form-control', 'placeholder' => 'Discount', 'min' => '0', 'step' => '0.001')) !!}
							<div class="input-group-append">
								<label for="discount" class="input-group-text">
									€
								</label>
							</div>
						</div>
						@if ($errors->has('discount'))
							<span class="help-block">
								<strong>{{ $errors->first('discount') }}</strong>
							</span>
						@endif
					</div>
				</div>
				
				<div class="form-group has-feedback row {{ $errors->has('description') ? ' has-error ' : '' }}">
					{!! Form::label('description', 'Descrizione', array('class' => 'col-md-3 control-label')); !!}
					<div class="col-md-9">
						<div class="input-group">
							{!! Form::text('description', NULL, array('id' => 'description', 'class' => 'form-control', 'placeholder' => 'Descrizione','required' => 'required')) !!}
						</div>
						@if ($errors->has('description'))
							<span class="help-block">
								<strong>{{ $errors->first('description') }}</strong>
							</span>
						@endif
					</div>
				</div>	
				
				<input type="hidden" name="type" value="2">
				
				{!! Form::button('Crea nuovo gruppo agenti', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
			{!! Form::close() !!}
		</div>

	</div>

@endsection

@section('javascript')
@endsection
