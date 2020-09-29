@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="">
                <div class="card">
					<div class="card-header">
						<div class=" uk-child-width-1-2" uk-grid>
							<div>
								<h4>{{ __('coreuiforms.users.users') }}</h4>
							</div>
							<div class="uk-text-right">
								<a class="uk-button uk-link-reset btn btn-success" href="/users/create">
									Crea nuovo utente
								</a>
								<a class="uk-button uk-link-reset btn btn-danger" href="/users/deleted">
									Utenti eliminati
								</a>
							</div>
						</div>
					</div>
                    <div class="card-body">
                        <table class="table table-striped table-sm col-filtered-datatable">
                        <thead>
                          <tr>
                            {{-- <th>{{ __('coreuiforms.users.username') }}</th> --}}
                            <th>{{ __('lists.businessname') }}</th>
                            <th>{{ __('lists.city') }}</th>
                            <th>{{ __('coreuiforms.users.email') }}</th>
                            <th>{{ __('coreuiforms.users.roles') }}</th>
                            <th>Balance (€)</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($users as $user)
                            <tr>
                              {{-- <td>{{ $user->name }}</td> --}}
                              <td>{{ ucfirst($user->company_data->company_name) }}</td>
                              <td>{{ ucfirst($user->company_data->legal_seat_city)  }}</td>
                              <td>{{ $user->email }}</td>
                              <td>{{ $user->menuroles }}</td>
                              <td>{{ $user->plafond }}</td>
                              <td>
                                <a href="{{ url('/users/' . $user->id) }}" class="btn btn-primary">{{ __('coreuiforms.view') }}</a>
                                <a href="{{ url('/users/' . $user->id . '/edit') }}" class="btn btn-primary">{{ __('coreuiforms.edit') }}</a>
                                @if( $you->id !== $user->id )
                                <form action="{{ route('users.destroy', $user->id ) }}" method="POST" style="display:inline-block">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger">{{ __('coreuiforms.delete') }}</button>
                                </form>
                                @endif
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection


@section('javascript')
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>
@endsection

