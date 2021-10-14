@extends('dashboard.base')

@section('style')
	.choose-product-grid {
		color: #f4f4f4;
		border-radius: 3px;
		box-shadow: 0 0 3px black;
		text-decoration: none ;
	}
	.topup-background{
		background: #23c123;		
	}
	.pin-background{
		background: #23c195;
	}	
	a.choose-product:hover {
		color: #FFF;
		text-decoration: none ;
	}
	#chosen-operator,#chosen-product,#chosen-number {
		float: right;
		color: green;
	}
	.uk-accordion-title::before{
		width:0px;
	}
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>Ricariche nazionali</h3>
							<div><a href="{{url('/users/services/mbs/list')}}">Listino</a></div>
                        </div>
                    </div>
                    <div class="card-body">						
						<div class="uk-padding-small">
							<ul class="uk-margin-large-bottom" uk-accordion id="stepper">
								<li class="uk-open">
									<a class="uk-accordion-title" href="#" id="step-operator">Selezione operatore <span id="chosen-operator"></span></a>
									<div class="uk-accordion-content uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l uk-child-width-1-5@xl uk-padding" uk-grid uk-height-match=".choose-operator-content">
										@php
											$last_operator = '';
										@endphp
										@foreach($products as $product)
											@if(in_array($product->Operatore,$providers_ricarica)&&($product->Tipo=="Ricarica OnLine"||$product->Tipo=="Ricarica PIN")&&$product->Operatore!=$last_operator)
												<div>
													<a class="choose-operator" data-operator="{{str_replace(' ', '_', $product->Operatore)}}" data-operator-full="{{$product->Operatore}}" href="#">
														<div class="uk-padding uk-background-muted  uk-flex uk-flex-middle uk-flex-center choose-operator-content" >
															<img src="/img/mbs/{{ $product->image }}">
														</div>
													</a>
												</div>
												@php
													$last_operator = $product->Operatore;
												@endphp
											@endif
										@endforeach
									</div>
								</li>
								<li>
									<a class="uk-accordion-title uk-link-muted" href="#" id="step-product">Selezione prodotto <span id="chosen-product"></span></a>
									<div class="uk-accordion-content">										
										@php
											$first = true;
											$last_operator = '';
											$last_type = 'Ricarica OnLine';
										@endphp
										@foreach($products as $product)
											@if ($last_operator!=$product->Operatore)
												@if(!$first) 
													</div> 
												@endif
												<div class="products uk-margin-remove-top uk-padding" id="products-{{str_replace(' ', '_', $product->Operatore)}}" uk-grid uk-height-match=".choose-product-grid">
											@endif
											@if ($last_type!=$product->Tipo&&$product->Tipo=="Ricarica PIN")
												<div class="uk-width-1-1"></div>
											@endif
											@if(in_array($product->Operatore,$providers_ricarica)&&($product->Tipo=="Ricarica OnLine"||$product->Tipo=="Ricarica PIN")&&strpos($product->Descrizione,'Vodafone Servizi')==false)
												<div class="uk-child-1-2 uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l uk-width-1-6@xl">
													<a href="#" class="choose-product" data-product-type="{{$product->Tipo}}"data-product="{{$product->Prodotto}}" data-product-full="{{$product->Tipo}} {{number_format($product->PrezzoUtente,2)}}&nbsp;€">
														<div class="uk-padding-small uk-text-justify uk-grid-collapse choose-product-grid {{ $product->Tipo=='Ricarica OnLine' ? 'topup-background' : 'pin-background' }}" uk-grid>	
															<div class="uk-width-3-5 uk-flex uk-flex-middle">
																{{$product->Tipo}}
															</div> 
															<div class="uk-width-2-5 uk-text-right uk-flex uk-flex-middle">
																{{number_format($product->PrezzoUtente,2)}}&nbsp;€
															</div>
														</div>
													</a>
												</div>
											@endif		
											@php
												$last_type = $product->Tipo;
												$last_operator = $product->Operatore;
												$first = false;
											@endphp
										@endforeach
										</div>
									</div>
								</li>
								<li>
									<a class="uk-accordion-title uk-link-muted" href="#" id="step-number">Inserisci numero <span id="chosen-number"></a>
									<div class="uk-accordion-content">
										<div class="uk-form-controls" uk-grid>
											<div class="uk-width-3-4">
												<input id="input-number" name="Numero" class="uk-input" id="form-horizontal-text" type="text" placeholder="Numero" disabled>
											</div>
											<div class="uk-width-1-4">
												<button class="uk-button uk-button-primary" id="confirm-number" disabled>Conferma</button>
											</div>
										</div>
									</div>
								</li>
							</ul>
							{!! Form::open(array('route' => 'users.services.mbs.ricarica_telefonica', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation', 'id'=>'form-ricarica', 'style'=>'display:none;')) !!}
								<input type="hidden" id="product" name="Prodotto" value="">
								<input type="hidden" id="number" name="Numero" value="">
								<div class="uk-text-right">
									{!! Form::button(trans('titles.finalize'), array('id' => 'finalizer', 'class' => 'btn btn-success btn-block btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('titles.request'), 'data-message' => 'Please confirm operation to continue')) !!}
								</div>
							{!! Form::close() !!}
							{!! Form::open(array('route' => 'users.services.mbs.ricarica_pin', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation', 'id'=>'form-pin', 'style'=>'display:none;')) !!}
								<input type="hidden" id="pin-product" name="Prodotto" value="">
								<div class="uk-text-right">
									{!! Form::button(trans('titles.finalize'), array('id' => 'finalizer', 'class' => 'btn btn-success btn-block btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('titles.request'), 'data-message' => 'Please confirm operation to continue')) !!}
								</div>
							{!! Form::close() !!}
						</div>					
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	@include('modals.modal-save')

@endsection

@section('javascript')

	@include('scripts.save-modal-script')

	<script>
		var isOperatorDefined = false;
		var isProductDefined = false;
		$(".choose-operator").click(function(e){
			e.preventDefault();
			var operator = $(this).data('operator');
			var operatorFull = $(this).data('operator-full');
			console.log(operator);
			$(".products").hide();
			$("#products-"+operator).show();
			$("#chosen-operator").html(operatorFull);
			$("#chosen-product").html("");
			UIkit.accordion("#stepper").toggle(0);
			$("#step-product").removeClass("uk-link-muted");
			UIkit.accordion("#stepper").toggle(1);
			isOperatorDefined = true;
		});
		$("#step-product").click(function(e){
			if (!isOperatorDefined){
				e.preventDefault();
				return false;
			}
		});
		$(".choose-product").click(function(e){
			e.preventDefault();
			if (isOperatorDefined){
				var productType = $(this).data('product-type');
				var product = $(this).data('product');
				var productFull = $(this).data('product-full');
				$("#chosen-product").html(productFull);
				if (productType=="Ricarica PIN"){
					UIkit.accordion("#stepper").toggle(1);
					$("#chosen-number").html("Non richiesto");
					$("#input-number,#confirm-number").prop('disabled',true);
					$("#form-ricarica").hide();
					$("#pin-product").val(product);
					$("#form-pin").show();
				} else {				
					$("#form-pin").hide();
					UIkit.accordion("#stepper").toggle(1);
					$("#chosen-number").html("");
					$("#step-number").removeClass("uk-link-muted");
					$("#input-number,#confirm-number").prop('disabled',false);
					UIkit.accordion("#stepper").toggle(2);
					$("#product").val(product);
				}
			}
		});
		$("#step-number").click(function(e){
			if (!isProductDefined){
				e.preventDefault();
				return false;
			}
		});
		$("#confirm-number").click(function(e){
			e.preventDefault();
			var number = $("#input-number").val();
			if (number == ""){
				return false;
			}
			$("#number").val(number);
			$("#chosen-number").html(number);
			$("#form-pin").hide();
			UIkit.accordion("#stepper").toggle(2);
			$("#form-ricarica").show();
		});
	</script>
	
@endsection
