@extends('dashboard.base')

@section('css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
				<div class="uk-modal-dialog uk-modal-body" id="content">
					<button class="uk-modal-close-default" type="button" uk-close></button>
					<h2 class="uk-text-secondary">{{ $operator->Name }} | Details</h2>
					<dl class="row light">
					
						<dt class="col-sm-5">Code</dt>
						<dd class="col-sm-7">{{ $operator->ProviderCode }}</dd>
					
						<dt class="col-sm-5">Country</dt>
						<dd class="col-sm-7">{{ $operator->country->CountryName }}</dd>
					
						<dt class="col-sm-5">Customer care number</dt>
						<dd class="col-sm-7">{{ $operator->CustomerCareNumber }}</dd>
						
						@if($operator->products)							
							@foreach($operator->products as $product)						
								<div class="uk-margin-top uk-width-1-1 uk-background-muted uk-dark uk-padding-small">
									<div class="uk-grid uk-grid-collapse uk-child-width-1-3@m uk-margin-small-bottom" uk-grid>
										<div>
											<dt class="col-sm-5">ProductSKU</dt>
											<dd class="col-sm-7">{{ $product->SkuCode }}</dd>
										</div>
										<div>
											<dt class="col-sm-5">Type</dt>
											<dd class="col-sm-7">{{ $product->type() }}</dd>
										</div>
										<div>									
											<dt class="col-sm-5">FX&nbsp;rate</dt>
											<dd class="col-sm-7">{{ $product->fx_rate() }}</dd>
										</div>
									</div>		
									@if ($product->type()!='FIXED')
										<div class="uk-grid uk-grid-collapse uk-child-width-1-2@m uk-margin-remove-top uk-margin-left uk-margin-right" uk-grid>
									@endif									
										@if($product->minimum)
											<div>
												@if ($product->type()!='FIXED') 
													<h5>Minimum</h5>
												@endif
												<ul class="uk-list uk-list-collapse uk-text-small 
												@if ($product->type()=='FIXED') uk-column-1-2@m uk-margin-left @endif ">
													<li><strong>Customer Fee</strong> {{$product->minimum->CustomerFee}}</li>
													<li><strong>Distributor Fee</strong> {{$product->minimum->DistributorFee}}</li>
													<li><strong>Receive Value</strong> {{$product->minimum->ReceiveValue}}</li>
													<li><strong>Receive Currency Iso</strong> {{$product->minimum->ReceiveCurrencyIso}}</li>
													<li><strong>Receive Value Excluding Tax</strong> {{$product->minimum->ReceiveValueExcludingTax}}</li>
													<li><strong>Tax Rate</strong> {{$product->minimum->TaxRate}}</li>
													<li><strong>Tax Name</strong> {{$product->minimum->TaxName}}</li>
													<li><strong>Tax Calculation</strong> {{$product->minimum->TaxCalculation}}</li>
													<li><strong>Send Value</strong> {{$product->minimum->SendValue}}</li>
													<li><strong>Send CurrencyIso</strong> {{$product->minimum->SendCurrencyIso}}</li>
												</ul>
											</div>
										@endif										
										@if($product->maximum && $product->type()!='FIXED')
											<div>
												<h5>Maximum</h5>
												<ul class="uk-list uk-list-collapse uk-text-small">
													<li><strong>Customer Fee</strong> {{$product->maximum->CustomerFee}}</li>
													<li><strong>Distributor Fee</strong> {{$product->maximum->DistributorFee}}</li>
													<li><strong>Receive Value</strong> {{$product->maximum->ReceiveValue}}</li>
													<li><strong>Receive Currency Iso</strong> {{$product->maximum->ReceiveCurrencyIso}}</li>
													<li><strong>Receive Value Excluding Tax</strong> {{$product->maximum->ReceiveValueExcludingTax}}</li>
													<li><strong>Tax Rate</strong> {{$product->maximum->TaxRate}}</li>
													<li><strong>Tax Name</strong> {{$product->maximum->TaxName}}</li>
													<li><strong>Tax Calculation</strong> {{$product->maximum->TaxCalculation}}</li>
													<li><strong>Send Value</strong> {{$product->maximum->SendValue}}</li>
													<li><strong>Send CurrencyIso</strong> {{$product->maximum->SendCurrencyIso}}</li>
												</ul>
											</div>
										@endif
									@if ($product->type()!='FIXED')								
										</div>			
									@endif
								</div>								
							@endforeach							
						@endif
						
					</dl>
				</div>	
			</div>
		</div>
	</div>

@endsection

@section('javascript')
@endsection