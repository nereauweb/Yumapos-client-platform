@extends('dashboard.base')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>Operazione MBS {{ $operation_name }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
						@if(isset($result))
							<div class="uk-margin-top">
								Raw result:
								<pre>{!! var_dump($result) !!}</pre>
							</div>
						@else
							<div class="uk-margin-top">
								NO RESULT
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
