@extends('dashboard.base')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>{{ trans('titles.ding-requests') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
						<ul class="nav uk-text-default flex-column">
							<li class="nav-item">
								{{ trans('titles.err-code-descriptions') }}
								<a href="{{ url('/admin/api/ding/ErrorCodeDescriptions') }}">{{ trans('titles.read') }}</a>
							</li>
							<li class="nav-item">
								{{ trans('titles.currencies') }}
								<a href="{{ url('/admin/api/ding/Currencies') }}">{{ trans('titles.read') }}</a>
								|
								<a href="{{ url('/admin/api/ding/Currencies/save') }}">{{ trans('titles.save') }}</a>
							</li>
							<li class="nav-item">
								{{ trans('titles.regions') }}
								<a href="{{ url('/admin/api/ding/Regions') }}">{{ trans('titles.read') }}</a>
								|
								<a href="{{ url('/admin/api/ding/Regions/save') }}">{{ trans('titles.save') }}</a>
							</li>
							<li class="nav-item">
								{{ trans('titles.countries') }}
								<a href="{{ url('/admin/api/ding/Countries') }}">{{ trans('titles.read') }}</a>
								|
								<a href="{{ url('/admin/api/ding/Countries/save') }}">{{ trans('titles.read') }}</a>
							</li>
							<li class="nav-item">
								{{ trans('titles.providers') }}
								<a href="{{ url('/admin/api/ding/Providers') }}">{{ trans('titles.read') }}</a>
								|
								<a href="{{ url('/admin/api/ding/Providers/save') }}">{{ trans('titles.save') }}</a>
							</li>
							<li class="nav-item">
								{{ trans('titles.provider-status') }}
								<a href="{{ url('/admin/api/ding/ProviderStatus') }}">{{ trans('titles.read') }}</a>
							</li>
							<li class="nav-item">
								{{ trans('titles.products') }}
								<a href="{{ url('/admin/api/ding/Products') }}">{{ trans('titles.read') }}</a>
								|
								<a href="{{ url('/admin/api/ding/Products/save') }}">{{ trans('titles.save') }}</a>
							</li>
							<li class="nav-item">
								{{ trans('titles.products-descriptions') }}
								<a href="{{ url('/admin/api/ding/ProductDescriptions') }}">{{ trans('titles.read') }}</a>
								|
								<a href="{{ url('/admin/api/ding/ProductDescriptions/save') }}">{{ trans('titles.save') }}</a>
							</li>
							<li class="nav-item">
								{{ trans('titles.balance') }}
								<a href="{{ url('/admin/api/ding/Balance') }}">{{ trans('titles.read') }}</a>
							</li>
							<li class="nav-item">
								{{ trans('titles.promotions') }}
								<a href="{{ url('/admin/api/ding/Promotions') }}">{{ trans('titles.read') }}</a>
								|
								<a href="{{ url('/admin/api/ding/Promotions/save') }}">{{ trans('titles.save') }}</a>
							</li>
							<li class="nav-item">
								{{ trans('titles.promotions-descriptions') }}
								<a href="{{ url('/admin/api/ding/PromotionDescriptions') }}">{{ trans('titles.read') }}</a>
								|
								<a href="{{ url('/admin/api/ding/PromotionDescriptions/save') }}">{{ trans('titles.save') }}</a>
							</li>
						</ul>
						<div class="uk-padding-small" uk-grid>
							<div class="uk-width-1-4">{{ trans('titles.account-lookup') }}</div>
							<div class="uk-width-3-4">
								{!! Form::open(array('route' => 'admin.api.ding.account_lookup', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
								{!! csrf_field() !!}
									Phone number
									<input name="number" class="uk-input uk-form-width-medium uk-form-small" type="text" required >
									<button type="submit" class="uk-button uk-button-small uk-button-primary">{{ trans('titles.request') }}</button>
								{!! Form::close() !!}
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection
