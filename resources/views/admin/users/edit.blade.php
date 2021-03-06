@extends('dashboard.base')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            {!! trans('usersmanagement.editing-user', ['name' => $user->name]) !!}
                            <div class="pull-right">
                                <a href="{{ url('/users') }}" class="btn btn-light btn-sm float-right uk-margin-left" data-toggle="tooltip" data-placement="top" title="{{ trans('usersmanagement.tooltips.back-users') }}">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    {!! trans('usersmanagement.buttons.back-to-users') !!}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::open(array('route' => ['users.update', $user->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}

                            {!! csrf_field() !!}

							<div uk-grid>
								<div class="uk-width-1-3@s">
									<ul class="uk-tab-left" uk-tab="connect: #form-boxes;">
										<li class="uk-active"><a href="#">{{ trans('titles.client') }}</a></li>
										@if ($user->hasRole('user')||$user->hasRole('sales'))
										<li><a href="#">{{ trans('titles.company-data') }}</a></li>
										@endif
									</ul>
								</div>
								<div class="uk-width-2-3@s">
									<ul id="form-boxes" class="uk-switcher">
										<li>
											<div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
												{!! Form::label('name', trans('forms.create_user_label_username'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('name', $user->name, array('id' => 'name', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_username'))) !!}
														<div class="input-group-append">
															<label class="input-group-text" for="name">
																<i class="fa fa-fw {{ trans('forms.create_user_icon_username') }}" aria-hidden="true"></i>
															</label>
														</div>
													</div>
													@if($errors->has('name'))
														<span class="help-block">
															<strong>{{ $errors->first('name') }}</strong>
														</span>
													@endif
												</div>
											</div>
											@if($user->hasRole('user'))
											<div class="form-group has-feedback row {{ $errors->has('parent') ? ' has-error ' : '' }}">

												{!! Form::label('parent', trans('forms.referent'), array('class' => 'col-md-3 control-label')); !!}

												<div class="col-md-9">
													<div class="input-group">
														<select class="custom-select form-control" name="parent" id="parent">
															<option value="0" {{ $user->parent_id == 0 ? 'selected="selected"' : '' }}>Nessuno</option>
															@if ($users)
																@foreach($users as $listuser)
																	<option value="{{ $listuser->id }}" {{ $listuser->id == $user->parent_id ? 'selected="selected"' : '' }}>{{ $listuser->name }}</option>
																@endforeach
															@endif
														</select>
														<div class="input-group-append">
															<label class="input-group-text" for="parent">
																<i class="fa fa-fw {{ trans('forms.create_user_icon_username') }}" aria-hidden="true"></i>
															</label>
														</div>
													</div>
													@if ($errors->has('parent'))
														<span class="help-block">
															<strong>{{ $errors->first('parent') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('plafond') ? ' has-error ' : '' }}">
												{!! Form::label('plafond', trans('titles.plafond'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::number('plafond', $user->plafond, array('id' => 'plafond', 'class' => 'form-control', 'placeholder' => 'Plafond', 'min' => '0', 'step' => '0.001')) !!}
														<div class="input-group-append">
															<label for="plafond" class="input-group-text">
																???
															</label>
														</div>
													</div>
													@if ($errors->has('plafond'))
														<span class="help-block">
															<strong>{{ $errors->first('plafond') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('debt_limit') ? ' has-error ' : '' }}">
												{!! Form::label('debt_limit', trans('titles.plafond-limit'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::number('debt_limit', $user->debt_limit, array('id' => 'debt_limit', 'class' => 'form-control', 'placeholder' => 'Plafond', 'min' => '0', 'step' => '0.001')) !!}
														<div class="input-group-append">
															<label for="debt_limit" class="input-group-text">
																???
															</label>
														</div>
													</div>
													@if ($errors->has('debt_limit'))
														<span class="help-block">
															<strong>{{ $errors->first('debt_limit') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('credit') ? ' has-error ' : '' }}">
												{!! Form::label('credit', trans('titles.credit'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::number('credit', $user->credit, array('id' => 'credit', 'class' => 'form-control', 'placeholder' => 'Credit', 'min' => '0', 'step' => '0.001')) !!}
														<div class="input-group-append">
															<label for="credit" class="input-group-text">
																???
															</label>
														</div>
													</div>
													@if ($errors->has('credit'))
														<span class="help-block">
															<strong>{{ $errors->first('credit') }}</strong>
														</span>
													@endif
												</div>
											</div>

											@endif
<?php /*
											<div class="form-group has-feedback row {{ $errors->has('first_name') ? ' has-error ' : '' }}">
												{!! Form::label('first_name', trans('forms.create_user_label_firstname'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('first_name', $user->first_name, array('id' => 'first_name', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_firstname'))) !!}
														<div class="input-group-append">
															<label class="input-group-text" for="first_name">
																<i class="fa fa-fw {{ trans('forms.create_user_icon_firstname') }}" aria-hidden="true"></i>
															</label>
														</div>
													</div>
													@if($errors->has('first_name'))
														<span class="help-block">
															<strong>{{ $errors->first('first_name') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('last_name') ? ' has-error ' : '' }}">
												{!! Form::label('last_name', trans('forms.create_user_label_lastname'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('last_name', $user->last_name, array('id' => 'last_name', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_lastname'))) !!}
														<div class="input-group-append">
															<label class="input-group-text" for="last_name">
																<i class="fa fa-fw {{ trans('forms.create_user_icon_lastname') }}" aria-hidden="true"></i>
															</label>
														</div>
													</div>
													@if($errors->has('last_name'))
														<span class="help-block">
															<strong>{{ $errors->first('last_name') }}</strong>
														</span>
													@endif
												</div>
											</div>
*/ ?>
											<div class="form-group has-feedback row {{ $errors->has('email') ? ' has-error ' : '' }}">
												{!! Form::label('email', trans('forms.create_user_label_email'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('email', $user->email, array('id' => 'email', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_email'))) !!}
														<div class="input-group-append">
															<label for="email" class="input-group-text">
																<i class="fa fa-fw {{ trans('forms.create_user_icon_email') }}" aria-hidden="true"></i>
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

                                            <div class="form-group has-feedback row {{ $errors->has('role') ? ' has-error ' : '' }}">
                                                <label for="role" class="col-md-3 control-label">{{ trans('titles.role') }}</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                                                            <option value="user" @if(!$user->hasRole('sales')) selected @endif>Point</option>
                                                            <option value="sales" @if($user->hasRole('sales')) selected @endif>Agent</option>
                                                        </select>
                                                    </div>
                                                    @if ($errors->has('role'))
                                                        <span class="help-block">
															<strong>{{ $errors->first('role') }}</strong>
														</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback row {{ $errors->has('group_id') ? ' has-error ' : '' }}">
                                                <label for="group_id" class="col-md-3 control-label">{{ trans('titles.client-group-id') }}</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <select name="group_id" id="group_id" class="form-control @error('group_id') is-invalid @enderror">
                                                            <option selected disabled>Choose a User group</option>
                                                            @foreach($userGroups as $userGroup)
                                                                <option value="{{$userGroup->id}}" @if($userGroup->id==$user->group_id) selected @endif>{{ $userGroup->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @if ($errors->has('group_id'))
                                                        <span class="help-block">
															<strong>{{ $errors->first('group_id') }}</strong>
														</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div id="hideIfRolePointSelected" class="form-group has-feedback row {{ $errors->has('agent_group_id') ? ' has-error ' : '' }}">
                                                <label for="agent_group_id" class="col-md-3 control-label">{{ trans('titles.agent-group-id') }}</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <select name="agent_group_id" id="agent_group_id" class="form-control @error('agent_group_id') is-invalid @enderror">
                                                            <option selected disabled>Choose an Agent group</option>
                                                            @foreach($agentGroups as $agentGroup)
                                                                <option value="{{$agentGroup->id}}" @if($agentGroup->id==$user->agent_group_id) selected @endif>{{ $agentGroup->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @if ($errors->has('agent_group_id'))
                                                        <span class="help-block">
															<strong>{{ $errors->first('agent_group_id') }}</strong>
														</span>
                                                    @endif
                                                </div>
                                            </div>
											<div class="pw-change-container">
												<div class="form-group has-feedback row {{ $errors->has('password') ? ' has-error ' : '' }}">

													{!! Form::label('password', trans('forms.create_user_label_password'), array('class' => 'col-md-3 control-label')); !!}

													<div class="col-md-9">
														<div class="input-group">
															{!! Form::password('password', array('id' => 'password', 'class' => 'form-control ', 'placeholder' => trans('forms.create_user_ph_password'))) !!}
															<div class="input-group-append">
																<label class="input-group-text" for="password">
																	<i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i>
																</label>
															</div>
														</div>
														@if ($errors->has('password'))
															<span class="help-block">
																<strong>{{ $errors->first('password') }}</strong>
															</span>
														@endif
													</div>
												</div>
												<div class="form-group has-feedback row {{ $errors->has('password_confirmation') ? ' has-error ' : '' }}">

													{!! Form::label('password_confirmation', trans('forms.create_user_label_pw_confirmation'), array('class' => 'col-md-3 control-label')); !!}

													<div class="col-md-9">
														<div class="input-group">
															{!! Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_pw_confirmation'))) !!}
															<div class="input-group-append">
																<label class="input-group-text" for="password_confirmation">
																	<i class="fa fa-fw {{ trans('forms.create_user_icon_pw_confirmation') }}" aria-hidden="true"></i>
																</label>
															</div>
														</div>
														@if ($errors->has('password_confirmation'))
															<span class="help-block">
																<strong>{{ $errors->first('password_confirmation') }}</strong>
															</span>
														@endif
													</div>
												</div>
											</div>
										</li>

										@if ($user->hasRole('user')||$user->hasRole('sales'))
										<li>
											<div class="form-group has-feedback row {{ $errors->has('company_name') ? ' has-error ' : '' }}">
												{!! Form::label('company_name', trans('titles.company-name'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('company_name', $user->company_data ? $user->company_data->company_name : '', array('id' => 'company_name', 'class' => 'form-control', 'placeholder' => 'Ragione sociale','required' => 'required')) !!}
													</div>
													@if ($errors->has('company_name'))
														<span class="help-block">
															<strong>{{ $errors->first('company_name') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('legal_seat_address') ? ' has-error ' : '' }}">
												{!! Form::label('legal_seat_address', trans('titles.legal-seat-address'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('legal_seat_address', $user->company_data ? $user->company_data->legal_seat_address : '', array('id' => 'legal_seat_address', 'class' => 'form-control', 'placeholder' => 'Sede legale - indirizzo','required' => 'required')) !!}
													</div>
													@if ($errors->has('legal_seat_address'))
														<span class="help-block">
															<strong>{{ $errors->first('legal_seat_address') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('legal_seat_zip') ? ' has-error ' : '' }}">
												{!! Form::label('legal_seat_zip', trans('titles.legal-seat-zip'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('legal_seat_zip', $user->company_data ? $user->company_data->legal_seat_zip : '', array('id' => 'legal_seat_zip', 'class' => 'form-control', 'placeholder' => 'Sede legale - CAP','required' => 'required')) !!}
													</div>
													@if ($errors->has('legal_seat_zip'))
														<span class="help-block">
															<strong>{{ $errors->first('legal_seat_zip') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('legal_seat_city') ? ' has-error ' : '' }}">
												{!! Form::label('legal_seat_city', trans('titles.legal-seat-city'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('legal_seat_city', $user->company_data ? $user->company_data->legal_seat_city : '', array('id' => 'legal_seat_city', 'class' => 'form-control', 'placeholder' => 'Sede legale - Citt??','required' => 'required')) !!}
													</div>
													@if ($errors->has('legal_seat_city'))
														<span class="help-block">
															<strong>{{ $errors->first('legal_seat_city') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('legal_seat_region') ? ' has-error ' : '' }}">
												{!! Form::label('legal_seat_region', trans('titles.legal-seat-region'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::select('legal_seat_region', ['Abruzzo' => 'Abruzzo', 'Basilicata' => 'Basilicata', 'Calabria' => 'Calabria', 'Campania' => 'Campania', 'Emilia-Romagna' => 'Emilia-Romagna', 'Friuli Venezia Giulia' => 'Friuli Venezia Giulia', 'Lazio' => 'Lazio', 'Liguria' => 'Liguria', 'Lombardia' => 'Lombardia', 'Marche' => 'Marche', 'Molise' => 'Molise', 'Piemonte' => 'Piemonte', 'Puglia' => 'Puglia', 'Sardegna' => 'Sardegna', 'Sicilia' => 'Sicilia', 'Toscana' => 'Toscana'], $user->company_data ? $user->company_data->legal_seat_region : '', array('id' => 'legal_seat_region', 'class' => 'custom-select')) !!}
														<div class="input-group-append">
															<label for="legal_seat_region" class="input-group-text">
																<i class="fa fa-fw {{ trans('forms.create_user_icon_place_region') }}" aria-hidden="true"></i>
															</label>
														</div>
													</div>
													@if ($errors->has('legal_seat_region'))
														<span class="help-block">
															<strong>{{ $errors->first('legal_seat_region') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group">
												<button class="btn btn-success" onClick="javascript:copy_values(event);">{{ trans('titles.copy-content') }}</button>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('operative_seat_address') ? ' has-error ' : '' }}">
												{!! Form::label('operative_seat_address', trans('titles.operative-seat-address'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('operative_seat_address', $user->company_data ? $user->company_data->operative_seat_address : '', array('id' => 'operative_seat_address', 'class' => 'form-control', 'placeholder' => 'Sede operativa - indirizzo','required' => 'required')) !!}
													</div>
													@if ($errors->has('operative_seat_address'))
														<span class="help-block">
															<strong>{{ $errors->first('operative_seat_address') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('operative_seat_zip') ? ' has-error ' : '' }}">
												{!! Form::label('operative_seat_zip', trans('titles.operative-seat-zip'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('operative_seat_zip', $user->company_data ? $user->company_data->operative_seat_zip : '', array('id' => 'operative_seat_zip', 'class' => 'form-control', 'placeholder' => 'Sede operativa - CAP','required' => 'required')) !!}
													</div>
													@if ($errors->has('operative_seat_zip'))
														<span class="help-block">
															<strong>{{ $errors->first('operative_seat_zip') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('operative_seat_city') ? ' has-error ' : '' }}">
												{!! Form::label('operative_seat_city', trans('titles.operative-seat-city'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('operative_seat_city', $user->company_data ? $user->company_data->operative_seat_city : '', array('id' => 'operative_seat_city', 'class' => 'form-control', 'placeholder' => 'Sede operativa - Citt??','required' => 'required')) !!}
													</div>
													@if ($errors->has('operative_seat_city'))
														<span class="help-block">
															<strong>{{ $errors->first('operative_seat_city') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('operative_seat_region') ? ' has-error ' : '' }}">
												{!! Form::label('operative_seat_region', trans('titles.operative-seat-region'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::select('operative_seat_region', ['Abruzzo' => 'Abruzzo', 'Basilicata' => 'Basilicata', 'Calabria' => 'Calabria', 'Campania' => 'Campania', 'Emilia-Romagna' => 'Emilia-Romagna', 'Friuli Venezia Giulia' => 'Friuli Venezia Giulia', 'Lazio' => 'Lazio', 'Liguria' => 'Liguria', 'Lombardia' => 'Lombardia', 'Marche' => 'Marche', 'Molise' => 'Molise', 'Piemonte' => 'Piemonte', 'Puglia' => 'Puglia', 'Sardegna' => 'Sardegna', 'Sicilia' => 'Sicilia', 'Toscana' => 'Toscana'], $user->company_data ? $user->company_data->operative_seat_region : '', array('id' => 'operative_seat_region', 'class' => 'custom-select')) !!}
														<div class="input-group-append">
															<label for="operative_seat_region" class="input-group-text">
																<i class="fa fa-fw {{ trans('forms.create_user_icon_place_region') }}" aria-hidden="true"></i>
															</label>
														</div>
													</div>
													@if ($errors->has('operative_seat_region'))
														<span class="help-block">
															<strong>{{ $errors->first('operative_seat_region') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('vat') ? ' has-error ' : '' }}">
												{!! Form::label('vat', trans('titles.vat'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('vat', $user->company_data ? $user->company_data->vat : '', array('id' => 'vat', 'class' => 'form-control', 'placeholder' => 'Partita IVA','required' => 'required')) !!}
													</div>
													@if ($errors->has('vat'))
														<span class="help-block">
															<strong>{{ $errors->first('vat') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('tax_unique_code') ? ' has-error ' : '' }}">
												{!! Form::label('tax_unique_code', trans('titles.tax-unique-code'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('tax_unique_code', $user->company_data ? $user->company_data->tax_unique_code : '', array('id' => 'tax_unique_code', 'class' => 'form-control', 'placeholder' => 'Codice unico destinatario','required' => 'required')) !!}
													</div>
													@if ($errors->has('tax_unique_code'))
														<span class="help-block">
															<strong>{{ $errors->first('tax_unique_code') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('vat_percent') ? ' has-error ' : '' }}">
												{!! Form::label('vat_percent', trans('titles.vat-percent'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::number('vat_percent', $user->company_data ? $user->company_data->vat_percent : 0, array('id' => 'vat_percent', 'class' => 'form-control', 'placeholder' => 'Percentuale IVA','required' => 'required','min' => 0, 'step' => 0.01)) !!}
													</div>
													@if ($errors->has('vat_percent'))
														<span class="help-block">
															<strong>{{ $errors->first('vat_percent') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('witholding_tax_percent') ? ' has-error ' : '' }}">
												{!! Form::label('witholding_tax_percent', trans('titles.witholding-tax-percent'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::number('witholding_tax_percent', $user->company_data ? $user->company_data->witholding_tax_percent : 0, array('id' => 'witholding_tax_percent', 'class' => 'form-control', 'placeholder' => "Percentuale ritenuta d'acconto",'required' => 'required','min' => 0, 'step' => 0.01)) !!}
													</div>
													@if ($errors->has('witholding_tax_percent'))
														<span class="help-block">
															<strong>{{ $errors->first('witholding_tax_percent') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('pec') ? ' has-error ' : '' }}">
												{!! Form::label('pec', trans('titles.pec'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::email('pec', $user->company_data ? $user->company_data->pec : '', array('id' => 'pec', 'class' => 'form-control', 'placeholder' => 'PEC','required' => 'required')) !!}
													</div>
													@if ($errors->has('pec'))
														<span class="help-block">
															<strong>{{ $errors->first('pec') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('email') ? ' has-error ' : '' }}">
												{!! Form::label('email', trans('titles.email'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::email('company_email', $user->company_data ? $user->company_data->email : '', array('id' => 'email', 'class' => 'form-control', 'placeholder' => 'Email','required' => 'required')) !!}
													</div>
													@if ($errors->has('email'))
														<span class="help-block">
															<strong>{{ $errors->first('email') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('phone') ? ' has-error ' : '' }}">
												{!! Form::label('phone', trans('titles.phone'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('phone', $user->company_data ? $user->company_data->phone : '', array('id' => 'phone', 'class' => 'form-control', 'placeholder' => 'Telefono fisso','required' => 'required')) !!}
													</div>
													@if ($errors->has('phone'))
														<span class="help-block">
															<strong>{{ $errors->first('phone') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('mobile') ? ' has-error ' : '' }}">
												{!! Form::label('mobile', trans('titles.mobile'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('company_mobile', $user->company_data ? $user->company_data->mobile : '', array('id' => 'mobile', 'class' => 'form-control', 'placeholder' => 'Cellulare','required' => 'required')) !!}
													</div>
													@if ($errors->has('mobile'))
														<span class="help-block">
															<strong>{{ $errors->first('mobile') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('referent_name') ? ' has-error ' : '' }}">
												{!! Form::label('referent_name', trans('titles.referent-name'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('referent_name', $user->company_data ? $user->company_data->referent_name : '', array('id' => 'referent_name', 'class' => 'form-control', 'placeholder' => 'Nome referente','required' => 'required')) !!}
													</div>
													@if ($errors->has('referent_name'))
														<span class="help-block">
															<strong>{{ $errors->first('referent_name') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('referent_surname') ? ' has-error ' : '' }}">
												{!! Form::label('referent_surname', trans('titles.referent-surname'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('referent_surname', $user->company_data ? $user->company_data->referent_surname : '', array('id' => 'referent_surname', 'class' => 'form-control', 'placeholder' => 'Cognome referente','required' => 'required')) !!}
													</div>
													@if ($errors->has('referent_surname'))
														<span class="help-block">
															<strong>{{ $errors->first('referent_surname') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('referent_mobile') ? ' has-error ' : '' }}">
												{!! Form::label('referent_mobile', trans('titles.referent-mobile'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('referent_mobile', $user->company_data ? $user->company_data->referent_mobile : '', array('id' => 'referent_mobile', 'class' => 'form-control', 'placeholder' => 'Cellulare referente')) !!}
													</div>
													@if ($errors->has('referent_mobile'))
														<span class="help-block">
															<strong>{{ $errors->first('referent_mobile') }}</strong>
														</span>
													@endif
												</div>
											</div>

											<div class="form-group has-feedback row {{ $errors->has('shop_sign') ? ' has-error ' : '' }}">
												{!! Form::label('shop_sign', trans('titles.shop-sign'), array('class' => 'col-md-3 control-label')); !!}
												<div class="col-md-9">
													<div class="input-group">
														{!! Form::text('shop_sign', $user->company_data ? $user->company_data->shop_sign : '', array('id' => 'shop_sign', 'class' => 'form-control', 'placeholder' => 'Insegna negozio')) !!}
													</div>
													@if ($errors->has('shop_sign'))
														<span class="help-block">
															<strong>{{ $errors->first('shop_sign') }}</strong>
														</span>
													@endif
												</div>
											</div>
										</li>
										@endif
									</ul>
								</div>
							</div>
                            <div class="row">
                                <div class="col-12 col-sm-6 mb-2">
                                    <a href="#" class="btn btn-outline-secondary btn-block btn-change-pw mt-3" title="{{ trans('forms.change-pw')}} ">
                                        <i class="fa fa-fw fa-lock" aria-hidden="true"></i>
                                        <span></span> {!! trans('forms.change-pw') !!}
                                    </a>
                                </div>
                                <div class="col-12 col-sm-6">
                                    {!! Form::button(trans('forms.save-changes'), array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('modals.edit_user__modal_text_confirm_title'), 'data-message' => trans('modals.edit_user__modal_text_confirm_message'))) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-save')
    @include('modals.modal-delete')

@endsection

@section('javascript')
  @include('scripts.delete-modal-script')
  @include('scripts.save-modal-script')
  @include('scripts.check-changed')
  <script>
	function copy_values(e){
		e.preventDefault();
		address = $("#legal_seat_address").val();
		$("#operative_seat_address").val(address);
		zip = $("#legal_seat_zip").val();
		$("#operative_seat_zip").val(zip);
		city = $("#legal_seat_city").val();
		$("#operative_seat_city").val(city);
		region = $("#legal_seat_region").val();
		$("#operative_seat_region").val(region);
	}

    $('#role').val() == 'user' ? $('#hideIfRolePointSelected').hide() : $('#hideIfRolePointSelected').show();

	$('#role').change(() => {
	    $('#role').val() == 'user' ? $('#hideIfRolePointSelected').hide() : $('#hideIfRolePointSelected').show();
    });
  </script>
@endsection
