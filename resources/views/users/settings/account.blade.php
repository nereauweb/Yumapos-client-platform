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
						Balance: {{ round(Auth::user()->plafond,2) }} € <br>
						Profile: {{ Auth::user()->group_id&&Auth::user()->group_id!=0 ? Auth::user()->group()->first()->name : 'Undefined profile, account disabled. Please contact administration to fix this issue.' }}<br>
						Default gain: {{ Auth::user()->configuration ? Auth::user()->configuration->default_gain : 0 }} %<br>
						{!! Form::open(array('route' => 'users.settings.update', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
							{!! csrf_field() !!}
							<div class="form-group row">
								<label class="col-md-3 col-form-label" for="text-input">Gain %</label>
								<div class="col-md-9">
									<input class="form-control" id="gain" type="number" name="gain" value="{{ Auth::user()->configuration ? Auth::user()->configuration->default_gain : 0 }}" step="0.01" required>
								</div>
							</div>
				
							{!! Form::button('Edit', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
						{!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection