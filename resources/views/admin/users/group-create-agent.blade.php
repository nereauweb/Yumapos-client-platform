@extends('dashboard.base')

@section('content')

	<div class="card">
		<div class="card-header">
			<div style="display: flex; justify-content: space-between; align-items: center;">
				Crea nuovo gruppo agenti
				<div class="pull-right">
					<a href="{{ url('/admin/users/groups/') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('usersmanagement.tooltips.back-users') }}">
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
				
				@foreach($categories as $category)
					@foreach($target_groups as $target_group)
						<div class="form-group has-feedback row {{ $errors->has('categories') ? ' has-error ' : '' }}">
							{!! Form::label('cat'.$target_group->id.'-'.$category->id, $category->name . ' ' . $target_group->name, array('class' => 'col-md-3 control-label uk-text-bold')); !!}
							<div class="col-md-9">
								<div class="input-group row no-gutters">
									<div class="col-md-6">
										{!! Form::select('configurations['.$target_group->id.']['.$category->id.'][type]', [ 'percent' => 'Percentuale', 'value' => 'Valore'], NULL, array('id' => 'cat'.$target_group->id.'-'.$category->id, 'class' => 'form-control', 'placeholder' => 'Seleziona tipo','required' => 'required')) !!}
									</div>
									<div class="col-md-6">
										{!! Form::number('configurations['.$target_group->id.']['.$category->id.'][amount]', NULL, array('id' => 'cat'.$target_group->id.'-'.$category->id, 'class' => 'form-control', 'placeholder' => 'Valore','required' => 'required','step' => '0.01')) !!}
									</div>
								</div>
								@if ($errors->has('categories'))
									<span class="help-block">
										<strong>{{ $errors->first('categories') }}</strong>
									</span>
								@endif
							</div>
						</div>	
					@endforeach
				@endforeach
				
				<input type="hidden" name="type" value="2">
				
				{!! Form::button('Crea nuovo gruppo agenti', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
			{!! Form::close() !!}
		</div>

	</div>

@endsection

@section('javascript')
@endsection
