@extends('dashboard.base')

@section('style')
	.select2.select2-container {
		width: 100% !important;
	}
@endsection

@section('content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Gestisci categorie servizi</h3>
	</div>
	<div class="card-body">
		<div class="uk-child-width-1-2" uk-grid>
			<div>
				{!! Form::open(array('route' => 'admin.service.category.create', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation row uk-padding-small' )) !!}
					{!! csrf_field() !!}
					<div class="form-group has-feedback col-md-8 {{ $errors->has('name') ? ' has-error ' : '' }}">
						{!! Form::label('name', 'Inserisci nuova categoria', array('class' => 'row control-label')); !!}
						<div class="row">
							<div class="input-group">
								{!! Form::text('name', NULL, array('class' => 'form-control', 'id' => 'name', 'placeholder' => 'Nome categoria')); !!}
							</div>
							@if ($errors->has('name'))
								<span class="help-block">
									<strong>{{ $errors->first('name') }}</strong>
								</span>
							@endif
						</div>
					</div>
					<div class="form-group col-md-3">
						<label class="row control-label">&nbsp;</label>
						<div class="row">
							<div class="uk-width-1-1 uk-text-center">
								{!! Form::button('Inserisci', array('class' => 'btn btn-success btn-save','type' => 'submit')) !!}
							</div>
						</div>
					</div>
				{!! Form::close() !!}
				{!! Form::open(array('route' => 'admin.service.category.update', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation form-table' )) !!}
					{!! csrf_field() !!}
					<table class="table table-striped table-sm uk-width-1-1">
						<thead class="thead">
							<tr>
								<th>Categorie</th>	
								<th></th>
							</tr>
						</thead>
						<tbody class="ordered_table">	
							@if($categories)
							@foreach($categories as $category) 
								<tr id="category-{{ $category->id }}-row">
									<td class="data">
										<input type="text" name="categories[{{ $category->id }}][name]" value="{{ $category->name }}" class="uk-input">
										<input type="hidden" name="categories[{{ $category->id }}][delete]" value="0" class="delete-switcher">
									</td>
									<td>
										<a class="uk-icon-button remove_category" uk-icon="trash" style="color:red;" data-category-id="{{ $category->id }}"></a>
										<a class="uk-icon-button edit_category" uk-icon="pencil" style="color:blue;" data-category-id="{{ $category->id }}"></a>
									</td>
								</tr>
							@endforeach
							@endif
							<tr>
								<td>
									{!! Form::button('Salva modifiche', array('class' => 'btn btn-success btn-save uk-width-1-1','type' => 'submit')) !!}
								</td>
								<td></td>
							</tr>
						</tbody>
					</table>
				{!! Form::close() !!}
			</div>
			<div id="category-edit-box" style="display:none;">
			
				<div class="form-group has-feedback row {{ $errors->has('country_list_type') ? ' has-error ' : '' }}">
					{!! Form::label('country_list_type', 'Tipo lista paesi', array('class' => 'col-md-3 control-label')); !!}
					<div class="col-md-9">
						<div class="input-group">
							{!! Form::select('country_list_type', ['include'=>'include','exclude'=>'exclude'], NULL, array('id' => 'country_list_type', 'class' => 'form-control', 'required'=>'required')) !!}
						</div>
						@if ($errors->has('country_list_type'))
							<span class="help-block">
								<strong>{{ $errors->first('country_list_type') }}</strong>
							</span>
						@endif
					</div>
				</div>
				
				<div class="form-group has-feedback row {{ $errors->has('countries') ? ' has-error ' : '' }}">
					{!! Form::label('countries', 'Paesi', array('class' => 'col-md-3 control-label')); !!}
					<div class="col-md-9">
						<div class="input-group">
							{!! Form::select('countries[]', $countries, NULL, array('id' => 'countries', 'class' => 'form-control multiple-select uk-width-1-1', 'required'=>'required', 'multiple' => 'multiple')) !!}
						</div>
						@if ($errors->has('countries'))
							<span class="help-block">
								<strong>{{ $errors->first('countries') }}</strong>
							</span>
						@endif
					</div>
				</div>
			
				<div class="form-group has-feedback row {{ $errors->has('operator_list_type') ? ' has-error ' : '' }}">
					{!! Form::label('operator_list_type', 'Tipo lista operatori', array('class' => 'col-md-3 control-label')); !!}
					<div class="col-md-9">
						<div class="input-group">
							{!! Form::select('operator_list_type', ['include'=>'include','exclude'=>'exclude'], NULL, array('id' => 'operator_list_type', 'class' => 'form-control', 'required'=>'required')) !!}
						</div>
						@if ($errors->has('operator_list_type'))
							<span class="help-block">
								<strong>{{ $errors->first('operator_list_type') }}</strong>
							</span>
						@endif
					</div>
				</div>
				
				<div class="form-group has-feedback row {{ $errors->has('operators') ? ' has-error ' : '' }}">
					{!! Form::label('operators', 'operatori', array('class' => 'col-md-3 control-label')); !!}
					<div class="col-md-9">
						<div class="input-group">
							{!! Form::select('operators[]', $operators, NULL, array('id' => 'operators', 'class' => 'form-control multiple-select uk-width-1-1', 'required'=>'required', 'multiple' => 'multiple')) !!}
						</div>
						@if ($errors->has('operators'))
							<span class="help-block">
								<strong>{{ $errors->first('operators') }}</strong>
							</span>
						@endif
					</div>
				</div>
				
				<div class="form-group row">
					<div class="col-md-3"></div>
					<div class="col-md-9">
						{!! Form::button('Salva modifiche', array('class' => 'btn btn-success btn-save uk-width-1-1','id' => 'update_configuration')) !!}
					</div>
				</div>
				
			</div>
		</div>
	</div>	
</div>
@endsection

@section('javascript')
<script>
	$(document).ready(function(){
		
		var selectedCategoryId = 0;
		
		$(".remove_category").click(function(e){
			e.preventDefault();
			var categoryId = $(this).data("category-id");
			$("#category-"+categoryId+"-row > td.data > .delete-switcher").first().val(1);
			$("#category-"+categoryId+"-row").hide();
		});
		$('.multiple-select').select2();
		
		$(".edit_category").click(function(e){
			e.preventDefault();
			selectedCategoryId = $(this).data("category-id");
			$.getJSON( "/admin/service/categories/"+selectedCategoryId+"/data", function( data ) {
				console.log(data);
				$("#country_list_type").val(data.country_list_type);
				$('#countries').val(null);
				$.each(data.countries,function(i,e){
					$("#countries option[value='" + e + "']").prop("selected", true);
				});
				$('#countries').trigger('change');
				$("#operator_list_type").val(data.operator_list_type);
				$('#operators').val(null);
				$.each(data.operators,function(i,e){
					$("#operators option[value='" + e + "']").prop("selected", true);
				});
				$('#operators').trigger('change');
			});
			$("#category-edit-box").show();
		});
		
		$("#update_configuration").click(function(e){
			e.preventDefault();
			console.log($("#countries").val());
			$.ajaxSetup({
			   headers: {
				 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			   }
			});
			$.ajax({
				type: 'PUT',
				url: '/admin/service/categories/'+selectedCategoryId+'/update-configuration',
				data: {
					country_list_type: $("#country_list_type").val(),
					countries: JSON.stringify($("#countries").val()),
					operator_list_type: $("#operator_list_type").val(),
					operators: JSON.stringify($("#operators").val()),
				}
			}).fail(function (msg) {
				console.log('FAILED ' + msg);
			});
		});
		
	});
</script>
@endsection