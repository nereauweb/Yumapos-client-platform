@extends('dashboard.base')

@section('css')
    <style type="text/css" media="screen">
        .users-table {
            border: 0;
        }
        .users-table tr td:first-child {
            padding-left: 15px;
        }
        .users-table tr td:last-child {
            padding-right: 15px;
        }
        .users-table.table-responsive,
        .users-table.table-responsive table {
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')

	<div class="card">
		<div class="card-header">

			<div style="display: flex; justify-content: space-between; align-items: center;">

				<span id="card_title">
					Gruppi utenti
				</span>

				<div class="btn-group pull-right btn-group-xs">
					
						<a class="dropdown-item" href="/admin/users/groups/create">
							<i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
							Crea nuovo gruppo utenti
						</a>
				</div>
			</div>
		</div>
		
		<div class="card-body">
		
			<h1>Gruppi utenti</h1>

			<div class="table-responsive users-table ">
				<table class="table table-striped table-sm data-table">
					<thead class="thead">
						<tr>
							<th>Id</th>
							<th>Nome</th>
							<th>Slug</th>
							<th>Descrizione</th>
							<th class="no-search no-sort"></th>
							<th class="no-search no-sort"></th>
							<th class="no-search no-sort"></th>
							<th class="no-search no-sort"></th>
						</tr>
					</thead>
					<tbody id="users_table">
						@foreach($groups as $group) 
							<tr>
								<td>{{$group->id}}</td>
								<td>{{$group->name}}</td>
								<td>{{$group->slug}}</td>			
								<td>{{$group->description}}</td>	
								<td>
									<a class="btn btn-sm btn-success btn-block" href="{{ URL::to('admin/users/groups/' . $group->id) }}" data-toggle="tooltip" title="Show">
										Mostra gruppo utenti
									</a>
								</td>
								<td>
									<a class="btn btn-sm btn-info btn-block" href="{{ URL::to('admin/users/groups/' . $group->id . '/edit') }}" data-toggle="tooltip" title="Edit">
										Modifica gruppo utenti
									</a>
								</td>			
								<td>
									{!! Form::open(array('url' => 'admin/users/groups/' . $group->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
										{!! Form::hidden('_method', 'DELETE') !!}
										{!! Form::button('Elimina gruppo utenti', array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Provider', 'data-message' => 'Are you sure you want to delete this group ?')) !!}
									{!! Form::close() !!}
								</td>
							</tr>
						@endforeach
					</tbody>

				</table>

			</div>
		</div>
	</div>

	@include('modals.modal-delete')

@endsection

@section('javascript')
    @include('scripts.delete-modal-script')
@endsection