@extends('dashboard.base')

@section('style')
.amount-choice input {
	display:none;
}
.amount-choice .form-check {
	padding: .5rem 1rem !important;
	box-shadow: 0 0 3px #848484;
	margin: .3rem;
	background: #fff;
	color: #353535;
}
a.amount-choice * {
	cursor: pointer;
}
.amount-choice.selected .form-check {
	background: #23ec23;
	box-shadow: 0 0 5px #047100;
}
.operator-choice input {
	display:none;
}
.operator-choice .form-check {
	padding: .5rem 1rem !important;
	box-shadow: 0 0 3px #848484;
	margin: .3rem;
	background: #fff;
	color: #353535;
}
a.operator-choice * {
	cursor: pointer;
}
.operator-choice.selected .form-check {
	background: #23ec23;
	box-shadow: 0 0 5px #047100;
}
@endsection

@section('content')

	@include('partials.country-array')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>Selected operator</h3>
							{{ $category->name }}
                        </div>
                    </div>
                    <div class="card-body">
						@if(!Auth::user()->group_id||Auth::user()->group_id==0)

							{{ trans('descriptions.contact-admin-to-fix') }}

						@elseif(isset($data['message']))

							{{ $data['message'] }}

						@elseif($operator && is_object($operator))

							<h2 class="">
								@if ($operator->reloadly && $operator->reloadly->logoUrls)
									<img src="{{ $operator->reloadly->logoUrls->first()->url }}">
								@endif
								{{ $operator->name }}
							</h2>

							{!! Form::open(array('route' => 'users.services.transaction', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation form-horizontal')) !!}
								{!! csrf_field() !!}
								<input type="hidden" name="category_id" id="category_id" value="{{ $category->id }}">

								@if(isset($phone_number))
								<h3 class="">{{ $phone_number }}</h3>
								<input type="hidden" name="recipient_phone" id="recipient_phone" value="{{ $phone_number }}">
								@else
									<div class="uk-margin-bottom">
                                        <label class="uk-form-label uk-dark">{{trans('titles.p-n')}}. <small>({{ trans('titles.s-c-code') }})</small> <small style="color:white;">*{{ trans('titles.required') }}</small></label>
										<div class="uk-form-controls">
											<input name="number" id="number" class="uk-input form-control" type="tel" required>
											<input type="hidden" name="recipient_phone" id="recipient_phone" value="">
										</div>
									</div>
								@endif

								<div class="form-group row">
									<label class="col-md-3 col-form-label" for="text-input">{{ trans('titles.change-operator') }}</label>
									<div class="col-md-9">
										<div class="uk-child-width-auto uk-grid-collapse uk-flex uk-flex-wrap" uk-grid>
										@foreach($operators as $availableOperator)
										<a href="#" class="operator-choice"
												data-operator-id="{{ $availableOperator->id }}"
												data-category-id="{{ $category->id }}"
												data-phone-number="{{ $phone_number }}"
										>
											<div class="form-check">
												<input
													class="form-check-input operators"
													id="operator-{{$availableOperator->id}}"
													type="radio"
													value="{{$availableOperator->id}}" >
												<label class="form-check-label" operator="radio{{$availableOperator->id}}">{{ $availableOperator->name }}</label>
											</div>
										</a>
										@endforeach
										</div>
									</div>
								</div>

								@if($operator->provider() == 'reloadly')
									@if($operator->reloadly->denominationType=="FIXED")
										@php
											$configuration = $operator->reloadly->configurations->where('group_id', Auth::user()->group_id)->first();
										@endphp
										<div class="form-group row uk-margin-top">
											<div class="col-md-3 col-form-label">
												{{ trans('titles.choose-amount') }}
											</div>
											<div class="col-md-9 col-form-label uk-flex uk-flex-wrap">
											@foreach($operator->reloadly->fixedAmounts as $index => $element)
												@php
													$user_amount = round($element->amount,2);
													if ($configuration&&$configuration->amounts){
														$amount_configuration = $configuration->amounts->where('original_amount',$element->amount)->first();
														if($amount_configuration && $amount_configuration->visible==0){
															continue;
														}
													}
													if(isset($amount_configuration)&&$amount_configuration&&$amount_configuration->final_amount != 0){
														$user_amount = round($amount_configuration->final_amount,2);
													}
													$fxrate = $operator->reloadly->config_rate(Auth::user()->group_id);
												@endphp
												<a href="#" class="amount-choice">
													<div class="form-check">
														<input
															class="form-check-input amounts"
															id="radio{{$index}}"
															type="radio"
															value="{{$element->amount}}"
															name="amount"
															data-amount="{{ $user_amount }}"
															data-local="0"
															data-local-amount="{{ $element->amount * $fxrate}}"
															data-fxrate="{{ $fxrate }}"
															required >
														<label class="form-check-label" for="radio{{$index}}">{{ $user_amount }} ???</label>
													</div>
												</a>
											@endforeach
											@if($configuration&&$operator->reloadly->localFixedAmounts->count()>0&&$configuration->local_amounts)
												@foreach($operator->reloadly->localFixedAmounts as $index => $element)
													@php
														$amount_configuration = $configuration->local_amounts->where('original_amount',$element->amount)->first();
														if(!isset($amount_configuration) || !$amount_configuration || $amount_configuration->visible==0 || $amount_configuration->final_amount == 0){
															continue;
														}
														$user_amount = round($amount_configuration->final_amount,2);
													@endphp
												<a href="#" class="amount-choice">
													<div class="form-check">
														<input
															class="form-check-input amounts"
															id="radio{{$index}}"
															type="radio"
															value="{{$element->amount}}"
															name="amount"
															data-local="1"
															data-amount="{{ $user_amount }}"
															data-fxrate="{{ $operator->reloadly->config_rate(Auth::user()->group_id) }}"
															data-local-amount="{{ $element->amount }}"
															required >
														<label class="form-check-label" for="radio{{$index}}">{{ round($element->amount,2) }} {{ $operator->reloadly->destinationCurrencySymbol }}</label>
													</div>
												</a>
												@endforeach
											@endif
											</div>
										</div>
										<div class="form-group row @if(!Auth::user()->group->use_margin) d-none @endif">
											<label class="col-md-3 col-form-label" for="text-input">{{ trans('titles.gain') }} ???</label>
											<div class="col-md-9">
												<input class="form-control" id="gain" type="number" name="gain" value="" step="0.01" required>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 col-form-label" for="text-input">{{ trans('titles.final-c') }} ???</label>
											<div class="col-md-9">
												<input class="form-control" id="final_amount" type="text" name="final_amount" value="" step="0.01" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 col-form-label" for="text-input">{{ trans('expected-charge') }} {{ $operator->reloadly->destinationCurrencySymbol }}</label>
											<div class="col-md-9">
												<input class="form-control" id="final_amount_destination" type="text" name="final_amount_destination" value="" step="0.01" readonly>
											</div>
										</div>

										{!! Form::button(trans('titles.finalize'), array('id' => 'finalizer', 'class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => 'Confirm submit', 'data-message' => 'Please confirm operation to continue')) !!}

									@elseif($operator->reloadly->denominationType=="RANGE")

										<div class="form-group row">
											<label class="col-md-3 col-form-label" for="text-input">{{ trans('titles.amount') }}&nbsp;??? ({{number_format($operator->reloadly->minAmount(Auth::user()->group_id),2,'.','')}}/{{number_format($operator->reloadly->maxAmount(Auth::user()->group_id),2,'.','')}})</label>
											<div class="col-md-9">
												<input
													class="form-control"
													id="amount"
													type="number"
													name="amount"
													value=""
													step="0.01"
													@if ($operator->reloadly->minAmount)
														{!! 'min="'.number_format($operator->reloadly->minAmount(Auth::user()->group_id),2,'.','').'"' !!}
														{!! 'data-min="'.number_format($operator->reloadly->minAmount(Auth::user()->group_id),2,'.','').'"' !!}
													@endif
													@if ($operator->reloadly->maxAmount)
														{!! 'max="'.number_format($operator->reloadly->maxAmount(Auth::user()->group_id),2,'.','').'"' !!}
														{!! 'data-max="'.number_format($operator->reloadly->maxAmount(Auth::user()->group_id),2,'.','').'"' !!}
													@endif
													data-fxrate="{{ round($operator->reloadly->config_rate(Auth::user()->group_id),3) }}"
													data-local="0"
													required >
												<p class="uk-text-danger" id="amount-alert" style="display:none;">{{ trans('titles.wrong-amount') }}</p>
											</div>
										</div>
										<div class="form-group row @if(!Auth::user()->group->use_margin) d-none @endif">
											<label class="col-md-3 col-form-label" for="text-input">{{ trans('titles.gain') }} ???</label>
											<div class="col-md-9">
												<input class="form-control" id="gain" type="number" name="gain" value="" step="0.01" required>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 col-form-label" for="text-input">{{ trans('titles.final-c') }} ???</label>
											<div class="col-md-9">
												<input class="form-control" id="final_amount" type="text" name="final_amount" value="" step="0.01" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 col-form-label" for="text-input">{{ trans('titles.expected-charge') }} {{ $operator->reloadly->destinationCurrencySymbol }}</label>
											<div class="col-md-9">
												<input class="form-control" id="final_amount_destination" type="number" name="final_amount_destination" value="" step="0.01">
											</div>
										</div>

										{!! Form::button(trans('titles.finalize'), array('id' => 'finalizer', 'class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => 'Confirm submit', 'data-message' => 'Please confirm operation to continue')) !!}

									@else

										{{ trans('descriptions.error-msg-operator-data') }}

									@endif

									<input type="hidden" name="operator_id" value="{{ $operator->id }}">
									<input type="hidden" name="country_iso" value="{{ $operator->reloadly->country->isoName }}">
									<input type="hidden" name="local" id="local" value="0">

								@elseif($operator->provider() == 'ding' && $operator->ding->products()->count()>0)
									@if($operator->ding->products_type()=="FIXED")
										@php
											$configuration = $operator->ding->configurations->where('group_id', Auth::user()->group_id)->first();
										@endphp
										<div class="form-group row uk-margin-top">
											<div class="col-md-3 col-form-label">
												{{ trans('titles.choose-amount') }}
											</div>
											<div class="col-md-9 col-form-label uk-flex uk-flex-wrap">
											@foreach($operator->ding->ordered_products() as $index => $element)
												@php
													$user_amount = round($element->minimum->SendValue,2);
													if ($configuration&&$configuration->amounts){
														$amount_configuration = $configuration->amounts->where('original_amount',$element->minimum->SendValue)->first();
														if($amount_configuration && $amount_configuration->visible==0){
															continue;
														}
													}
													if(isset($amount_configuration)&&$amount_configuration&&$amount_configuration->final_amount != 0){
														$user_amount = round($amount_configuration->final_amount,2);
													}
													$fxrate = $element->config_rate(Auth::user()->group_id);
												@endphp
												<div>
													<a href="#" class="amount-choice">
														<div class="form-check">
															<input
																class="form-check-input amounts"
																id="radio{{$index}}"
																type="radio"
																value="{{$element->minimum->SendValue}}"
																name="amount"
																data-amount="{{ $user_amount }}"
																data-local="0"
																data-local-amount="{{ $element->minimum->ReceiveValue}}"
																data-fxrate="{{ $fxrate }}"
																data-sku-code="{{ $element->SkuCode }}"
																required >
															<label class="form-check-label uk-text-center" for="radio{{$index}}">
																<strong>
																{{ round($user_amount,2) }} {{ $element->minimum->SendCurrencyIso }}
																</strong>
																<hr class="uk-margin-remove">
																{{ round($element->minimum->ReceiveValue,2) }} {{ $element->minimum->ReceiveCurrencyIso }}
															</label>
														</div>
													</a>
												</div>
											@endforeach
											@if($configuration&&$operator->ding->products->count()>0&&$configuration->local_amounts)
												@foreach($operator->ding->products as $index => $element)
													@php
														$amount_configuration = $configuration->local_amounts->where('original_amount',$element->minimum->ReceiveValue)->first();
														if(!isset($amount_configuration) || !$amount_configuration || $amount_configuration->visible==0 || $amount_configuration->final_amount == 0){
															continue;
														}
														$fxrate = $element->config_rate(Auth::user()->group_id);
														$user_amount = round($amount_configuration->final_amount,2);
													@endphp
													<a href="#" class="amount-choice">
														<div class="form-check">
															<input
																class="form-check-input amounts"
																id="radio{{$index}}"
																type="radio"
																value="{{$element->minimum->SendValue}}"
																name="amount"
																data-local="1"
																data-amount="{{ $user_amount }}"
																data-fxrate="{{ $fxrate }}"
																data-local-amount="{{ $element->minimum->ReceiveValue }}"
																data-sku-code="{{ $element->SkuCode }}"
																required >
															<label class="form-check-label uk-text-center" for="radio{{$index}}">
																<strong>
																{{ round($user_amount,2) }} {{ $element->minimum->SendCurrencyIso }}
																</strong>
																<hr class="uk-margin-remove">
																{{ round($element->minimum->ReceiveValue,2) }} {{ $element->minimum->ReceiveCurrencyIso }}
															</label>
														</div>
													</a>
												@endforeach
											@endif
											</div>
										</div>
										<div class="form-group row @if(!Auth::user()->group->use_margin) d-none @endif">
											<label class="col-md-3 col-form-label" for="text-input">{{ trans('titles.gain') }} ???</label>
											<div class="col-md-9">
												<input class="form-control" id="gain" type="number" name="gain" value="" step="0.01" required>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 col-form-label" for="text-input">{{trans('titles.final-c')}} ???</label>
											<div class="col-md-9">
												<input class="form-control" id="final_amount" type="text" name="final_amount" value="" step="0.01" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 col-form-label" for="text-input">{{ trans('titles.expected-charge') }} {{ $operator->ding->products()->first()->minimum->ReceiveCurrencyIso }}</label>
											<div class="col-md-9">
												<input class="form-control" id="final_amount_destination" type="text" name="final_amount_destination" value="" step="0.01" readonly>
											</div>
										</div>

										{!! Form::button(trans('titles.finalize'), array('id' => 'finalizer', 'class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => 'Confirm submit', 'data-message' => 'Please confirm operation to continue')) !!}

									@elseif($operator->ding->products_type()=="RANGE")

										<input type="hidden" name="product_sku" value="{{ $operator->ding->products()->first()->SkuCode }}">
										<div class="form-group row">
											<label class="col-md-3 col-form-label" for="text-input">{{ trans('titles.amount') }}&nbsp;??? ({{number_format($operator->ding->products()->first()->minAmount(Auth::user()->group_id),2)}}/{{number_format($operator->ding->products()->first()->maxAmount(Auth::user()->group_id),2,'.','')}})</label>
											<div class="col-md-9">
												<input
													class="form-control"
													id="amount"
													type="number"
													name="amount"
													value=""
													step="0.01"
													@if ( $operator->ding->products()->first() )
														{!! 'min="'.number_format($operator->ding->products()->first()->minAmount(Auth::user()->group_id),2,'.','').'"' !!}
														{!! 'data-min="'.number_format($operator->ding->products()->first()->minAmount(Auth::user()->group_id),2,'.','').'"' !!}
														{!! 'max="'.number_format($operator->ding->products()->first()->maxAmount(Auth::user()->group_id),2,'.','').'"' !!}
														{!! 'data-max="'.number_format($operator->ding->products()->first()->maxAmount(Auth::user()->group_id),2,'.','').'"' !!}
													@endif
													data-fxrate="{{ round($operator->ding->products()->first()->config_rate(Auth::user()->group_id),3) }}"
													data-local="0"
													required >
												<p class="uk-text-danger" id="amount-alert" style="display:none;">{{ trans('titles.wrong-amount') }}</p>
											</div>
										</div>
										<div class="form-group row @if(!Auth::user()->group->use_margin) d-none @endif">
											<label class="col-md-3 col-form-label" for="text-input">{{ trans('titles.gain') }} ???</label>
											<div class="col-md-9">
												<input class="form-control" id="gain" type="number" name="gain" value="" step="0.01" required>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 col-form-label" for="text-input">{{ trans('titles.final-c') }} ???</label>
											<div class="col-md-9">
												<input class="form-control" id="final_amount" type="text" name="final_amount" value="" step="0.01" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 col-form-label" for="text-input">{{ trans('titles.expected-charge') }} {{ $operator->ding->products()->first()->minimum->SendCurrencyIso }}</label>
											<div class="col-md-9">
												<input class="form-control" id="final_amount_destination" type="number" name="final_amount_destination" value="" step="0.01">
											</div>
										</div>

										{!! Form::button(trans('titles.finalize'), array('id' => 'finalizer', 'class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => 'Confirm submit', 'data-message' => 'Please confirm operation to continue')) !!}

									@else

										{{ trans('descriptions.error-msg-operator-data') }}

									@endif

									<input type="hidden" name="product_sku" value="{{ $operator->ding->products()->first()->SkuCode }}" id="product-sku">
									<input type="hidden" name="operator_id" value="{{ $operator->id }}">
									<input type="hidden" name="country_iso" value="{{ $operator->ding->country->CountryIso }}">
									<input type="hidden" name="local" id="local" value="0">

								@endif

							{!! Form::close() !!}

						@else

							{{ trans('descriptions.general-error') }}

						@endif
                    </div>

					{{--
                    <div class="card-body">
						Log: {!! $log !!}
						<pre>{!! var_dump($data) !!}</pre>
						<pre>{!! var_dump($operator) !!}</pre>
                    </div>
					--}}

                </div>
            </div>
        </div>
    </div>

	@include('modals.modal-save')

@endsection

@section('javascript')
	@if($operator && is_object($operator))
		@include('scripts.save-modal-script')
		<script>
			var gain_percent = {{ Auth::user()->configuration ? (Auth::user()->group->use_margin ? Auth::user()->configuration->default_gain : 0) : 0 }};
			var amount = 0.00;
			var gain = 0.00;
			var final_amount = 0.00;
			var fxRate = 0.00;
			var final_amount_destination = 0.00;
			var local = 0;
			@if($operator->type()=="FIXED")
			/*
				$(".amounts").click(function(){
					local = $(this).data("local");
					if (local==1){
						final_amount_destination = parseFloat($(this).val());
					}
					$("#local").val(local);
					amount = parseFloat($(this).data("amount"));
					fxRate = parseFloat($(this).data("fxrate"));
					gain = (gain_percent/100) * amount;
					gain = gain;
					$("#gain").val(gain.toFixed(2));
					final_amount = amount + gain;
					final_amount_destination = parseFloat($(this).data("local-amount"));
					$("#final_amount").val(final_amount.toFixed(2));
					$("#final_amount_destination").val(final_amount_destination.toFixed(2));
					@if ($operator->provider() == "ding"){
						var productSku = $(this).data('sku-code');
						$("#product-sku").val(productSku);
					}
					@endif
				});
			*/
				$(".amount-choice").click(function(e){
					e.preventDefault();
					$(".amount-choice").removeClass('selected');
					$(this).addClass('selected');
					input = $(this).find("input").first();
					input.prop('checked',true);
					local = input.data("local");
					if (local==1){
						final_amount_destination = parseFloat(input.val());
					}
					$("#local").val(local);
					amount = parseFloat(input.data("amount"));
					fxRate = parseFloat(input.data("fxrate"));
					gain = (gain_percent/100) * amount;
					gain = gain;
					$("#gain").val(gain.toFixed(2));
					final_amount = amount + gain;
					final_amount_destination = parseFloat(input.data("local-amount"));
					$("#final_amount").val(final_amount.toFixed(2));
					$("#final_amount_destination").val(final_amount_destination.toFixed(2));
					@if ($operator->provider() == "ding"){
						var productSku = input.data('sku-code');
						$("#product-sku").val(productSku);
					}
					@endif
				});

				$("#gain").change(function(){
					if( !$("#gain").val() ) {
						$("#gain").val() = 0;
						gain = 0;
					} else {
						gain = parseFloat($("#gain").val());
					}
					final_amount = amount + gain;
					$("#final_amount").val(final_amount.toFixed(2))
				});
			@else
				$("#amount").change(function(){
					amount = parseFloat($(this).val());
					min = parseFloat($(this).data('min')) ?? 0;
					max = parseFloat($(this).data('max')) ?? 10000000;
					if (min <= amount && max >= amount){
						$("#finalizer").prop('disabled',false);
						$("#amount-alert").hide();
					} else {
						$("#finalizer").prop('disabled',true);
						$("#amount-alert").show();
					}
					gain = (gain_percent/100) * amount;
					$("#gain").val(gain.toFixed(2));
					fxRate = parseFloat($(this).data("fxrate"));
					calc_final();
				});
				$("#gain").change(function(){
					if(amount>0){
						calc_final();
					}
				});
				function calc_final () {
					if( !$("#gain").val() ) {
						$("#gain").val() = 0;
						gain = 0;
					}
					gain = parseFloat($("#gain").val());
					final_amount = amount + gain;
					if (local == 0){
						final_amount_destination = amount * fxRate ;
					}
					$("#final_amount").val(final_amount.toFixed(2));
					$("#final_amount_destination").val(final_amount_destination.toFixed(2));
				}

				$("#final_amount_destination").change(function(){
					fxRate = parseFloat($("#amount").data("fxrate"));
					final_amount_destination = parseFloat($(this).val());
					amount = final_amount_destination / fxRate;
					$("#amount").val(amount.toFixed(2))
					gain = (gain_percent/100) * amount;
					$("#gain").val(gain.toFixed(2));
					final_amount = amount + gain;
					$("#final_amount").val(final_amount.toFixed(2));
				});
			@endif
		</script>
		@if(!isset($phone_number))
			<script>
				$("#number").change(function(){
					if ($("#number").val()=='') {
						$("#recipient_phone").val('');
					} else {
						var fullNumber = "+{{$countryArray[$operator->country->iso]['code']}}" + $("#number").val();
						$("#recipient_phone").val(fullNumber);
					}
					//console.log($("#recipient_phone").val());
				});
			</script>
		@endif
		<script>
			$(".operator-choice").click(function(e){
				e.preventDefault();
				/*
				$(".operator-choice").removeClass('selected');
				$(this).addClass('selected');
				input = $(this).find("input").first();
				input.prop('checked',true);
				*/
				$(this).addClass('selected');
				var operatorId = $(this).data('operator-id');
				var categoryId = $(this).data('category-id');
				var phoneNumber = $(this).data('phone-number');
				window.location.href = "/users/services/preview/operator/"+categoryId+"/"+operatorId+"/"+phoneNumber+"";
			});
		</script>
	@endif
@endsection
