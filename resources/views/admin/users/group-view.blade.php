@extends('dashboard.base')

@section('content')

	<div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    {{ trans('titles.show-group-client') }}
                    <div class="pull-right">
                        <a href="{{ route('admin.groups.list') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ 'Torna alla lista gruppi' }}">
                            <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                            {{ trans('titles.return-group-list') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="form-group row">
                    <label for="name" class="col-md-3 control-label">{{ trans('titles.name') }}</label>
                    <div class="col-md-9">
                        <div class="uk-text-bold">
                            {{ $group->name }}
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-3 control-label">{{ trans('titles.discount') }}</label>
                    <div class="col-md-9">
                        <div class="uk-text-bold">
                            {{ $group->discount }} %
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-3 control-label"> {{ trans('titles.description') }}</label>
                    <div class="col-md-9">
                        <div class="uk-text-bold">
                            {{ $group->description }}
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-3 control-label">{{ trans('titles.members') }}</label>
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
    </div>

@endsection
