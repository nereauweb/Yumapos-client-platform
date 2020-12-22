@extends('dashboard.base')

@section('css')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header" style="display:flex;justify-content: space-between;align-items: center;">
                <div>
                    <h3>{{ trans('titles.referent-data') }}</h3>
                </div>
                <div>
                    <a href="{{ route('admin.referents.create') }}" class="btn btn-info" id="create">{{ trans('titles.add-referent') }}</a>
                    <a href="{{ route('admin.referents.trash') }}" class="btn btn-danger" id="trash">{{ trans('titles.deleted-referents') }}</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered" style="overflow-y: auto;">
                    <thead>
                        <tr>
                            <th>{{ trans('titles.id') }}</th>
                            <th>{{ trans('titles.provider') }}</th>
                            <th>{{ trans('titles.name') }}</th>
                            <th>{{ trans('titles.surname') }}</th>
                            <th>{{ trans('titles.pec') }}</th>
                            <th>{{ trans('titles.email') }}</th>
                            <th>{{ trans('titles.phone') }}</th>
                            <th>{{ trans('titles.mobile') }}</th>
                            <th>{{ trans('titles.skype') }}</th>
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
                                                <a href="{{ route('admin.referents.edit', $referent->id) }}" class="dropdown-item btn-success">{{ __('coreuiforms.edit') }}</a>
                                                <form action="{{ route('admin.referents.destroy', $referent->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item btn-danger">{{ __('coreuiforms.delete') }}</button>
                                                </form>
                                            </div>
                                    </div>
                                </td>
                                <td>{{ $referent->provider->company_name }}</td>
                                <td>{{ $referent->name }}</td>
                                <td>{{ $referent->surname }}</td>
                                <td>{{ $referent->pec }}</td>
                                <td>{{ $referent->email }}</td>
                                <td>{{ $referent->phone }}</td>
                                <td>{{ $referent->mobile }}</td>
                                <td>{{ $referent->skype }}</td>
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
