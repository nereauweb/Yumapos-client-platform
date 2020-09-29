@extends('dashboard.base')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>Reloadly processing</h3>
                        </div>
                    </div>
                    <div class="card-body">
						<div>Count : {{ $count }}</div>
						<div>Log: {!! $log !!}</div>
						@if(isset($data))
						<div class="uk-margin-top">
							Debug:
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