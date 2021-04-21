@extends('dashboard.base')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>Ricariche nazionali</h3>
                        </div>
                    </div>
                    <div class="card-body">						
						<div class="uk-padding-small">
							<h4>Ricarica telefonica</h4>
							{!! Form::open(array('route' => 'users.services.mbs.ricarica_telefonica', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
								{!! csrf_field() !!}	
								<div class="uk-child-width-1-3@m" uk-grid>
										<div class="">
											<div class="uk-form-controls">
												<input name="Numero" class="uk-input" id="form-horizontal-text" type="text" placeholder="Numero" required>
											</div>
										</div>								
										<div class="">
											<div class="uk-form-controls">
												<select name="Prodotto" class="uk-select" id="form-horizontal-text" type="text" placeholder="Seleziona prodotto" required>
												@foreach($products as $product)
												@if(in_array($product->Operatore,$providers_ricarica)&&$product->Tipo=="Ricarica OnLine")
													<option value="{{$product->Prodotto}}">{{$product->Operatore}} {{$product->Tipo}} {{number_format($product->PrezzoUtente,2)}} €
													</option>
												@endif
												@endforeach
												</select>		
											</div>
										</div>	
										<div>
											<button tpe="submit" class="uk-button uk-button-primary">{{ trans('titles.request') }}</button>
										</div>
								</div>
							{!! Form::close() !!}
						</div>
						<div class="uk-padding-small">
							<h4 class="">Ricarica PIN</h4>
							{!! Form::open(array('route' => 'users.services.mbs.ricarica_pin', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
								{!! csrf_field() !!}		
								<div class="uk-child-width-1-3@m" uk-grid>					
										<div class="">
											<div class="uk-form-controls">
												<select name="Prodotto" class="uk-select" id="form-horizontal-text" type="text" placeholder="Seleziona prodotto" required>
												@foreach($products as $product)
												@if(in_array($product->Operatore,$providers_ricarica)&&$product->Tipo=="Ricarica PIN")
													<option value="{{$product->Prodotto}}">{{$product->Operatore}} {{$product->Tipo}} {{number_format($product->PrezzoUtente,2)}} €
													</option>
												@endif
												@endforeach
												</select>		
											</div>
										</div>		
										<div class="">
											<button tpe="submit" class="uk-button uk-button-primary">{{ trans('titles.request') }}</button>
										</div>
								</div>
							{!! Form::close() !!}
						</div>						
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
@endsection
