@extends('dashboard.base')

@section('css')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header" style="display:flex;justify-content: space-between;align-items: center;">
                <div>
                    <h3>Referents trashed data</h3>
                </div>
                <div>
                    <a href="{{ route('admin.providers.index') }}" class="btn btn-info" id="list">Return back</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered" style="overflow-y: auto;">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Referent surname</th>
                        <th>Referent role</th>
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
                                                    Actions
                                                </span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <form action="{{ route('admin.referents.restore', $referent->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button class="dropdown-item btn-danger">Restore</button>
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
