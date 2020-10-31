@extends('dashboard.base')

@section('css')
@endsection

@section('content')
	<div class="card">
		<div class="card-header">
			<div style="display: flex; justify-content: space-between; align-items: center;">
				<span id="card_title">
					<h1>Crea nuovo servizio</h1>
				</span>
				<div class="pull-right">
					<a href="{{ url('/admin/service/list') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Torna alla lista servizi">
						<i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
						Torna alla lista servizi
					</a>
				</div>
			</div>
		</div>

		<div class="card-body">
			{!! Form::open(array('route' => 'admin.service.store', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}

				{!! csrf_field() !!}

				<div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
					{!! Form::label('name', 'Nome', array('class' => 'col-md-3 control-label')); !!}
					<div class="col-md-9">
						<div class="input-group">
							{!! Form::text('name', NULL, array('id' => 'name', 'class' => 'form-control', 'placeholder' => 'Nome', 'required'=>'required')) !!}
						</div>
						@if ($errors->has('name'))
							<span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="form-group has-feedback row {{ $errors->has('category') ? ' has-error ' : '' }}">
					{!! Form::label('category', 'Categoria', array('class' => 'col-md-3 control-label')); !!}
					<div class="col-md-9">
						<div class="input-group">
							@if(!empty($categories))
							<div class="uk-width-1-1 uk-child-width-1-2 uk-grid-collapse" uk-grid>
								<div>
									{!! Form::select('category_id', $categories, 0, array('id' => 'category_id', 'class' => 'form-control', 'required' => 'required')) !!}
								</div>
								<div>
							@else
								<input type="hidden" name="category_id" value="0">
							@endif
									{!! Form::text('category', NULL, array('id' => 'category', 'class' => 'form-control', 'placeholder' => 'Categoria', 'required'=>'required')) !!}
							@if(!empty($categories))
								</div>
							</div>
							@endif
						</div>
						<span class="help-block">
							<small>Inserisci nome nuova categoria o selezionane una esistente dall'elenco</small>
							@if ($errors->has('category'))
									<br><strong>{{ $errors->first('category') }}</strong>								
							@endif
						</span>
					</div>
				</div>
					
				<div class="form-group has-feedback row {{ $errors->has('description') ? ' has-error ' : '' }}">
					{!! Form::label('description', 'Descrizione', array('class' => 'col-md-3 control-label')); !!}
					<div class="col-md-9">
						<div class="input-group">
							{!! Form::textarea('description', NULL, array('id' => 'description', 'class' => 'form-control', 'placeholder' => 'Nome')) !!}
						</div>
						@if ($errors->has('description'))
							<span class="help-block">
								<strong>{{ $errors->first('description') }}</strong>
							</span>
						@endif
					</div>
				</div>
				
				<div class="form-group has-feedback row {{ $errors->has('countries') ? ' has-error ' : '' }}">
					{!! Form::label('countries', 'Paesi', array('class' => 'col-md-3 control-label')); !!}
					<div class="col-md-9">
						<div class="input-group">
							{!! Form::select('countries[]', $countries, NULL, array('id' => 'countries', 'class' => 'form-control multiple-select', 'required'=>'required', 'multiple' => 'multiple')) !!}
						</div>
						@if ($errors->has('countries'))
							<span class="help-block">
								<strong>{{ $errors->first('countries') }}</strong>
							</span>
						@endif
					</div>
				</div>
				
				<div class="form-group has-feedback row {{ $errors->has('operators') ? ' has-error ' : '' }}">
					{!! Form::label('operators', 'Operatori', array('class' => 'col-md-3 control-label')); !!}
					<div class="col-md-9">
						<div class="input-group">
							{!! Form::select('operators[]', $operators, NULL, array('id' => 'operators', 'class' => 'form-control multiple-select', 'required'=>'required', 'multiple' => 'multiple')) !!}
						</div>
						@if ($errors->has('operators'))
							<span class="help-block">
								<strong>{{ $errors->first('operators') }}</strong>
							</span>
						@endif
					</div>
				</div>
				
				{!! Form::button('Crea nuovo servizio', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
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
		$('.multiple-select').select2();
	});
</script>
@endsection