@extends('dashboard.base')

@section('css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
				<div class="uk-modal-dialog uk-modal-body" id="content">
					<button class="uk-modal-close-default" type="button" uk-close></button>
					<h2 class="uk-text-secondary">{{ $operation->id }} | Details</h2>
					<dl class="row light">
					
						<dt class="col-sm-5">Provider</dt>
						<dd class="col-sm-7">{{ $operation->provider }}</dd>
					
						<dt class="col-sm-5">Service operation ID</dt>
						<dd class="col-sm-7">{{ $operation->id }}</dd>
					
						<dt class="col-sm-5">Provider operation ID</dt>
						<dd class="col-sm-7">{{ $operation->provider == 'reloadly' ? $operation->reloadly_operation->transactionId : $operation->ding_operation->TransferRef }}</dd>
					
						<dt class="col-sm-5">System call ID</dt>
						<dd class="col-sm-7">{{ $operation->provider == 'reloadly' ? $operation->api_reloadly_calls_id : $operation->api_ding_call_id }}</dd>						
						
					</dl>
					
					{{--					
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
							<div class="uk-grid uk-grid-collapse uk-child-width-1-2@m uk-margin-remove-top uk-margin-left uk-margin-right" uk-grid>
								<div>
									<h5>Call</h5>
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
							</div>		
						</div>
					--}}
					
				</div>	
			</div>
		</div>
	</div>

@endsection

@section('javascript')
@endsection