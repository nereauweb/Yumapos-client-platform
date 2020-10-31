@extends('dashboard.base')

@section('css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
				<div class="uk-modal-dialog uk-modal-body" id="content">
					<button class="uk-modal-close-default" type="button" uk-close></button>
					<h2>{{ $product->SkuCode }} | Details</h2>
					<dl class="row light">
					
						<dt class="col-sm-5">ProductSKU</dt>
						<dd class="col-sm-7">{{ $product->SkuCode }}</dd>
						
						<dt class="col-sm-5">Operator</dt>
						<dd class="col-sm-7">{{ $product->operator->Name }}</dd>
					
						<dt class="col-sm-5">Type</dt>
						<dd class="col-sm-7">{{ $product->type() }}</dd>		
						
						<dt class="col-sm-5">FX rate</dt>
						<dd class="col-sm-7">{{ $product->fx_rate() }}</dd>	
						
						@if($product->minimum)
						<dt class="col-sm-5">Minimum</dt>
						<dd class="col-sm-7">
							<ul class="uk-list">
								<li><strong>Customer Fee</strong>{{$product->minimum->CustomerFee}}</li>
								<li><strong>Distributor Fee</strong>{{$product->minimum->DistributorFee}}</li>
								<li><strong>Receive Value</strong>{{$product->minimum->ReceiveValue}}</li>
								<li><strong>Receive Currency Iso</strong>{{$product->minimum->ReceiveCurrencyIso}}</li>
								<li><strong>Receive Value Excluding Tax</strong>{{$product->minimum->ReceiveValueExcludingTax}}</li>
								<li><strong>Tax Rate</strong>{{$product->minimum->TaxRate}}</li>
								<li><strong>Tax Name</strong>{{$product->minimum->TaxName}}</li>
								<li><strong>Tax Calculation</strong>{{$product->minimum->TaxCalculation}}</li>
								<li><strong>Send Value</strong>{{$product->minimum->SendValue}}</li>
								<li><strong>Send CurrencyIso</strong>{{$product->minimum->SendCurrencyIso}}</li>
							</ul>
						</dd>
						@endif
						
						@if($product->maximum)
						<dt class="col-sm-5">Maximum</dt>
						<dd class="col-sm-7">
							<ul class="uk-list">
								<li><strong>Customer Fee</strong>{{$product->maximum->CustomerFee}}</li>
								<li><strong>Distributor Fee</strong>{{$product->maximum->DistributorFee}}</li>
								<li><strong>Receive Value</strong>{{$product->maximum->ReceiveValue}}</li>
								<li><strong>Receive Currency Iso</strong>{{$product->maximum->ReceiveCurrencyIso}}</li>
								<li><strong>Receive Value Excluding Tax</strong>{{$product->maximum->ReceiveValueExcludingTax}}</li>
								<li><strong>Tax Rate</strong>{{$product->maximum->TaxRate}}</li>
								<li><strong>Tax Name</strong>{{$product->maximum->TaxName}}</li>
								<li><strong>Tax Calculation</strong>{{$product->maximum->TaxCalculation}}</li>
								<li><strong>Send Value</strong>{{$product->maximum->SendValue}}</li>
								<li><strong>Send CurrencyIso</strong>{{$product->maximum->SendCurrencyIso}}</li>
							</ul>
						</dd>
						@endif
						
						{{--
						@if($product->maximum&&$product->maximum->count()>0)
						<dt class="col-sm-5">Maximum</dt>
						<dd class="col-sm-7">
							<ul class="uk-list">
							@foreach($product->maximum as $element)
								<li>{{$element->sendAmount}}</li>
							@endforeach
							</ul>
						</dd>
						@endif
						--}}
						
					</dl>
				</div>	
			</div>
		</div>
	</div>

@endsection

@section('javascript')
@endsection