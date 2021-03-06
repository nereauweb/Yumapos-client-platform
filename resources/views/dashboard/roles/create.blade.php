@extends('dashboard.base')

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>{{ __('coreuiforms.roles.create_new_role') }}</h4></div>
            <div class="card-body">
                <form method="POST" action="{{ route('roles.store') }}">
                    @csrf
                    <table class="table table-bordered datatable">
                        <tbody>
                            <tr>
                                <th>
                                {{ __('coreuiforms.roles.name') }}
                                </th>
                                <td>
                                    <input class="form-control" name="name" type="text"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-primary" type="submit">{{ __('coreuiforms.save') }}</button>
                    <a class="btn btn-primary" href="{{ route('roles.index') }}">{{ __('coreuiforms.return') }}</a>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('javascript')


@endsection
