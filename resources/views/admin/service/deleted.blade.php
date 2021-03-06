@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="card">
		<div class="card-header">

			<div style="display: flex; justify-content: space-between; align-items: center;">
				<span id="card_title">
					<h1>{{ trans('titles.deleted-services') }}</h1>
				</span>

				<div class="btn-group pull-right btn-group-xs">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
						<span class="sr-only">
							{{ trans('titles.show-menu') }}
						</span>
					</button>
					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="/admin/shop/servicees/create">
							<i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
							{{ trans('titles.create-new-service') }}
						</a>
						<a class="dropdown-item" href="/admin/service/list">
							<i class="fa fa-fw fa-group" aria-hidden="true"></i>
							{{ trans('titles.show-list-services') }}
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
							<th>{{ trans('titles.id') }}</th>
							<th>{{ trans('titles.name') }}</th>
							<th>{{ trans('titles.category') }}</th>
							<th class="no-search no-sort"></th>
						</tr>
					</thead>
					<tbody id="users_table">
						@foreach($services as $service)
							<tr>
								<td>{{$service->id}}</td>
								<td>{{$service->name}}</td>
								<td>{{$service->category->name}}</td>
								<td>
									{!! Form::open(array('route' => ['admin.service.recover', $service->id], 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Ripristina')) !!}
										{!! Form::hidden('_method', 'PUT') !!}
										 {!! Form::button(trans('titles.recover-service'), array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => 'Ripristina servizio', 'data-message' => 'Ripristinare la servizio?')) !!}
									{!! Form::close() !!}
								</td>
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
