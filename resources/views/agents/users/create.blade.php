@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span>Create user</span>
                        </div>
                    </div>
                    <form action="{{ route('agent.user.store') }}" method="post">
                        @csrf
                        <div id="vueel" class="card-body">
                            <div class="form-group has-feedback row {{ $errors->has('email') ? ' has-error ' : '' }}">
                                <label for="email"
                                    class="col-md-3 control-label">{{ trans('forms.create_user_ph_email') }}</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input class="form-control" type="email" name="email" id="email"
                                            placeholder="{{ trans('forms.create_user_ph_email') }}"
                                            value="{{ old('email') }}">
                                        <div class="input-group-append">
                                            <label for="email" class="input-group-text">
                                                <i class="fa fa-fw {{ trans('forms.create_user_icon_email') }}"
                                                    aria-hidden="true"></i>
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-feedback row {{ $errors->has('first_name') ? ' has-error ' : '' }}">
                                <label for="first_name"
                                    class="col-md-3 control-label">{{ trans('forms.create_user_ph_firstname') }}</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="first_name" id="first_name"
                                            placeholder="{{ trans('forms.create_user_ph_firstname') }}"
                                            value="{{ old('first_name') }}">
                                        <div class="input-group-append">
                                            <label for="first_name" class="input-group-text">
                                                <i class="fa fa-fw {{ trans('forms.create_user_icon_firstname') }}"
                                                    aria-hidden="true"></i>
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('first_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-feedback row {{ $errors->has('last_name') ? ' has-error ' : '' }}">
                                <label for="last_name"
                                    class="col-md-3 control-label">{{ trans('forms.create_user_ph_lastname') }}</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="last_name" id="last_name"
                                            placeholder="{{ trans('forms.create_user_ph_lastname') }}"
                                            value="{{ old('last_name') }}">
                                        <div class="input-group-append">
                                            <label for="last_name" class="input-group-text">
                                                <i class="fa fa-fw {{ trans('forms.create_user_icon_lastname') }}"
                                                    aria-hidden="true"></i>
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
							</div>
							<div class="btn btn-link">Dati aziendali</div>
							<div class="my-4" id="hidden-inputs">
								<div class="form-group has-feedback row {{ $errors->has('company_name') ? ' has-error ' : '' }}">
									<label for="company_name"
										class="col-md-3 control-label">Ragione sociale</label>
									<div class="col-md-9">
										<div class="input-group">
											<input class="form-control" type="text" name="company_name" id="company_name"
												placeholder="Ragione sociale"
												value="{{ old('company_name') }}">
											<div class="input-group-append">
												<label for="company_name" class="input-group-text">
													<i class="fa fa-fw {{ trans('forms.create_user_icon_lastname') }}"
														aria-hidden="true"></i>
												</label>
											</div>
										</div>
										@if ($errors->has('company_name'))
											<span class="help-block">
												<strong>{{ $errors->first('company_name') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group has-feedback row {{ $errors->has('legal_seat_address') ? ' has-error ' : '' }}">
									<label for="legal_seat_address"
										class="col-md-3 control-label">Sede legale - indirizzo</label>
									<div class="col-md-9">
										<div class="input-group">
											<input v-model="valuesToBeCopied.legal_seat_address" class="form-control" type="text" name="legal_seat_address" id="legal_seat_address"
												placeholder="Sede legale - indirizzo"
												value="{{ old('legal_seat_address') }}">
											<div class="input-group-append">
												<label for="legal_seat_address" class="input-group-text">
													<i class="fa fa-fw {{ trans('forms.create_user_icon_lastname') }}"
														aria-hidden="true"></i>
												</label>
											</div>
										</div>
										@if ($errors->has('legal_seat_address'))
											<span class="help-block">
												<strong>{{ $errors->first('legal_seat_address') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group has-feedback row {{ $errors->has('legal_seat_zip') ? ' has-error ' : '' }}">
									<label for="legal_seat_zip"
										class="col-md-3 control-label">Sede legale - CAP</label>
									<div class="col-md-9">
										<div class="input-group">
											<input v-model="valuesToBeCopied.legal_seat_zip" class="form-control" type="text" name="legal_seat_zip" id="legal_seat_zip"
												placeholder="Sede legale - CAP"
												value="{{ old('legal_seat_zip') }}">
											<div class="input-group-append">
												<label for="legal_seat_zip" class="input-group-text">
													<i class="fa fa-fw {{ trans('forms.create_user_icon_lastname') }}"
														aria-hidden="true"></i>
												</label>
											</div>
										</div>
										@if ($errors->has('legal_seat_zip'))
											<span class="help-block">
												<strong>{{ $errors->first('legal_seat_zip') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group has-feedback row {{ $errors->has('legal_seat_city') ? ' has-error ' : '' }}">
									<label for="legal_seat_city"
										class="col-md-3 control-label">Sede legale - Città</label>
									<div class="col-md-9">
										<div class="input-group">
											<input v-model="valuesToBeCopied.legal_seat_city" class="form-control" type="text" name="legal_seat_city" id="legal_seat_city"
												placeholder="Sede legale - Città"
												value="{{ old('legal_seat_city') }}">
											<div class="input-group-append">
												<label for="legal_seat_city" class="input-group-text">
													<i class="fa fa-fw {{ trans('forms.create_user_icon_lastname') }}"
														aria-hidden="true"></i>
												</label>
											</div>
										</div>
										@if ($errors->has('legal_seat_city'))
											<span class="help-block">
												<strong>{{ $errors->first('legal_seat_city') }}</strong>
											</span>
										@endif
									</div>
								</div>
								@php $regions = ['Abruzzo','Basilicata', 'Calabria', 'Campania', 'Emilia-Romagna', 'Friuli Venezia Giulia' ,'Lazio' ,'Liguria', 'Lombardia', 'Marche', 'Molise' , 'Piemonte', 'Puglia', 'Sardegna', 'Sicilia', 'Toscana']; @endphp
								<div class="form-group has-feedback row {{ $errors->has('legal_seat_region') ? ' has-error ' : '' }}">
									<label for="legal_seat_region"
										class="col-md-3 control-label">Sede legale - Regione</label>
									<div class="col-md-9">
										<div class="input-group">
											<select class="form-control" name="legal_seat_region" id="legal_seat_region" v-model="valuesToBeCopied.legal_seat_region">
												@foreach ($regions as $region)
													<option value="{{$region}}">{{$region}}</option>
												@endforeach
											</select>
										</div>
										@if ($errors->has('legal_seat_region'))
											<span class="help-block">
												<strong>{{ $errors->first('legal_seat_region') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group">
									<button class="btn btn-success" @click.prevent="copyValues">Copia dati sede legale in sede operativa</button>
								</div>
								<div class="form-group has-feedback row {{ $errors->has('operative_seat_address') ? ' has-error ' : '' }}">
									<label for="operative_seat_address"
										class="col-md-3 control-label">Sede operativa - indirizzo</label>
									<div class="col-md-9">
										<div class="input-group">
											<input v-model="valuesToPassCopy.operative_seat_address" class="form-control" type="text" name="operative_seat_address" id="operative_seat_address"
												placeholder="Sede operativa - indirizzo"
												value="{{ old('operative_seat_address') }}">
											<div class="input-group-append">
												<label for="operative_seat_address" class="input-group-text">
													<i class="fa fa-fw location-pin"
														aria-hidden="true"></i>
												</label>
											</div>
										</div>
										@if ($errors->has('operative_seat_address'))
											<span class="help-block">
												<strong>{{ $errors->first('operative_seat_address') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group has-feedback row {{ $errors->has('operative_seat_zip') ? ' has-error ' : '' }}">
									<label for="operative_seat_zip"
										class="col-md-3 control-label">Sede operativa - CAP</label>
									<div class="col-md-9">
										<div class="input-group">
											<input v-model="valuesToPassCopy.operative_seat_zip" class="form-control" type="text" name="operative_seat_zip" id="operative_seat_zip"
												placeholder="Sede operativa - CAP"
												value="{{ old('operative_seat_zip') }}">
											<div class="input-group-append">
												<label for="operative_seat_zip" class="input-group-text">
													<i class="fa fa-fw location-pin"
														aria-hidden="true"></i>
												</label>
											</div>
										</div>
										@if ($errors->has('operative_seat_zip'))
											<span class="help-block">
												<strong>{{ $errors->first('operative_seat_zip') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group has-feedback row {{ $errors->has('operative_seat_city') ? ' has-error ' : '' }}">
									<label for="operative_seat_city"
										class="col-md-3 control-label">Sede operativa - Città</label>
									<div class="col-md-9">
										<div class="input-group">
											<input v-model="valuesToPassCopy.operative_seat_city" class="form-control" type="text" name="operative_seat_city" id="operative_seat_city"
												placeholder="Sede operativa - Città"
												value="{{ old('operative_seat_city') }}">
											<div class="input-group-append">
												<label for="operative_seat_city" class="input-group-text">
													<i class="fa fa-fw location-pin"
														aria-hidden="true"></i>
												</label>
											</div>
										</div>
										@if ($errors->has('operative_seat_city'))
											<span class="help-block">
												<strong>{{ $errors->first('operative_seat_city') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group has-feedback row {{ $errors->has('operative_seat_region') ? ' has-error ' : '' }}">
									<label for="operative_seat_region"
										class="col-md-3 control-label">Sede operativa - Regione</label>
									<div class="col-md-9">
										<div class="input-group">
											<select class="form-control" name="operative_seat_region" id="operative_seat_region" v-model="valuesToPassCopy.operative_seat_region">
												@foreach ($regions as $region)
													<option value="{{$region}}">{{$region}}</option>
												@endforeach
											</select>
										</div>
										@if ($errors->has('operative_seat_region'))
											<span class="help-block">
												<strong>{{ $errors->first('operative_seat_region') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group has-feedback row {{ $errors->has('vat') ? ' has-error ' : '' }}">
									<label for="vat"
										class="col-md-3 control-label">Partita IVA</label>
									<div class="col-md-9">
										<div class="input-group">
											<input class="form-control" type="text" name="vat" id="vat"
												placeholder="Partita IVA"
												value="{{ old('vat') }}">
											<div class="input-group-append">
												<label for="vat" class="input-group-text">
													<i class="fa fa-fw {{ trans('forms.create_user_icon_lastname') }}"
														aria-hidden="true"></i>
												</label>
											</div>
										</div>
										@if ($errors->has('vat'))
											<span class="help-block">
												<strong>{{ $errors->first('vat') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group has-feedback row {{ $errors->has('tax_unique_code') ? ' has-error ' : '' }}">
									<label for="tax_unique_code"
										class="col-md-3 control-label">Codice unico destinatario</label>
									<div class="col-md-9">
										<div class="input-group">
											<input class="form-control" type="text" name="tax_unique_code" id="tax_unique_code"
												placeholder="Codice unico destinatario"
												value="{{ old('tax_unique_code') }}">
											<div class="input-group-append">
												<label for="tax_unique_code" class="input-group-text">
													<i class="fa fa-fw {{ trans('forms.create_user_icon_lastname') }}"
														aria-hidden="true"></i>
												</label>
											</div>
										</div>
										@if ($errors->has('tax_unique_code'))
											<span class="help-block">
												<strong>{{ $errors->first('vat') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group has-feedback row {{ $errors->has('vat_percent') ? ' has-error ' : '' }}">
									<label for="vat_percent"
										class="col-md-3 control-label">Percentuale IVA</label>
									<div class="col-md-9">
										<div class="input-group">
											<input class="form-control" type="number" min="0" name="vat_percent" id="vat_percent"
												placeholder="Percentuale IVA"
												value="{{ old('vat_percent') }}">
											<div class="input-group-append">
												<label for="vat_percent" class="input-group-text">
													<i class="fa fa-fw"
														aria-hidden="true"></i>
												</label>
											</div>
										</div>
										@if ($errors->has('vat_percent'))
											<span class="help-block">
												<strong>{{ $errors->first('vat_percent') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group has-feedback row {{ $errors->has('witholding_tax_percent') ? ' has-error ' : '' }}">
									<label for="witholding_tax_percent"
										class="col-md-3 control-label">Percentuale ritenuta d'acconto</label>
									<div class="col-md-9">
										<div class="input-group">
											<input class="form-control" type="number" min="0" name="witholding_tax_percent" id="witholding_tax_percent"
												placeholder="Percentuale ritenuta d'acconto"
												value="{{ old('witholding_tax_percent') }}">
											<div class="input-group-append">
												<label for="witholding_tax_percent" class="input-group-text">
													<i class="fa fa-fw"
														aria-hidden="true"></i>
												</label>
											</div>
										</div>
										@if ($errors->has('witholding_tax_percent'))
											<span class="help-block">
												<strong>{{ $errors->first('witholding_tax_percent') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group has-feedback row {{ $errors->has('pec') ? ' has-error ' : '' }}">
									<label for="pec"
										class="col-md-3 control-label">PEC</label>
									<div class="col-md-9">
										<div class="input-group">
											<input class="form-control" type="text" name="pec" id="pec"
												placeholder="PEC"
												value="{{ old('pec') }}">
											<div class="input-group-append">
												<label for="pec" class="input-group-text">
													<i class="fa fa-fw {{ trans('forms.create_user_icon_lastname') }}"
														aria-hidden="true"></i>
												</label>
											</div>
										</div>
										@if ($errors->has('pec'))
											<span class="help-block">
												<strong>{{ $errors->first('pec') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group has-feedback row {{ $errors->has('company_email') ? ' has-error ' : '' }}">
									<label for="phone"
										class="col-md-3 control-label">Email</label>
									<div class="col-md-9">
										<div class="input-group">
											<input class="form-control" type="email" name="company_email" id="company_email"
												placeholder="Email"
												value="{{ old('company_email') }}">
											<div class="input-group-append">
												<label for="company_email" class="input-group-text">
													<i class="fa fa-fw {{ trans('forms.create_user_icon_email') }}"
														aria-hidden="true"></i>
												</label>
											</div>
										</div>
										@if ($errors->has('company_email'))
											<span class="help-block">
												<strong>{{ $errors->first('company_email') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group has-feedback row {{ $errors->has('phone') ? ' has-error ' : '' }}">
									<label for="phone"
										class="col-md-3 control-label">Telefono fisso</label>
									<div class="col-md-9">
										<div class="input-group">
											<input class="form-control" type="text" name="phone" id="phone"
												placeholder="Telefono fisso"
												value="{{ old('phone') }}">
											<div class="input-group-append">
												<label for="phone" class="input-group-text">
													<i class="fa fa-fw {{ trans('forms.create_user_icon_lastname') }}"
														aria-hidden="true"></i>
												</label>
											</div>
										</div>
										@if ($errors->has('phone'))
											<span class="help-block">
												<strong>{{ $errors->first('phone') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group has-feedback row {{ $errors->has('mobile') ? ' has-error ' : '' }}">
									<label for="mobile"
										class="col-md-3 control-label">Cellulare</label>
									<div class="col-md-9">
										<div class="input-group">
											<input class="form-control" type="text" name="mobile" id="mobile"
												placeholder="Cellulare"
												value="{{ old('mobile') }}">
											<div class="input-group-append">
												<label for="mobile" class="input-group-text">
													<i class="fa fa-fw {{ trans('forms.create_user_icon_lastname') }}"
														aria-hidden="true"></i>
												</label>
											</div>
										</div>
										@if ($errors->has('mobile'))
											<span class="help-block">
												<strong>{{ $errors->first('mobile') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group has-feedback row {{ $errors->has('company_mobile') ? ' has-error ' : '' }}">
									<label for="company_mobile"
										class="col-md-3 control-label">Cellulare referente</label>
									<div class="col-md-9">
										<div class="input-group">
											<input class="form-control" type="text" name="company_mobile" id="company_mobile"
												placeholder="Cellulare referente"
												value="{{ old('company_mobile') }}">
											<div class="input-group-append">
												<label for="company_mobile" class="input-group-text">
													<i class="fa fa-fw {{ trans('forms.create_user_icon_lastname') }}"
														aria-hidden="true"></i>
												</label>
											</div>
										</div>
										@if ($errors->has('company_mobile'))
											<span class="help-block">
												<strong>{{ $errors->first('company_mobile') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group has-feedback row {{ $errors->has('shop_sign') ? ' has-error ' : '' }}">
									<label for="shop_sign"
										class="col-md-3 control-label">Insegna negozio</label>
									<div class="col-md-9">
										<div class="input-group">
											<input class="form-control" type="text" name="shop_sign" id="shop_sign"
												placeholder="Insegna negozio"
												value="{{ old('shop_sign') }}">
											<div class="input-group-append">
												<label for="shop_sign" class="input-group-text">
													<i class="fa fa-fw {{ trans('forms.create_user_icon_lastname') }}"
														aria-hidden="true"></i>
												</label>
											</div>
										</div>
										@if ($errors->has('shop_sign'))
											<span class="help-block">
												<strong>{{ $errors->first('shop_sign') }}</strong>
											</span>
										@endif
									</div>
								</div>

								<div class="py-4">
									<button class="btn btn-success margin-bottom-1 mb-1 float-right">{{ __('forms.create_user_button_text') }}</button>
								</div>
							</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-save')
    @include('modals.modal-delete')

@endsection

@section('javascript')
@endsection
