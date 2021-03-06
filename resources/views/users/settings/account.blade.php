@extends('dashboard.base')

@section('css')
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>{{ ucfirst(auth()->user()->name).' '.auth()->user()->company_data->referent_surname }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(auth()->user()->company_data->company_name !== '' && !is_null(auth()->user()->company_data->company_name))
                            {{ trans('titles.company-name') }}: {{ auth()->user()->company_data->company_name }}
                        @endif
                        @if(auth()->user()->company_data->shop_sign !== '' && !is_null(auth()->user()->company_data->shop_sign))
                            Shop sign: {{ auth()->user()->company_data->shop_sign }}
                        @endif
                        {{ trans('titles.id') }}: {{ Auth::user()->id }}<br>
                        {{ trans('titles.balance') }}: {{ round(Auth::user()->plafond, 2) }} € <br>
						@if (auth()->user()->hasRole('sales'))
                        {{ trans('titles.credit') }}: {{ round(Auth::user()->credit, 2) }} € <br>
						@endif
                        {{ trans('titles.profile') }}:
                        {{ Auth::user()->group_id && Auth::user()->group_id != 0
                                ? Auth::user()->group->name
                                : trans('descriptions.error-msg-without-name') }}<br>
                        {{trans('titles.default-gain')}}: {{ Auth::user()->configuration ? Auth::user()->configuration->default_gain : 0 }}
                        %<br>
                        {!! Form::open(['route' => 'users.settings.update', 'method' => 'POST', 'role' => 'form', 'class' =>
                        'needs-validation']) !!}
                        {!! csrf_field() !!}
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="text-input">{{ trans('titles.gain') }} %</label>
                            <div class="col-md-9">
                                <input class="form-control" id="gain" type="number" name="gain"
                                    value="{{ Auth::user()->configuration ? Auth::user()->configuration->default_gain : 0 }}"
                                    step="0.01" required>
                            </div>
                        </div>

                        {!! Form::button(trans('titles.edit'), ['class' => 'btn btn-success margin-bottom-1 mb-1 float-right', 'type' =>
                        'submit']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        @if (auth()
            ->user()
            ->hasRole('sales'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <h3>{{ trans('titles.linked-users') }}</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (!empty(auth()->user()->referenced))
                                <div style="overflow:auto;">
                                    <table class="table table-striped table-bordered"
                                        id="admin-table">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('titles.name') }}</th>
												<th>{{ trans('titles.balance') }}</th>
                                                <th>{{ trans('titles.percentage') }}</th>
                                                <th>{{ trans('titles.state') }}</th>
                                                <th>{{ trans('titles.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (auth()->user()->referenced as $reference)
                                                <tr>
                                                    <td>{{ $reference->name }}</td>
                                                    <td>{{ number_format($reference->plafond,2) }} €</td>
                                                    <td>{{ $reference->parent_percent }}&percnt;</td>
                                                    <td>
                                                        <span class="badge px-4 py-2 @if($reference->state == 1) text-white bg-success @else text-dark bg-secondary @endif">
                                                            @if ($reference->state == 1)
                                                                {{ trans('titles.approved') }}
                                                            @else
                                                                {{ trans('titles.pending') }}
                                                            @endif
                                                        </span>
                                                    </td>
													<td>
														@if ($reference->state == 1)
															<a href="/users/payments/transfer/{{$reference->id}}" class="btn btn-sm btn-primary">{{ trans('titles.transfer-balance') }}</a>
														@endif
													</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <h3>No users assigned to {{ auth()->user()->name }} yet</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (auth()->user()->hasRole('user'))
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>{{ trans('titles.update-password') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.updatePassword') }}">
                            @method('PUT')
                            @csrf
                            <div class="form-group row">
                              <label for="password" class="col-sm-2 col-form-label">{{ trans('titles.new-password') }}</label>
                              <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" id="password">
                                @error('password')
                                <div>
                                    <span class="text-small text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                              </div>
                            </div>
                            <div class="form-group row">
                                <label for="confirm_password" class="col-sm-2 col-form-label">{{ trans('titles.confirm-password') }}</label>
                                <div class="col-sm-10">
                                    <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                                    @error('confirm_password')
                                    <div>
                                        <span class="text-small text-danger">{{ $message }}</span>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div>
                            <div class="d-flex align-items-end flex-column">
                                <button type="submit" class="btn btn-success">{{ trans('titles.update') }}</button>
                                </div>
                            </div>
                          </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

@endsection

@section('javascript')
<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/datatables.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('#daterange').daterangepicker({
        opens: 'left'
        }, function(start, end, label) {
        $("#date_begin").val(start.format('YYYY-MM-DD'));
        $("#date_end").val(end.format('YYYY-MM-DD'));
        console.log($("#date_begin").val());
        console.log($("#date_end").val());
        });
    });
</script>
@endsection
