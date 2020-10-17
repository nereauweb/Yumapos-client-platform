@extends('dashboard.base')

@section('css')
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.min.css">
@endsection

@section('content')

	<div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    {!! 'Modifica gruppo utenti' !!}
                    <div class="pull-right">
                        <a href="{{ route('admin.groups.list') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ 'Torna alla lista gruppi utenti' }}">
                            <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                            {!! 'Torna alla lista gruppi utenti' !!}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => ['admin.groups.update', $group->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}

                {!! csrf_field() !!}

                <div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
                    {!! Form::label('name', 'Nome del gruppo utenti', array('class' => 'col-md-3 control-label')); !!}
                    <div class="col-md-9">
                        <div class="input-group">
                            {!! Form::text('name', $group->name, array('id' => 'name', 'class' => 'form-control', 'placeholder' => 'Nome del gruppo utenti')) !!}
                        </div>
                        @if($errors->has('name'))
                            <span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
                        @endif
                    </div>
                </div>

                <div class="form-group has-feedback row {{ $errors->has('slug') ? ' has-error ' : '' }}">
                    {!! Form::label('slug', 'Slug', array('class' => 'col-md-3 control-label')); !!}
                    <div class="col-md-9">
                        <div class="input-group">
                            {!! Form::text('slug', $group->slug, array('id' => 'slug', 'class' => 'form-control', 'placeholder' => 'Cognome referente','required' => 'required')) !!}
                        </div>
                        @if ($errors->has('slug'))
                            <span class="help-block">
								<strong>{{ $errors->first('slug') }}</strong>
							</span>
                        @endif
                    </div>
                </div>

                <div class="form-group has-feedback row {{ $errors->has('discount') ? ' has-error ' : '' }}">
                    {!! Form::label('discount', 'Discount %', array('class' => 'col-md-3 control-label')); !!}
                    <div class="col-md-9">
                        <div class="input-group">
                            {!! Form::number('discount', $group->discount, array('id' => 'discount', 'class' => 'form-control', 'placeholder' => 'Discount', 'min' => '0', 'step' => '0.001')) !!}
                            <div class="input-group-append">
                                <label for="discount" class="input-group-text">
                                    €
                                </label>
                            </div>
                        </div>
                        @if ($errors->has('discount'))
                            <span class="help-block">
								<strong>{{ $errors->first('discount') }}</strong>
							</span>
                        @endif
                    </div>
                </div>

                <div class="form-group has-feedback row {{ $errors->has('description') ? ' has-error ' : '' }}">
                    {!! Form::label('description', 'Descrizione', array('class' => 'col-md-3 control-label')); !!}
                    <div class="col-md-9">
                        <div class="input-group">
                            {!! Form::text('description', $group->description, array('id' => 'description', 'class' => 'form-control', 'placeholder' => 'Cellulare referente','required' => 'required')) !!}
                        </div>
                        @if ($errors->has('description'))
                            <span class="help-block">
								<strong>{{ $errors->first('description') }}</strong>
							</span>
                        @endif
                    </div>
                </div>

                <div class="form-group has-feedback row {{ $errors->has('users') ? ' has-error ' : '' }}">
                    <label for="users" class="col-md-3 control-label">
                        Utenti
                    </label>
                    <div class="col-md-9">
                        <select name="users[]" id="users" class="selectized" multiple required>
                            <option value="">Seleziona</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $user->group_id == $group->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has('users'))
                        <div class="col-12">
							<span class="help-block">
								<strong>{{ $errors->first('users') }}</strong>
							</span>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-12">
                        {!! Form::button(trans('forms.save-changes'), array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('modals.edit_user__modal_text_confirm_title'), 'data-message' => trans('modals.edit_user__modal_text_confirm_message'))) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>

    @include('modals.modal-save')

@endsection

@section('javascript')
	@include('scripts.save-modal-script')
	@include('scripts.check-changed')
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			$(".selectized").selectize({
				placeholder: 'Aggiungi',
				allowClear: true,
				create: false,
				highlight: true,
				diacritics: true
			});
		});
	</script>
@endsection
