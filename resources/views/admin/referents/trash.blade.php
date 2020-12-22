@extends('dashboard.base')

@section('css')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header" style="display:flex;justify-content: space-between;align-items: center;">
                <div>
                    <h3>{{ trans('titles.referents-trashed-data') }}</h3>
                </div>
                <div>
                    <a href="{{ route('admin.providers.index') }}" class="btn btn-info" id="list">{{ trans('titles.back') }}</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered" style="overflow-y: auto;">
                    <thead>
                    <tr>
                        <th>{{ trans('titles.id') }}</th>
                        <th>{{ trans('titles.surname') }}</th>
                        <th>{{ trans('titles.role') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($referents as $referent)
                        <tr>
                            <td>
                                <div class="btn-group btn-group-xs">
                                    <button type="button" class="btn btn-table-action dropdown-toggle" data-toggle="dropdown">
                                        {{ $referent->id }}
                                        <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                        <span class="sr-only">
                                                    {{ trans('titles.actions') }}
                                                </span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <form action="{{ route('admin.referents.restore', $referent->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button class="dropdown-item btn-danger">{{ trans('titles.restore') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $referent->surname }}</td>
                            <td>{{ $referent->role }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $referents->links() !!}
            </div>
        </div>
    </div>


@endsection

@section('javascript')

@endsection
