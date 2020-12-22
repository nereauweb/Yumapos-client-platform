@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="card">
		<div class="card-header">

			<div style="display: flex; justify-content: space-between; align-items: center;">

				<span id="card_title">
					<h1>{{ trans('titles.associations') }}</h1>
				</span>

			</div>
		</div>

		<div class="card-body">

			<div class="table-responsive">
				<table class="table table-striped table-sm datatable">
					<thead class="thead">
						<tr>
							<th>{{ trans('titles.id') }}</th>
							<th>{{ trans('titles.country') }}</th>
							<th>{{ trans('titles.name') }}</th>
							<th>{{ trans('titles.default') }}</th>
							<th>{{ trans('titles.ding') }}</th>
							<th>{{ trans('titles.reloadly') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($service_operators as $service_operator)
							<tr>
								<td>{{ $service_operator->id }}</td>
								<td>{{ $service_operator->country->name }}</td>
								<td>{{ $service_operator->name }}</td>
								<td>
									<select class="form-control form-control-sm master-select" data-id="{{ $service_operator->id }}">
										<option value="ding" {{ $service_operator->master == "ding" ? 'selected' : '' }}>Ding</option>
										<option value="reloadly" {{ $service_operator->master == "reloadly" ? 'selected' : '' }}>Reloadly</option>
									</select>
								</td>
								<td>{{ $service_operator->ding ? $service_operator->ding->Name : '' }}</td>
								<td>{{ $service_operator->reloadly ? $service_operator->reloadly->name : '' }}</td>
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
	<script>
		$(document).on('change','.master-select',function(){
			.post( "admin/service/associations/setMaster", { operator: $(this).data("id"), master: $(this).val() });
		});
	</script>
@endsection
