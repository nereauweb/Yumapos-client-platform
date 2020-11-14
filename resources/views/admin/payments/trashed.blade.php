@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
    <div class="container-fluid">
        <table class="table table-bordered rounded bg-white">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Amount</th>
                <th scope="col">User</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($trashed as $trash)
                <tr>
                    <th scope="row">{{ $trash->id }}</th>
                    <td>{{ $trash->amount }}</td>
                    <td>{{ $trash->user->name }}</td>
                    <td>
                        <form action="{{ route('admin.payments.recover-from-trash', $trash->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <button class="btn btn-success">Recover</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $trashed->links() !!}
    </div>
@endsection


