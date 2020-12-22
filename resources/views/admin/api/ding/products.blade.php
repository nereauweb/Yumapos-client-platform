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
							@foreach ($result->getItems() as $product)
								<dl class="uk-description-list">
									<dt>{{ trans('titles.sku-code') }}</dt><dd>{!! $product->getProviderCode() !!}</dd>
									<dt>{{ trans('titles.localization-key') }}</dt><dd>{!! $product->getLocalizationKey() !!}</dd>
									<dt>{{ trans('titles.setting-definitions') }}</dt><dd>{!! implode('; ',$product->getSettingDefinitions()) !!}</dd>
									<dt>{{ trans('titles.maximum') }}</dt><dd>{!! $product->getMaximum() !!}</dd>
									<dt>{{ trans('titles.minimum') }}</dt><dd>{!! $product->getMinimum() !!}</dd>
									<dt>{{ trans('titles.processing-mode') }}</dt><dd>{!! $product->getProcessingMode() !!}</dd>
									<dt>{{ trans('titles.redemption-mechanism') }}</dt><dd>{!! is_array($product->getRedemptionMechanism()) ? implode('; ',$product->getRedemptionMechanism()) : $product->getRedemptionMechanism() !!}</dd>
									<dt>{{ trans('titles.benefits') }}</dt><dd>{!! implode('; ',$product->getBenefits()) !!}</dd>
									<dt>{{ trans('titles.validity_period_iso') }}</dt><dd>{!! $product->getValidityPeriodIso() !!}</dd>
									<dt>{{ trans('titles.uat_number') }}</dt><dd>{!! $product->getUatNumber() !!}</dd>
									<dt>{{ trans('titles.additional_information') }}</dt><dd>{!! $product->getAdditionalInformation() !!}</dd>
									<dt>{{ trans('titles.default_display_text') }}</dt><dd>{!! $product->getDefaultDisplayText() !!}</dd>
									<dt>{{ trans('titles.region_code') }}</dt><dd>{!! $product->getRegionCode() !!}</dd>
									<dt>{{ trans('titles.payment_types') }}</dt><dd>{!! implode('; ',$product->getPaymentTypes()) !!}</dd>
									<dt>{{ trans('titles.lookup_bills_required') }}</dt><dd>{!! $product->getLookupBillsRequired() !!}</dd>
								</dl>
								<br><hr><br>
							@endforeach
						@endif
					</div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection'
