@extends('dashboard.base')

@section('content')

	<div class="card">
		<div class="card-header">
			<div style="display: flex; justify-content: space-between; align-items: center;">
				{{ trans('titles.create-group') }}
				<div class="pull-right">
					<a href="{{ url('/admin/users/groups/') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('usersmanagement.tooltips.back-users') }}">
						<i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
						{{ trans('titles.return-group-list') }}
					</a>
				</div>
			</div>
		</div>

		<div class="card-body">
			{!! Form::open(array('route' => 'admin.groups.store', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation', 'files' => true)) !!}

				{!! csrf_field() !!}

				<div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
					{!! Form::label('name', trans('titles.name'), array('class' => 'col-md-3 control-label')); !!}
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

				<div class="form-group has-feedback row {{ $errors->has('discount') ? ' has-error ' : '' }}">
					{!! Form::label('discount', trans('titles.discount').' %', array('class' => 'col-md-3 control-label')); !!}
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
					{!! Form::label('description', trans('titles.description'), array('class' => 'col-md-3 control-label')); !!}
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

                <div class="form-group has-feedback row {{ $errors->has('use_margin') ? ' has-error ' : '' }}">
                    {!! Form::label('use_margin', 'Abilita margini', array('class' => 'col-md-3 control-label')); !!}
                    <div class="col-md-9">
                        <div class="input-group">
							<label>
								{!! Form::checkbox('use_margin', '1', true, array('id' => 'use_margin', 'class' => 'uk-checkbox')) !!}
							</label>
                        </div>
                        @if($errors->has('use_margin'))
                            <span class="help-block">
								<strong>{{ $errors->first('use_margin') }}</strong>
							</span>
                        @endif
                    </div>
                </div>

                <div class="form-group has-feedback row {{ $errors->has('logo') ? ' has-error ' : '' }}">
                    {!! Form::label('logo', 'Logo personalizzato', array('class' => 'col-md-3 control-label')); !!}
                    <div class="col-md-9">
                        <div class="input-group">
                            {!! Form::file('logo', array('id' => 'logo', 'class' => '', 'placeholder' => 'Logo personalizzato')) !!}							
                        </div>
                        @if($errors->has('logo'))
                            <span class="help-block">
								<strong>{{ $errors->first('logo') }}</strong>
							</span>
                        @endif
                    </div>
                </div>

				<input type="hidden" name="type" value="1">

				{!! Form::button(trans('titles.group-create-btn'), array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
			{!! Form::close() !!}
		</div>

	</div>

@endsection

@section('javascript')
@endsection
