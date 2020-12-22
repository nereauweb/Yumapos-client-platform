@extends('dashboard.base')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>{{ trans('titles.reloadly-response') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
						{{ trans('titles.log') }}: {!! $log !!}
						<pre>{!! var_dump($data) !!}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection
