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
                            <h3>{{ trans('titles.operation-result') }}</h3>
                        </div>
                    </div>
					@if($response['result']==0)
						<div class="card-body">
							{{ trans('descriptions.general-error-ownf') }}
							<br><hr><br>
							Log: {!! $log !!} <br><br>
							Debug: <br>
							<pre>{!! var_dump($data) !!}</pre>
						</div>
					@elseif($response['result']==-1)
						<div class="card-body">
							{{ trans('descriptions.stocnb-finalized') }}: {{ $response['message'] }}
						</div>
					@else
						<div class="card-body">
							{{ trans('titles.operation-success') }}
							<br><hr><br>
							<dl class="row">

								<dt class="col-sm-5">{{ trans('titles.operation-id') }}</dt>
								<dd class="col-sm-7">{{ $response['operation_id'] }}</dd>

								<dt class="col-sm-5">{{ trans('title.operator') }}</dt>
								<dd class="col-sm-7">{{ is_array($operator) ? $operator['name'] : $operator->name }}</dd>

								<dt class="col-sm-5">{{ trans('titles.country') }}</dt>
								<dd class="col-sm-7">{{ is_array($operator) ? $operator['country_name'] : $operator->country->name }} {{ is_array($operator) ? $operator['country_isoname'] : $operator->country->isoName }}</dd>

								<dt class="col-sm-5">{{ trans('titles.phone-number') }}</dt>
								<dd class="col-sm-7">{{ $response['request_recipient_phone'] }}</dd>

								<dt class="col-sm-5">{{ trans('titles.er-amount') }}</dt>
								<dd class="col-sm-7">{{ $response['final_expected_destination_amount'] }} {{ is_array($operator) ? $operator['currency_symbol'] : $operator->destinationCurrencySymbol }}</dd>

								<dt class="col-sm-5">{{ trans('titles.total-paid') }}</dt>
								<dd class="col-sm-7">{{ $response['final_amount'] }} &euro;</dd>

								<dt class="col-sm-5">{{ trans('titles.user-gain') }}</dt>
								<dd class="col-sm-7">{{ $response['user_gain'] }} &euro;</dd>

								<dt class="col-sm-5">{{ trans('titles.user-platform-discount') }}</dt>
								<dd class="col-sm-7">{{ $response['user_discount'] }} &euro;</dd>

								<dt class="col-sm-5">{{ trans('titles.user-total-gain') }}</dt>
								<dd class="col-sm-7">{{ $response['user_total_gain'] }} &euro;</dd>
								
								@if(isset($response['pin']))
									<dt class="col-sm-5">PIN</dt>
									<dd class="col-sm-7">{{ $response['pin'] }} &euro;</dd>
								@endif
								
								@if(isset($response['pin_serial']))
									<dt class="col-sm-5">PIN serial</dt>
									<dd class="col-sm-7">{{ $response['pin_serial'] }} &euro;</dd>
								@endif
								
								@if(isset($response['pin_expiry']))
									<dt class="col-sm-5">PIN expiry</dt>
									<dd class="col-sm-7">{{ $response['pin_expiry'] }} &euro;</dd>
								@endif

							</dl>

							<br><hr><br>

							<a href="/users/services/print/{{ $response['operation_id'] }}" target="_BLANK">{{ trans('titles.print-receipt') }}</a>
							<a href="/users/services/print/{{ $response['operation_id'] }}/small" target="_BLANK">[{{ trans('titles.small') }}]</a>

						</div>
					@endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection
