@extends('dashboard.base')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>{{ trans('titles.reloadly-processing') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
						<div>{{ trans('titles.count') }} : {{ $count }}</div>
						<div>{{ trans('titles.log') }}: {!! $log !!}</div>
						@if(isset($data))
						<div class="uk-margin-top">
							{{ trans('titles.debug') }}:
							<pre>{!! var_dump($data) !!}</pre>
						</div>
						@endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection
