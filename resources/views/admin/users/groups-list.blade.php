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

	<div class="container-fluid">
        <div class="card">
            <div class="card-header">

                <div style="display: flex; justify-content: space-between; align-items: center;">

				<span id="card_title">
					<h1>Gruppi utenti</h1>
				</span>

                    <div class="btn-group btn-success pull-right btn-group-xs">

                        <a class="dropdown-item" href="/admin/users/groups/create">
                            <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                            Crea nuovo gruppo utenti
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">

                

                <div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Slug</th>
                            <th>Descrizione</th>
                        </tr>
                        </thead>
                        <tbody id="users_table">
                        @foreach($groups as $group)
							@if($group->type==1)
                            <tr>
                                <td scope="row">
                                    <div class="btn-group btn-group-xs">
                                        <button type="button" class="btn btn-table-action dropdown-toggle" data-toggle="dropdown">
                                            {{ $group->id }}
                                            <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                            <span class="sr-only">
									            Actions
								            </span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <div class="uk-width-small">
                                                <a class="btn btn-sm btn-success btn-block dropdown-item" href="{{ URL::to('admin/users/groups/' . $group->id) }}" data-toggle="tooltip" title="Show">
                                                    Mostra gruppo utenti
                                                </a>
                                                <a class="btn btn-sm btn-info btn-block dropdown-item" href="{{ URL::to('admin/users/groups/' . $group->id . '/edit') }}" data-toggle="tooltip" title="Edit">
                                                    Modifica gruppo utenti
                                                </a>
                                                {!! Form::open(array('url' => 'admin/users/groups/' . $group->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                {!! Form::button('Elimina gruppo utenti', array('class' => 'btn btn-danger btn-sm dropdown-item','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Provider', 'data-message' => 'Are you sure you want to delete this group ?')) !!}
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td scope="row">{{$group->name}}</td>
                                <td scope="row">{{$group->slug}}</td>
                                <td scope="row">{{$group->description}}</td>
                            </tr>
							@endif
                        @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
		
		<div class="card">
            <div class="card-header">

                <div style="display: flex; justify-content: space-between; align-items: center;">

				<span id="card_title">
					<h1>Gruppi agenti</h1>
				</span>

                    <div class="btn-group btn-success pull-right btn-group-xs">

                        <a class="dropdown-item" href="/admin/users/groups/create-agent">
                            <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                            Crea nuovo gruppo agenti
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">

                

                <div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Slug</th>
                            <th>Descrizione</th>
                        </tr>
                        </thead>
                        <tbody id="users_table">
                        @foreach($groups as $group)
							@if($group->type==2)
                            <tr>
                                <td scope="row">
                                    <div class="btn-group btn-group-xs">
                                        <button type="button" class="btn btn-table-action dropdown-toggle" data-toggle="dropdown">
                                            {{ $group->id }}
                                            <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                            <span class="sr-only">
									            Actions
								            </span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <div class="uk-width-small">
                                                <a class="btn btn-sm btn-success btn-block dropdown-item" href="{{ URL::to('admin/users/groups/' . $group->id) }}" data-toggle="tooltip" title="Show">
                                                    Mostra gruppo utenti
                                                </a>
                                                <a class="btn btn-sm btn-info btn-block dropdown-item" href="{{ URL::to('admin/users/groups/' . $group->id . '/edit') }}" data-toggle="tooltip" title="Edit">
                                                    Modifica gruppo utenti
                                                </a>
                                                {!! Form::open(array('url' => 'admin/users/groups/' . $group->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                {!! Form::button('Elimina gruppo utenti', array('class' => 'btn btn-danger btn-sm dropdown-item','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Provider', 'data-message' => 'Are you sure you want to delete this group ?')) !!}
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td scope="row">{{$group->name}}</td>
                                <td scope="row">{{$group->slug}}</td>
                                <td scope="row">{{$group->description}}</td>
                            </tr>
							@endif
                        @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
		
    </div>

	@include('modals.modal-delete')

@endsection

@section('javascript')
    @include('scripts.delete-modal-script')
@endsection
