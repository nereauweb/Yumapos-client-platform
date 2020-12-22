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
						{{ trans('titles.log') }}: {!! $log !!}<br><br>
						<ul class="nav flex-column">
						  <li class="nav-item">
							<a class="nav-link" href="{{ url('/admin/api/reloadly/balance') }}">{{ trans('titles.balance') }}</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" href="{{ url('/admin/api/reloadly/discounts') }}">{{ trans('titles.discounts') }}</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" href="{{ url('/admin/api/reloadly/countries') }}">{{ trans('titles.countries') }}</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" href="{{ url('/admin/api/reloadly/operators/list') }}">{{ trans('titles.operators') }}</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" href="{{ url('/admin/api/reloadly/operators') }}">{{ trans('titles.promotions') }}</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" href="{{ url('/admin/api/reloadly/transactions') }}">{{ trans('titles.transactions') }}</a>
						  </li>
						  {{--
						  <li class="nav-item">
							<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled link</a>
						  </li>
						  --}}
						</ul>
						<div class="uk-padding-small" uk-grid>
							<div class="uk-width-1-4">FX rates</div>
							<div class="uk-width-3-4">
								{!! Form::open(array('route' => 'admin.api.reloadly.fx_rates', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
								{!! csrf_field() !!}
									{{ trans('titles.operator-id') }}
									<input name="operator_id" class="uk-input uk-form-width-medium uk-form-small" type="number" min="0" step="1" required >
									{{ trans('titles.amount') }}
									<input name="amount" class="uk-input uk-form-width-medium uk-form-small" type="number" min="0" step="0.01" required >
									<button tpe="submit" class="uk-button uk-button-small uk-button-primary">{{ trans('titles.request') }}</button>
								{!! Form::close() !!}
							</div>
						</div>
						<div class="uk-padding-small" uk-grid>
							<div class="uk-width-1-4">{{ trans('titles.recharge') }}</div>
							<div class="uk-width-3-4">
								{!! Form::open(array('route' => 'admin.api.reloadly.recharge', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
								{!! csrf_field() !!}
									{{ trans('titles.operator-id') }}
									<input name="operator_id" class="uk-input uk-form-width-medium uk-form-small" type="number" min="0" step="1" required >
									{{ trans('titles.amount') }}
									<input name="amount" class="uk-input uk-form-width-medium uk-form-small" type="number" min="0" step="0.01" required >
									<button tpe="submit" class="uk-button uk-button-small uk-button-primary">{{ trans('titles.request') }}</button>
								{!! Form::close() !!}
							</div>
						</div>
						<hr>
						<ul class="nav flex-column">
						  <li class="nav-item">
							<a class="nav-link" href="{{ url('/admin/api/reloadly/operators/save') }}">{{ trans('titles.save-operators-data') }}</a>
						  </li>
						</ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection
