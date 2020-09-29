@extends('dashboard.base')

@section('content')

	<div class="card">
		<div class="card-header">
			<div style="display: flex; justify-content: space-between; align-items: center;">
				Gruppi utente eliminati
				<div class="pull-right">
					<a href="{{ url('/admin/groups/') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('usersmanagement.tooltips.back-users') }}">
						<i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
						Torna alla lista gruppi utenti
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
									{!! Form::open(array('route' => ['admin.groups.recover', $group->id], 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Ripristina')) !!}
										{!! Form::hidden('_method', 'PUT') !!}
										 {!! Form::button('Ripristina gruppo', array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => 'Ripristina gruppo', 'data-message' => 'Ripristinare il gruppo utenti?')) !!}
									{!! Form::close() !!}
								</td>
							</tr>
						@endforeach
					</tbody>

				</table>

			</div>
		</div>
	</div>

	@include('modals.modal-save')

@endsection

@section('javascript')
	@include('scripts.save-modal-script')
	@include('scripts.check-changed')
@endsection