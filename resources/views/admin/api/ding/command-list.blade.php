@extends('dashboard.base')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>Ding requests</h3>
                        </div>
                    </div>
                    <div class="card-body">						
						<ul class="nav flex-column">
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/admin/api/ding/ErrorCodeDescriptions') }}">Error code descriptions</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/admin/api/ding/Currencies') }}">Currencies</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/admin/api/ding/Regions') }}">Regions</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/admin/api/ding/Countries') }}">Countries</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/admin/api/ding/Providers') }}">Providers</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/admin/api/ding/ProviderStatus') }}">Providers status</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/admin/api/ding/Products') }}">Products</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/admin/api/ding/ProductDescriptions') }}">Products descriptions</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/admin/api/ding/Balance') }}">Balance</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/admin/api/ding/Promotions') }}">Promotions</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/admin/api/ding/PromotionDescriptions') }}">Promotions descriptions</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/admin/api/ding/AccountLookup') }}">Account lookup</a>
							</li>
						</ul>
						{{--
						<div class="uk-padding-small" uk-grid>
							<div class="uk-width-1-4">Send transfer</div>
							<div class="uk-width-3-4">
								{!! Form::open(array('route' => 'admin.api.ding.fx_rates', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
								{!! csrf_field() !!}
									Operator id
									<input name="operator_id" class="uk-input uk-form-width-medium uk-form-small" type="number" min="0" step="1" required >
									Amount
									<input name="amount" class="uk-input uk-form-width-medium uk-form-small" type="number" min="0" step="0.01" required >
									<button tpe="submit" class="uk-button uk-button-small uk-button-primary">Request</button>
								{!! Form::close() !!}
							</div>
						</div>
						<div class="uk-padding-small" uk-grid>
							<div class="uk-width-1-4">Estimate prices</div>
							<div class="uk-width-3-4">
								{!! Form::open(array('route' => 'admin.api.ding.recharge', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
								{!! csrf_field() !!}
									Operator id
									<input name="operator_id" class="uk-input uk-form-width-medium uk-form-small" type="number" min="0" step="1" required >
									Amount
									<input name="amount" class="uk-input uk-form-width-medium uk-form-small" type="number" min="0" step="0.01" required >
									<button tpe="submit" class="uk-button uk-button-small uk-button-primary">Request</button>
								{!! Form::close() !!}
							</div>
						</div>
						<div class="uk-padding-small" uk-grid>
							<div class="uk-width-1-4">List transfer records</div>
							<div class="uk-width-3-4">
								{!! Form::open(array('route' => 'admin.api.ding.recharge', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
								{!! csrf_field() !!}
									Operator id
									<input name="operator_id" class="uk-input uk-form-width-medium uk-form-small" type="number" min="0" step="1" required >
									Amount
									<input name="amount" class="uk-input uk-form-width-medium uk-form-small" type="number" min="0" step="0.01" required >
									<button tpe="submit" class="uk-button uk-button-small uk-button-primary">Request</button>
								{!! Form::close() !!}
							</div>
						</div>
						<div class="uk-padding-small" uk-grid>
							<div class="uk-width-1-4">Cancel transfers</div>
							<div class="uk-width-3-4">
								{!! Form::open(array('route' => 'admin.api.ding.recharge', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
								{!! csrf_field() !!}
									Operator id
									<input name="operator_id" class="uk-input uk-form-width-medium uk-form-small" type="number" min="0" step="1" required >
									Amount
									<input name="amount" class="uk-input uk-form-width-medium uk-form-small" type="number" min="0" step="0.01" required >
									<button tpe="submit" class="uk-button uk-button-small uk-button-primary">Request</button>
								{!! Form::close() !!}
							</div>
						</div>
						--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection