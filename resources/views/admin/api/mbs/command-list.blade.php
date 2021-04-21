@extends('dashboard.base')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>Funzioni MBS</h3>
                        </div>
                    </div>
                    <div class="card-body">
						<ul class="nav flex-column">
						  <li class="nav-item">
							<a class="nav-link" href="{{ url('/admin/api/mbs/balance') }}">Balance</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" href="{{ url('/admin/api/mbs/prefix-list') }}">International prefixes</a>
						  </li>
						</ul>
						<div class="uk-padding-small" uk-grid>
							<div class="uk-width-1-4">Richiesta beneficiario</div>
							<div class="uk-width-3-4">
								{!! Form::open(array('route' => 'admin.api.mbs.beneficiario_bollettino', 'method' => 'POST', 'role' => 'form', 'class' => 'uk-form-horizontal needs-validation')) !!}
									{!! csrf_field() !!}								
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Conto corrente</label>
										<div class="uk-form-controls">
											<input name="ContoCorrente" class="uk-input" id="form-horizontal-text" type="text" placeholder="Conto corrente" required>
										</div>
									</div>	
									<div class="uk-text-center">
										<button tpe="submit" class="uk-button uk-button-small uk-button-primary">{{ trans('titles.request') }}</button>
									</div>
								{!! Form::close() !!}
							</div>
						</div>
						<div class="uk-padding-small" uk-grid>
							<div class="uk-width-1-4">Pagamento bollettino premarcato</div>
							<div class="uk-width-3-4">
								{!! Form::open(array('route' => 'admin.api.mbs.pagamento_bollettino', 'method' => 'POST', 'role' => 'form', 'class' => 'uk-form-horizontal needs-validation')) !!}
									{!! csrf_field() !!}								
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Tipo conto corrente</label>
										<div class="uk-form-controls">
											<input name="TipoContoCorrente" class="uk-input" id="form-horizontal-text" type="text" placeholder="Tipo conto corrente" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">ContoCorrente</label>
										<div class="uk-form-controls">
											<input name="ContoCorrente" class="uk-input" id="form-horizontal-text" type="text" placeholder="ContoCorrente" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Beneficiario</label>
										<div class="uk-form-controls">
											<input name="Beneficiario" class="uk-input" id="form-horizontal-text" type="text" placeholder="Beneficiario" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Identificativo</label>
										<div class="uk-form-controls">
											<input name="Identificativo" class="uk-input" id="form-horizontal-text" type="text" placeholder="Identificativo" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Importo</label>
										<div class="uk-form-controls">
											<input name="Importo" class="uk-input" id="form-horizontal-text" type="text" placeholder="Importo" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Causale</label>
										<div class="uk-form-controls">
											<input name="Causale" class="uk-input" id="form-horizontal-text" type="text" placeholder="Causale" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">EmailOrdinante</label>
										<div class="uk-form-controls">
											<input name="EmailOrdinante" class="uk-input" id="form-horizontal-text" type="text" placeholder="EmailOrdinante" required>
										</div>
									</div>								
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">CellulareOrdinante</label>
										<div class="uk-form-controls">
											<input name="CellulareOrdinante" class="uk-input" id="form-horizontal-text" type="text" placeholder="CellulareOrdinante" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Nome</label>
										<div class="uk-form-controls">
											<input name="Nome" class="uk-input" id="form-horizontal-text" type="text" placeholder="Nome" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Cognome</label>
										<div class="uk-form-controls">
											<input name="Cognome" class="uk-input" id="form-horizontal-text" type="text" placeholder="Cognome" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Indirizzo</label>
										<div class="uk-form-controls">
											<input name="Indirizzo" class="uk-input" id="form-horizontal-text" type="text" placeholder="Indirizzo" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Citta</label>
										<div class="uk-form-controls">
											<input name="Citta" class="uk-input" id="form-horizontal-text" type="text" placeholder="Citta" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Cap</label>
										<div class="uk-form-controls">
											<input name="Cap" class="uk-input" id="form-horizontal-text" type="text" placeholder="Cap" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">NomeUtente</label>
										<div class="uk-form-controls">
											<input name="NomeUtente" class="uk-input" id="form-horizontal-text" type="text" placeholder="NomeUtente" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">CognomeUtente</label>
										<div class="uk-form-controls">
											<input name="CognomeUtente" class="uk-input" id="form-horizontal-text" type="text" placeholder="CognomeUtente" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">CittaUtente</label>
										<div class="uk-form-controls">
											<input name="CittaUtente" class="uk-input" id="form-horizontal-text" type="text" placeholder="CittaUtente" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">IndirizzoUtente</label>
										<div class="uk-form-controls">
											<input name="IndirizzoUtente" class="uk-input" id="form-horizontal-text" type="text" placeholder="IndirizzoUtente" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Ragione sociale</label>
										<div class="uk-form-controls">
											<input name="RagioneSocialeMerch" class="uk-input" id="form-horizontal-text" type="text" placeholder="RagioneSocialeMerch" required>
										</div>
									</div>	
									<div class="uk-text-center">
										<button tpe="submit" class="uk-button uk-button-small uk-button-primary">{{ trans('titles.request') }}</button>
									</div>
								{!! Form::close() !!}
							</div>
						</div>
						<div class="uk-padding-small" uk-grid>
							<div class="uk-width-1-4">Pagamento bollettino MAV</div>
							<div class="uk-width-3-4">
								{!! Form::open(array('route' => 'admin.api.mbs.pagamento_bollettino_mav', 'method' => 'POST', 'role' => 'form', 'class' => 'uk-form-horizontal needs-validation')) !!}
									{!! csrf_field() !!}								
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Identificativo</label>
										<div class="uk-form-controls">
											<input name="Identificativo" class="uk-input" id="form-horizontal-text" type="text" placeholder="Identificativo" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Importo</label>
										<div class="uk-form-controls">
											<input name="Importo" class="uk-input" id="form-horizontal-text" type="text" placeholder="Importo" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Nome</label>
										<div class="uk-form-controls">
											<input name="Nome" class="uk-input" id="form-horizontal-text" type="text" placeholder="Nome" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Cognome</label>
										<div class="uk-form-controls">
											<input name="Cognome" class="uk-input" id="form-horizontal-text" type="text" placeholder="Cognome" required>
										</div>
									</div>			
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">NomeUtente</label>
										<div class="uk-form-controls">
											<input name="NomeUtente" class="uk-input" id="form-horizontal-text" type="text" placeholder="NomeUtente" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">CognomeUtente</label>
										<div class="uk-form-controls">
											<input name="CognomeUtente" class="uk-input" id="form-horizontal-text" type="text" placeholder="CognomeUtente" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">CittaUtente</label>
										<div class="uk-form-controls">
											<input name="CittaUtente" class="uk-input" id="form-horizontal-text" type="text" placeholder="CittaUtente" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">IndirizzoUtente</label>
										<div class="uk-form-controls">
											<input name="IndirizzoUtente" class="uk-input" id="form-horizontal-text" type="text" placeholder="IndirizzoUtente" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Ragione sociale</label>
										<div class="uk-form-controls">
											<input name="RagioneSocialeMerch" class="uk-input" id="form-horizontal-text" type="text" placeholder="RagioneSocialeMerch" required>
										</div>
									</div>	
									<div class="uk-text-center">
										<button tpe="submit" class="uk-button uk-button-small uk-button-primary">{{ trans('titles.request') }}</button>
									</div>
								{!! Form::close() !!}
							</div>
						</div>
						<div class="uk-padding-small" uk-grid>
							<div class="uk-width-1-4">Pagamento bollettino RAV</div>
							<div class="uk-width-3-4">
								{!! Form::open(array('route' => 'admin.api.mbs.pagamento_bollettino_rav', 'method' => 'POST', 'role' => 'form', 'class' => 'uk-form-horizontal needs-validation')) !!}
									{!! csrf_field() !!}								
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Identificativo</label>
										<div class="uk-form-controls">
											<input name="Identificativo" class="uk-input" id="form-horizontal-text" type="text" placeholder="Identificativo" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Importo</label>
										<div class="uk-form-controls">
											<input name="Importo" class="uk-input" id="form-horizontal-text" type="text" placeholder="Importo" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Nome</label>
										<div class="uk-form-controls">
											<input name="Nome" class="uk-input" id="form-horizontal-text" type="text" placeholder="Nome" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Cognome</label>
										<div class="uk-form-controls">
											<input name="Cognome" class="uk-input" id="form-horizontal-text" type="text" placeholder="Cognome" required>
										</div>
									</div>			
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">NomeUtente</label>
										<div class="uk-form-controls">
											<input name="NomeUtente" class="uk-input" id="form-horizontal-text" type="text" placeholder="NomeUtente" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">CognomeUtente</label>
										<div class="uk-form-controls">
											<input name="CognomeUtente" class="uk-input" id="form-horizontal-text" type="text" placeholder="CognomeUtente" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">CittaUtente</label>
										<div class="uk-form-controls">
											<input name="CittaUtente" class="uk-input" id="form-horizontal-text" type="text" placeholder="CittaUtente" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">IndirizzoUtente</label>
										<div class="uk-form-controls">
											<input name="IndirizzoUtente" class="uk-input" id="form-horizontal-text" type="text" placeholder="IndirizzoUtente" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Ragione sociale</label>
										<div class="uk-form-controls">
											<input name="RagioneSocialeMerch" class="uk-input" id="form-horizontal-text" type="text" placeholder="RagioneSocialeMerch" required>
										</div>
									</div>	
									<div class="uk-text-center">
										<button tpe="submit" class="uk-button uk-button-small uk-button-primary">{{ trans('titles.request') }}</button>
									</div>
								{!! Form::close() !!}
							</div>
						</div>
						<div class="uk-padding-small" uk-grid>
							<div class="uk-width-1-4">Richiesta biller</div>
							<div class="uk-width-3-4">
								{!! Form::open(array('route' => 'admin.api.mbs.richiesta_biller', 'method' => 'POST', 'role' => 'form', 'class' => 'uk-form-horizontal needs-validation')) !!}
									{!! csrf_field() !!}								
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Codice</label>
										<div class="uk-form-controls">
											<input name="ContoCorrente" class="uk-input" id="form-horizontal-text" type="text" placeholder="Codice" required>
										</div>
									</div>	
									<div class="uk-text-center">
										<button tpe="submit" class="uk-button uk-button-small uk-button-primary">{{ trans('titles.request') }}</button>
									</div>
								{!! Form::close() !!}
							</div>
						</div>
						<div class="uk-padding-small" uk-grid>
							<div class="uk-width-1-4">Pagamento bollettino CBILL</div>
							<div class="uk-width-3-4">
								{!! Form::open(array('route' => 'admin.api.mbs.pagamento_bollettino_cbill', 'method' => 'POST', 'role' => 'form', 'class' => 'uk-form-horizontal needs-validation')) !!}
									{!! csrf_field() !!}								
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">CodiceBollettino</label>
										<div class="uk-form-controls">
											<input name="CodiceBollettino" class="uk-input" id="form-horizontal-text" type="text" placeholder="CodiceBollettino" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">SiaCode</label>
										<div class="uk-form-controls">
											<input name="SiaCode" class="uk-input" id="form-horizontal-text" type="text" placeholder="SiaCode" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Agenzia</label>
										<div class="uk-form-controls">
											<input name="Agenzia" class="uk-input" id="form-horizontal-text" type="text" placeholder="Agenzia" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">CodiceFiscale</label>
										<div class="uk-form-controls">
											<input name="CodiceFiscale" class="uk-input" id="form-horizontal-text" type="text" placeholder="CodiceFiscale" required>
										</div>
									</div>			
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">ImportoBollettino</label>
										<div class="uk-form-controls">
											<input name="ImportoBollettino" class="uk-input" id="form-horizontal-text" type="text" placeholder="ImportoBollettino" required>
										</div>
									</div>								
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">NomeUtente</label>
										<div class="uk-form-controls">
											<input name="CognomeUtente" class="uk-input" id="form-horizontal-text" type="text" placeholder="CognomeUtente" required>
										</div>
									</div>					
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">CognomeUtente</label>
										<div class="uk-form-controls">
											<input name="CognomeUtente" class="uk-input" id="form-horizontal-text" type="text" placeholder="CognomeUtente" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">CittaUtente</label>
										<div class="uk-form-controls">
											<input name="CittaUtente" class="uk-input" id="form-horizontal-text" type="text" placeholder="CittaUtente" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">IndirizzoUtente</label>
										<div class="uk-form-controls">
											<input name="IndirizzoUtente" class="uk-input" id="form-horizontal-text" type="text" placeholder="IndirizzoUtente" required>
										</div>
									</div>							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Ragione sociale</label>
										<div class="uk-form-controls">
											<input name="RagioneSocialeMerch" class="uk-input" id="form-horizontal-text" type="text" placeholder="RagioneSocialeMerch" required>
										</div>
									</div>	
									<div class="uk-text-center">
										<button tpe="submit" class="uk-button uk-button-small uk-button-primary">{{ trans('titles.request') }}</button>
									</div>
								{!! Form::close() !!}
							</div>
						</div>
						<div class="uk-padding-small" uk-grid>
							<div class="uk-width-1-4">Ricarica telefonica</div>
							<div class="uk-width-3-4">
								{!! Form::open(array('route' => 'admin.api.mbs.ricarica_telefonica', 'method' => 'POST', 'role' => 'form', 'class' => 'uk-form-horizontal needs-validation')) !!}
									{!! csrf_field() !!}								
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Numero</label>
										<div class="uk-form-controls">
											<input name="Numero" class="uk-input" id="form-horizontal-text" type="text" placeholder="Numero" required>
										</div>
									</div>								
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Prodotto</label>
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
									<div class="uk-text-center">
										<button tpe="submit" class="uk-button uk-button-small uk-button-primary">{{ trans('titles.request') }}</button>
									</div>
								{!! Form::close() !!}
							</div>
						</div>
						<div class="uk-padding-small" uk-grid>
							<div class="uk-width-1-4">Ricarica PIN</div>
							<div class="uk-width-3-4">
								{!! Form::open(array('route' => 'admin.api.mbs.ricarica_pin', 'method' => 'POST', 'role' => 'form', 'class' => 'uk-form-horizontal needs-validation')) !!}
									{!! csrf_field() !!}							
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">Prodotto</label>
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
									<?php /*						
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">CodiceUtente</label>
										<div class="uk-form-controls">
											<input name="CodiceUtente" class="uk-input" id="form-horizontal-text" type="text" placeholder="CodiceUtente" >
										</div>
									</div>	
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">ImportoPinLibero</label>
										<div class="uk-form-controls">
											<input name="ImportoPinLibero" class="uk-input" id="form-horizontal-text" type="text" placeholder="ImportoPinLibero" >
										</div>
									</div>	
									*/ ?>
									<div class="uk-text-center">
										<button tpe="submit" class="uk-button uk-button-small uk-button-primary">{{ trans('titles.request') }}</button>
									</div>
								{!! Form::close() !!}
							</div>
						</div>
						<div class="uk-padding-small" uk-grid>
							<div class="uk-width-1-4">Verifica ricarica</div>
							<div class="uk-width-3-4">
								{!! Form::open(array('route' => 'admin.api.mbs.verifica_ricarica', 'method' => 'POST', 'role' => 'form', 'class' => 'uk-form-horizontal needs-validation')) !!}
									{!! csrf_field() !!}								
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">ID Operazione</label>
										<div class="uk-form-controls">
											<input name="IDOperazione" class="uk-input" id="form-horizontal-text" type="text" placeholder="ID Operazione" required>
										</div>
									</div>	
									<div class="uk-text-center">
										<button tpe="submit" class="uk-button uk-button-small uk-button-primary">{{ trans('titles.request') }}</button>
									</div>
								{!! Form::close() !!}
							</div>
						</div>
						<div class="uk-padding-small" uk-grid>
							<div class="uk-width-1-4">Verifica ricarica PIN</div>
							<div class="uk-width-3-4">
								{!! Form::open(array('route' => 'admin.api.mbs.verifica_ricarica_pin', 'method' => 'POST', 'role' => 'form', 'class' => 'uk-form-horizontal needs-validation')) !!}
									{!! csrf_field() !!}								
									<div class="uk-padding-small">
										<label class="uk-form-label" for="form-horizontal-text">ID Operazione</label>
										<div class="uk-form-controls">
											<input name="IDOperazione" class="uk-input" id="form-horizontal-text" type="text" placeholder="ID Operazione" required>
										</div>
									</div>	
									<div class="uk-text-center">
										<button tpe="submit" class="uk-button uk-button-small uk-button-primary">{{ trans('titles.request') }}</button>
									</div>
								{!! Form::close() !!}
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
		<div class="row">
			<table class="table">
				<thead>
					<tr>
						<th>Prodotto</th>
						<th>Operatore</th>
						<th>Tipo</th>
						<th>SottoTipo</th>
						<th>Descrizione</th>
						<th>PrezzoUtente</th>
					</tr>
				</thead>
				<tbody>
				@foreach($products as $product)
					<tr>
						<td>{{$product->Prodotto}}</td>
						<td>{{$product->Operatore}}</td>
						<td>{{$product->Tipo}}</td>
						<td>{{$product->SottoTipo}}</td>
						<td>{{$product->Descrizione}}</td>
						<td>{{$product->PrezzoUtente}}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
    </div>

@endsection

@section('javascript')
@endsection
