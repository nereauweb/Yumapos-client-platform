@extends('dashboard.base')

@section('css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (auth()->user()->referenced as $reference)
                                                <tr>
                                                    <td>{{ $reference->name }}</td>
                                                    <td>{{ $reference->parent_percent }}&percnt;</td>
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
    </div>

@endsection

@section('javascript')
@endsection
