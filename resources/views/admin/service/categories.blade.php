@extends('dashboard.base')

@section('css')
@endsection

@section('content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Gestisci categorie servizi</h3>
	</div>
	<div class="card-header">
		<div class="row uk-padding-small">
			{!! Form::open(array('route' => 'admin.service.category.create', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation col-md-6 row uk-padding-small' )) !!}
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
			{!! Form::open(array('route' => 'admin.service.category.update', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation col-md-6 form-table' )) !!}
			{!! csrf_field() !!}
					<h4>Categorie</h4>
					<table class="table table-striped table-sm uk-width-1-1">
						<thead class="thead">
							<tr>
								<th>Nome</th>	
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
									</td>
								</tr>
							@endforeach
							@endif
							<tr>
								<td>
									{!! Form::button('Aggiorna', array('class' => 'btn btn-success btn-save uk-width-1-1','type' => 'submit')) !!}
								</td>
								<td></td>
							</tr>
						</tbody>
					</table>
			{!! Form::close() !!}
		</div>
	</div>	
</div>
@endsection

@section('javascript')
<script>
	$(document).ready(function(){
		$(".remove_category").click(function(e){
			e.preventDefault();
			var categoryId = $(this).data("category-id");
			$("#category-"+categoryId+"-row > td.data > .delete-switcher").first().val(1);
			$("#category-"+categoryId+"-row").hide();
		});			
	});
</script>
@endsection