@extends('dashboard.base')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>{{ trans('titles.ding-test') }} - {{ $request_description }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
						@if (!is_array($result)&&!is_object($result))
							{!! $result !!}
						@else
							<dl class="uk-description-list">
								@if (method_exists($result,'getItems'))
									<dt>{{ trans('titles.result-code') }}</dt><dd>{{ $result->getResultCode() }}</dd>
									<dt>{{ trans('titles.error-codes') }}</dt><dd>{{ implode(',',$result->getErrorCodes()) }}</dd>
									<dt>{{ trans('titles.items') }} #{{ count($result->getItems()) }}</dt>
									<dd>
										<br>
										@foreach ($result->getItems() as $item)
											<pre>{!! var_dump($item) !!}</pre>
										@endforeach
									</dd>
								@else
									<dt>Dump</dt>
									<dd><pre>@php var_dump($result) @endphp</pre></dd>
								@endif
							</dl>
						@endif
					</div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection
