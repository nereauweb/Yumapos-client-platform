@extends('dashboard.base')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>Ding test - {{ $request_description }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
						@if (!is_array($result)&&!is_object($result))
							{!! $result !!}
						@else
							@foreach ($result->getItems() as $product)
								<dl class="uk-description-list">
									<dt>sku_code</dt><dd>{!! $product->getProviderCode() !!}</dd>
									<dt>localization_key</dt><dd>{!! $product->getLocalizationKey() !!}</dd>
									<dt>setting_definitions</dt><dd>{!! implode('; ',$product->getSettingDefinitions()) !!}</dd>
									<dt>maximum</dt><dd>{!! $product->getMaximum() !!}</dd>
									<dt>minimum</dt><dd>{!! $product->getMinimum() !!}</dd>
									<dt>processing_mode</dt><dd>{!! $product->getProcessingMode() !!}</dd>
									<dt>redemption_mechanism</dt><dd>{!! is_array($product->getRedemptionMechanism()) ? implode('; ',$product->getRedemptionMechanism()) : $product->getRedemptionMechanism() !!}</dd>
									<dt>benefits</dt><dd>{!! implode('; ',$product->getBenefits()) !!}</dd>
									<dt>validity_period_iso</dt><dd>{!! $product->getValidityPeriodIso() !!}</dd>
									<dt>uat_number</dt><dd>{!! $product->getUatNumber() !!}</dd>
									<dt>additional_information</dt><dd>{!! $product->getAdditionalInformation() !!}</dd>
									<dt>default_display_text</dt><dd>{!! $product->getDefaultDisplayText() !!}</dd>
									<dt>region_code</dt><dd>{!! $product->getRegionCode() !!}</dd>
									<dt>payment_types</dt><dd>{!! implode('; ',$product->getPaymentTypes()) !!}</dd>
									<dt>lookup_bills_required</dt><dd>{!! $product->getLookupBillsRequired() !!}</dd>
								</dl>
								<br><hr><br>
							@endforeach
						@endif
						{{--
						<hr>
						<pre>{!! var_dump($result) !!}</pre>
						--}}
					</div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection'