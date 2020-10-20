@extends('dashboard.base')

@section('css')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header" style="display:flex;justify-content: space-between;align-items: center;">
                <div>
                    <h3>Providers trashed data</h3>
                </div>
                <div>
                    <a href="{{ route('admin.providers.create') }}" class="btn btn-info" id="create">Add Provider</a>
                    <a href="{{ route('admin.providers.index') }}" class="btn btn-success" id="list">Available Providers list</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-responsive table-bordered" style="overflow-y: auto;">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>company_name</th>
                        <th>legal_seat</th>
                        <th>legal_seat_address</th>
                        <th>legal_seat_zip</th>
                        <th>legal_seat_city</th>
                        <th>legal_seat_region</th>
                        <th>legal_seat_country</th>
                        <th>operative_seat</th>
                        <th>operative_seat_address</th>
                        <th>operative_seat_zip</th>
                        <th>operative_seat_city</th>
                        <th>operative_seat_region</th>
                        <th>operative_seat_country</th>
                        <th>vat</th>
                        <th>tax_unique_code</th>
                        <th>pec</th>
                        <th>email</th>
                        <th>phone</th>
                        <th>website</th>
                        <th>support_email</th>
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
                                        <form action="{{ route('admin.providers.restore', $provider->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button class="dropdown-item btn-danger">Restore</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $provider->company_name }}</td>
                            <td>{{ $provider->legal_seat }}</td>
                            <td>{{ $provider->legal_seat_address }}</td>
                            <td>{{ $provider->legal_seat_zip }}</td>
                            <td>{{ $provider->legal_seat_city }}</td>
                            <td>{{ $provider->legal_seat_region }}</td>
                            <td>{{ $provider->legal_seat_country }}</td>
                            <td>{{ $provider->operative_seat }}</td>
                            <td>{{ $provider->operative_seat_address }}</td>
                            <td>{{ $provider->operative_seat_zip }}</td>
                            <td>{{ $provider->operative_seat_city }}</td>
                            <td>{{ $provider->operative_seat_region }}</td>
                            <td>{{ $provider->operative_seat_country }}</td>
                            <td>{{ $provider->vat }}</td>
                            <td>{{ $provider->tax_unique_code }}</td>
                            <td>{{ $provider->pec }}</td>
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
