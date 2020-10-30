@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="card">
		<div class="card-header">

			<div style="display: flex; justify-content: space-between; align-items: center;">

				<span id="card_title">
					<h1>Servizi</h1>
				</span>

				<div class="btn-group pull-right btn-group-xs">
					<div>
						<a href="/admin/service/categories" class="btn btn-primary btn-save uk-margin-right">
							<span class="uk-margin-small-right" uk-icon="list"></span>Categorie
						</a>
						<a href="/admin/service/create" class="btn btn-success btn-save uk-margin-right">
							<span class="uk-margin-small-right" uk-icon="plus-circle"></span>Crea nuovo servizio
						</a>
						<a href="/admin/service/deleted" class="btn btn-default btn-save">
							<span class="uk-margin-small-right" uk-icon="ban"></span>Mostra servizi eliminati
						</a>
					</div>
				</div>
			</div>
		</div>
		
		<div class="card-body">

			<div class="table-responsive">
				<table class="table table-striped table-sm data-table">
					<thead class="thead">
						<tr>
							<th>Id</th>
							<th>Nome</th>
							<th>Categoria</th>
						</tr>
					</thead>
					<tbody id="users_table">
						@foreach($services as $service) 
							<tr>
								<td>
									<span class="uk-badge">{{ $service->id }}</span>
									<a href="{{ URL::to('admin/service/' . $service->id . '/edit') }}" class="uk-icon-button  uk-button-primary" uk-icon="file-edit" uk-tooltip="Modifica"></a>
									{!! Form::open(array('url' => 'admin/service/' . $service->id . '/delete', 'class' => 'needs-validation uk-display-inline-block', 'uk-tooltip' => 'Elimina', 'title' => 'Delete')) !!}
										{!! Form::hidden('_method', 'DELETE') !!}
										{!! Form::button('', array('class' => 'uk-icon-button uk-button-danger','type' => 'button', 'data-toggle' => 'modal','uk-icon' => 'ban', 'data-target' => '#confirmDelete', 'data-title' => 'Elimina servizio', 'data-message' => 'Sei sicuro di voler eliminare questa servizio?')) !!}
									{!! Form::close() !!}
								</td>
								<td>{{$service->name}}</td>	
								<td>{{$service->category->name}}</td>	
							</tr>
						@endforeach
					</tbody>

				</table>

			</div>
		</div>
	</div>		
@endsection

@section('javascript')
	<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
	<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('js/datatables.js') }}"></script>
@endsection