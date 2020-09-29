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
                            <h3>Operation result</h3>
                        </div>
                    </div>
					@if($response['result']==0)
						<div class="card-body">
							An error occurred, operation was not finalized
							<br><hr><br>
							Log: {!! $log !!} <br><br>
							Debug: <br>
							<pre>{!! var_dump($data) !!}</pre>
						</div>
					@elseif($response['result']==-1)
						<div class="card-body">
							Sorry, the operation could not be finalized: {{ $response['message'] }}
						</div>
					@else
						<div class="card-body">
							Operation success!
							<br><hr><br>
							<dl class="row">
					
								<dt class="col-sm-5">Operation ID</dt>
								<dd class="col-sm-7">{{ $response['operation_id'] }}</dd>
							
								<dt class="col-sm-5">Operator</dt>
								<dd class="col-sm-7">{{ $operator->name }}</dd>
							
								<dt class="col-sm-5">Country</dt>
								<dd class="col-sm-7">{{ $operator->country->name }} {{ $operator->country->isoName }}</dd>
							
								<dt class="col-sm-5">Phone number</dt>
								<dd class="col-sm-7">{{ $response['request_recipient_phone'] }}</dd>
							
								<dt class="col-sm-5">Expected received amount</dt>
								<dd class="col-sm-7">{{ $response['final_expected_destination_amount'] }} {{ $operator->destinationCurrencySymbol }}</dd>
							
								<dt class="col-sm-5">Total paid</dt>
								<dd class="col-sm-7">{{ $response['final_amount'] }} &euro;</dd>
							
								<dt class="col-sm-5">User gain</dt>
								<dd class="col-sm-7">{{ $response['user_gain'] }} &euro;</dd>
							
								<dt class="col-sm-5">User platform discount</dt>
								<dd class="col-sm-7">{{ $response['user_discount'] }} &euro;</dd>
							
								<dt class="col-sm-5">User total gain</dt>
								<dd class="col-sm-7">{{ $response['user_total_gain'] }} &euro;</dd>
							
							</dl>							
							
							<br><hr><br>
							
							<a href="/users/services/print/{{ $response['operation_id'] }}" target="_BLANK">Print receipt</a> 
							<a href="/users/services/print/{{ $response['operation_id'] }}/small" target="_BLANK">[small]</a>
							
						</div>
					@endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection