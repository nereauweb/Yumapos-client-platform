@extends('dashboard.base')
@section('css')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header" style="display:flex;justify-content: space-between;align-items: center;">
                <div>
                    <h3>{{ trans('titles.provider-data') }}</h3>
                </div>
                <div>
                    <a href="{{ route('admin.providers.create') }}" class="btn btn-info" id="create">{{ trans('titles.add-provider') }}</a>
                    <a href="{{ route('admin.providers.trash') }}" class="btn btn-danger" id="trash">{{ trans('titles.deleted-providers') }}</a>
                    @if(count($providers) > 0)
                        <a href="{{ route('admin.referents.create') }}" class="btn btn-success" id="add-referent">{{ trans('titles.add-referent') }}</a>
                        <a href="{{ route('admin.referents.trash') }}" class="btn btn-danger" id="trash-referent">{{ trans('titles.deleted-referents') }}</a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered" style="overflow-y: auto;">
                    <thead>
                        <tr>
                            <th>{{ trans('titles.id') }}</th>
                            <th>{{ trans('titles.company-name') }}</th>
                            <th>{{ trans('titles.email') }}</th>
                            <th>{{ trans('titles.phone') }}</th>
                            <th>{{ trans('titles.website') }}</th>
                            <th>{{ trans('titles.support-email') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($providers as $provider)
                        <tr>
                            <td>
                                <div class="btn-group btn-group-xs">
                                    <button type="button" class="btn btn-table-action dropdown-toggle" data-toggle="dropdown">
                                        {{ $provider->id }}
                                        <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                        <span class="sr-only">
                                                    Actions
                                                </span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="{{ route('admin.providers.edit', $provider->id) }}" class="dropdown-item btn-success">{{ __('coreuiforms.edit') }}</a>
                                        <form action="{{ route('admin.providers.destroy', $provider->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item btn-danger">{{ __('coreuiforms.delete') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $provider->company_name }}</td>
                            <td>{{ $provider->email }}</td>
                            <td>{{ $provider->phone }}</td>
                            <td>{{ $provider->website }}</td>
                            <th>{{ $provider->support_email }}</th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $providers->links() !!}
            </div>
        </div>
    </div>


@endsection
@section('javascript')

@endsection
