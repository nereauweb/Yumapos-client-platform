@extends('dashboard.base')

@section('css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if (session()->has('status'))
                <div class="alert @if(session()->get('status') == 'success') alert-success @else alert-error @endif">
                    <span>{{ session()->get('message') }}</span>
                </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>Your account</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        ID: {{ Auth::user()->id }}<br>
                        Balance: {{ round(Auth::user()->plafond, 2) }} € <br>
                        Profile:
                        {{ Auth::user()->group_id && Auth::user()->group_id != 0
                                ? Auth::user()->group()->first()->name
                                : 'Undefined profile, account disabled. Please contact administration to fix this issue.' }}<br>
                        Default gain: {{ Auth::user()->configuration ? Auth::user()->configuration->default_gain : 0 }}
                        %<br>
                        {!! Form::open(['route' => 'users.settings.update', 'method' => 'POST', 'role' => 'form', 'class' =>
                        'needs-validation']) !!}
                        {!! csrf_field() !!}
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="text-input">Gain %</label>
                            <div class="col-md-9">
                                <input class="form-control" id="gain" type="number" name="gain"
                                    value="{{ Auth::user()->configuration ? Auth::user()->configuration->default_gain : 0 }}"
                                    step="0.01" required>
                            </div>
                        </div>

                        {!! Form::button('Edit', ['class' => 'btn btn-success margin-bottom-1 mb-1 float-right', 'type' =>
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
                                <h3>Sales</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (!empty(auth()->user()->referenced))
                                <div style="overflow:auto;">
                                    <table class="table table-striped table-bordered col-filtered-datatable"
                                        id="admin-table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Percentage</th>
                                                <th>State</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (auth()->user()->referenced as $reference)
                                                <tr>
                                                    <td>{{ $reference->name }}</td>
                                                    <td>{{ $reference->parent_percent }}&percnt;</td>
                                                    <td>
                                                        <span class="badge px-4 py-2 @if($reference->state == 1) text-white bg-success @else text-dark bg-secondary @endif">
                                                            @if ($reference->state == 1)
                                                                Approved
                                                            @else
                                                                Pending
                                                            @endif
                                                        </span>
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
        @endif
        @if (auth()->user()->hasRole('user'))
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>Update password</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.updatePassword') }}">
                            @method('PUT')
                            @csrf
                            <div class="form-group row">
                              <label for="current_password" class="col-sm-2 col-form-label">Old password</label>
                              <div class="col-sm-10">
                                <input type="password" name="current_password" class="form-control" id="current_password">
                                @error('current_password')
                                <div>
                                    <span class="text-small text-danger">{{ $message }}</span>
                                </div>
                                @enderror
                                @if (session()->has('password_err'))
                                <div>
                                    <span class="text-small text-danger">{{ session()->get('password_err') }}</span>
                                </div>
                                @endif
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="password" class="col-sm-2 col-form-label">New password</label>
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
                                <label for="confirm_password" class="col-sm-2 col-form-label">Confirm password</label>
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
                                <button type="submit" class="btn btn-success">Update</button>
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
