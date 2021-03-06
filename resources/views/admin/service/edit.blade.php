@extends('dashboard.base')

@section('css')
@endsection

@section('content')
	<div class="card">
		<div class="card-header">
			<div style="display: flex; justify-content: space-between; align-items: center;">
				<span id="card_title">
					<h1>{{ trans('titles.modify-service') }}</h1>
				</span>
				<div class="pull-right">
					<a href="{{ route('admin.service.list') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="Torna alla lista servizi">
						<i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
						{{ trans('titles.return-list-services') }}
					</a>
				</div>
			</div>
		</div>
		<div class="card-body">
			{!! Form::open(array('route' => ['admin.service.update', $service->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}

				{!! csrf_field() !!}

				<div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
					{!! Form::label('name', trans('titles.name'), array('class' => 'col-md-3 control-label')); !!}
					<div class="col-md-9">
						<div class="input-group">
							{!! Form::text('name', $service->name, array('id' => 'name', 'class' => 'form-control', 'placeholder' => 'Nome')) !!}
						</div>
						@if ($errors->has('name'))
							<span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="form-group has-feedback row {{ $errors->has('category') ? ' has-error ' : '' }}">
					{!! Form::label('category', trans('titles.category'), array('class' => 'col-md-3 control-label')); !!}
					<div class="col-md-9">
						<div class="input-group">
							@if(!empty($categories))
							<div class="uk-width-1-1 uk-child-width-1-2 uk-grid-collapse" uk-grid>
								<div>
									{!! Form::select('category_id', $categories, $service->category_id, array('id' => 'category_id', 'class' => 'form-control', 'placeholder' => 'Seleziona categoria')) !!}
								</div>
								<div>
							@else
								<input type="hidden" name="category_id" value="0">
							@endif
									{!! Form::text('category', NULL, array('id' => 'category', 'class' => 'form-control', 'placeholder' => 'Categoria', 'disabled' => 'disabled')) !!}
							@if(!empty($categories))
								</div>
							</div>
							@endif
						</div>
						@if ($errors->has('category'))
							<span class="help-block">
								<strong>{{ $errors->first('category') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="form-group has-feedback row {{ $errors->has('description') ? ' has-error ' : '' }}">
					{!! Form::label('description', trans('titles.description'), array('class' => 'col-md-3 control-label')); !!}
					<div class="col-md-9">
						<div class="input-group">
							{!! Form::textarea('description', $service->description, array('id' => 'description', 'class' => 'form-control', 'placeholder' => 'Nome')) !!}
						</div>
						@if ($errors->has('description'))
							<span class="help-block">
								<strong>{{ $errors->first('description') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="row">
					<div class="col-6 col-sm-6 offset-6">
						{!! Form::button('<i class="fa fa-fw fa-save" aria-hidden="true"></i>'.trans('titles.save'), array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave')) !!}
					</div>
				</div>
			{!! Form::close() !!}
		</div>

	</div>
@endsection

@section('javascript')
	<script>
		$(document).ready(function(){
			$("#category_id").change(function(){
				if ($("#category_id").val()==0){
					$("#category").prop('disabled',false);
				} else {
					$("#category").prop('disabled',true);
				}
			});
		});
	</script>
@endsection
