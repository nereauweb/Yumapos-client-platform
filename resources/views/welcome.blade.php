@extends('dashboard.base')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if (session()->has('status'))
                    <div class="alert @if(session()->get('status') == 'success') alert-success @else alert-danger @endif" role="alert">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="card" uk-height-viewport="offset-top: true, offset-bottom: true">
                    <div class="card-body">
						<div class="uk-flex uk-flex-middle uk-flex-center">
							<h1>Welcome to Yumapos</h1>
						</div>
                    </div>
					<div class="uk-padding">
					</div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection