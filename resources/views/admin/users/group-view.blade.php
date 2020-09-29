@extends('dashboard.base')

@section('content')

	<div class="card">
		<div class="card-header">
			<div style="display: flex; justify-content: space-between; align-items: center;">
				{!! 'Visualizza gruppo utenti' !!}
				<div class="pull-right">
					<a href="{{ route('admin.groups.list') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ 'Torna alla lista gruppi' }}">
						<i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
						{!! 'Torna alla lista gruppi utenti' !!}
					</a>
				</div>
			</div>
		</div>
		<div class="card-body">

				<div class="form-group row">
					<label for="name" class="col-md-3 control-label">Nome</label>
					<div class="col-md-9">
						<div class="uk-text-bold">
							{{ $group->name }}
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="name" class="col-md-3 control-label">Slug</label>
					<div class="col-md-9">
						<div class="uk-text-bold">
							{{ $group->slug }}
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="name" class="col-md-3 control-label">Sconto</label>
					<div class="col-md-9">
						<div class="uk-text-bold">
							{{ $group->discount }} %
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="name" class="col-md-3 control-label">Descrizione</label>
					<div class="col-md-9">
						<div class="uk-text-bold">
							{{ $group->description }}
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="name" class="col-md-3 control-label">Utenti inclusi</label>
					<div class="col-md-9">
						<div class="uk-text-bold">
							<ul class="uk-list">
								@if($group->members&&$group->members->count()>0)
								@foreach ($group->members as $user)
								<li>{{ $user->name }}</li>
								@endforeach
								@endif
							</ul>
						</div>
					</div>
				</div>
				
		</div>

	</div>

@endsection
