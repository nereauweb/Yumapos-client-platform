@extends('dashboard.base')

@section('css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
				<div class="uk-modal-dialog uk-modal-body" id="content">
					<button class="uk-modal-close-default" type="button" uk-close></button>
					<h2>{{ $operator->name }} | Details</h2>
					<dl class="row light">
					
						<dt class="col-sm-5">Operator ID</dt>
						<dd class="col-sm-7">{{ $operator->operatorId }}</dd>
					
						<dt class="col-sm-5">Type</dt>
						<dd class="col-sm-7">{{ $operator->denominationType }}</dd>
					
						<dt class="col-sm-5">Country</dt>
						<dd class="col-sm-7">{{ $operator->country->name }} {{ $operator->country->isoName }}</dd>
					
						<dt class="col-sm-5">Fx rate</dt>
						<dd class="col-sm-7">{{ $operator->fx->rate }} {{ $operator->fx->currencyCode }}</dd>
					
						<dt class="col-sm-5">Bundle</dt>
						<dd class="col-sm-7">{!! $operator->bundle == 1 ? '<i class="cil-check-alt"></i>' : '<i class="cil-x"></i>' !!}</dd>
					
						<dt class="col-sm-5">Data</dt>
						<dd class="col-sm-7">{!! $operator->data == 1 ? '<i class="cil-check-alt"></i>' : '<i class="cil-x"></i>' !!}</dd>
					
						<dt class="col-sm-5">PIN</dt>
						<dd class="col-sm-7">{!! $operator->pin == 1 ? '<i class="cil-check-alt"></i>' : '<i class="cil-x"></i>' !!}</dd>
					
						<dt class="col-sm-5">Supports locals amounts</dt>
						<dd class="col-sm-7">{!! $operator->	supportsLocalAmounts == 1 ? '<i class="cil-check-alt"></i>' : '<i class="cil-x"></i>' !!}</dd>
					
						<dt class="col-sm-5">Sender currency</dt>
						<dd class="col-sm-7">{{ $operator->senderCurrencyCode }} {{ $operator->senderCurrencySymbol }}</dd>
					
						<dt class="col-sm-5">Destination currency</dt>
						<dd class="col-sm-7">{{ $operator->destinationCurrencyCode }} {{ $operator->destinationCurrencySymbol }}</dd>
					
						<dt class="col-sm-5">Commission</dt>
						<dd class="col-sm-7">{{ $operator->commission }}</dd>
					
						<dt class="col-sm-5">International discount</dt>
						<dd class="col-sm-7">{{ $operator->internationalDiscount }}</dd>
					
						<dt class="col-sm-5">Local discount</dt>
						<dd class="col-sm-7">{{ $operator->localDiscount }}</dd>
					
						<dt class="col-sm-5">Most popular amount</dt>
						<dd class="col-sm-7">{{ $operator->mostPopularAmount }}</dd>
					
						<dt class="col-sm-5">Minimum amount</dt>
						<dd class="col-sm-7">{{ $operator->minAmount }}</dd>
					
						<dt class="col-sm-5">Maximum amount</dt>
						<dd class="col-sm-7">{{ $operator->maxAmount }}</dd>
					
						<dt class="col-sm-5">Local minimum amount</dt>
						<dd class="col-sm-7">{{ $operator->localMinAmount }}</dd>
					
						<dt class="col-sm-5">Local maximum amount</dt>
						<dd class="col-sm-7">{{ $operator->localMaxAmount }}</dd>
					
						@if($operator->logoUrls->count()>0)
						<dt class="col-sm-5">Logos</dt>
						<dd class="col-sm-7">
							<div class="uk-child-width-1-2" uk-grid>
								@foreach($operator->logoUrls as $element)
									<div><img src="{{$element->url}}"></div>
								@endforeach
							</div>
						</dd>
						@endif
						
						@if($operator->fixedAmounts&&$operator->fixedAmounts->count()>0)
						<dt class="col-sm-5">Fixed amounts</dt>
						<dd class="col-sm-7">
							<ul class="uk-list">
							@foreach($operator->fixedAmounts as $element)
								<li>{{$element->amount}}</li>
							@endforeach
							</ul>
						</dd>
						@endif
					
						@if($operator->fixedAmountsDescriptions&&$operator->fixedAmountsDescriptions->count()>0)
						<dt class="col-sm-5">Fixed amounts descriptions</dt>
						<dd class="col-sm-7">
							<ul class="uk-list">
							@foreach($operator->localFixedAmountsDescriptions as $element)
								<li>{{$element->amount}} => {{$element->description}}</li>
							@endforeach
							</ul>
						</dd>
						@endif	
						
						@if($operator->localFixedAmounts&&$operator->localFixedAmounts->count()>0)
						<dt class="col-sm-5">Local fixed amounts</dt>
						<dd class="col-sm-7">
							<ul class="uk-list">
							@foreach($operator->localFixedAmounts as $element)
								<li>{{$element->amount}}</li>
							@endforeach
							</ul>
						</dd>
						@endif
					
						@if($operator->localFixedAmountsDescriptions&&$operator->localFixedAmountsDescriptions->count()>0)
						<dt class="col-sm-5">Local fixed amounts descriptions</dt>
						<dd class="col-sm-7">
							<ul class="uk-list">
							@foreach($operator->localFixedAmountsDescriptions as $element)
								<li>{{$element->amount}} => {{$element->description}}</li>
							@endforeach
							</ul>
						</dd>
						@endif
						
						@if($operator->suggestedAmounts&&$operator->suggestedAmounts->count()>0)
						<dt class="col-sm-5">Suggested amounts</dt>
						<dd class="col-sm-7">
							<ul class="uk-list">
							@foreach($operator->suggestedAmounts as $element)
								<li>{{$element->amount}}</li>
							@endforeach
							</ul>
						</dd>
						@endif
					
						@if($operator->suggestedAmountsMap&&$operator->suggestedAmountsMap->count()>0)
						<dt class="col-sm-5">Suggested amounts descriptions</dt>
						<dd class="col-sm-7">
							<ul class="uk-list">
							@foreach($operator->suggestedAmountsMap as $element)
								<li>{{$element->amount_sender}} => {{$element->amount_recipient}}</li>
							@endforeach
							</ul>
						</dd>
						@endif
						
					</dl>
				</div>	
			</div>
		</div>
	</div>

@endsection

@section('javascript')
@endsection