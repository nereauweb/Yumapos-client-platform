@extends('dashboard.base')

@section('css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
				<div class="uk-modal-dialog uk-modal-body" id="content">
					<button class="uk-modal-close-default" type="button" uk-close></button>
					<h2 class="uk-text-secondary">{{ $operator->Name }} | Configuration</h2>
					<div class="uk-margin-small-top" id="modal-submit-response"></div>

					@if($operator->products)

						{!! Form::open(array('route' => ['admin.ding.update', $operator->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}

						{!! csrf_field() !!}

						<div uk-overflow-auto>

						@foreach ($operator->ordered_products() as $product)

							@if($product->type()=="RANGE")
									<table class="table light">
										<thead>
											<tr>
												<th>{{ trans('titles.user-group') }}</th>
												<th>% {{ trans('titles.fx-variation') }}</th>
												<th>% {{ trans('titles.discount') }}</th>
												<th>{{ trans('titles.enabled') }}</th>
											</tr>
										</thead>
										<tbody>
										@foreach($groups as $group)
											@php
												$configuration = $operator->configurations->where('group_id', $group->id)->first();
											@endphp
											<tr>
												<td>
													{{ $group->name }} {{ $group->id }}
												</td>
												<td>
													<input name="group[{{$group->id}}][fx_delta]" type="number" class="form-control form-control-sm form-control-dark range_rate_input" step="0.01" value="{{ $configuration ? $configuration->fx_delta_percent : 0 }}" data-group-id="{{$group->id}}" data-original-rate="{{ $product->fx_rate() }}">
													<input id="ranged_rate_{{$group->id}}_final" type="text" class="form-control form-control-sm uk-dark" readonly value="{{ $configuration ? $product->fx_rate() - $product->fx_rate() * $configuration->fx_delta_percent / 100 : $product->fx_rate() }}">
												</td>
												<td>
													<input name="group[{{$group->id}}][discount]" type="number" class="form-control form-control-sm form-control-dark" step="0.01" value="{{ $configuration ? $configuration->discount_percent : 0 }}">
												</td>
												<td>
													<select name="group[{{$group->id}}][enabled]" class="form-control form-control-sm form-control-dark is-visible">
														<option value="1" {{ $configuration&&$configuration->enabled==1 ? 'selected' : '' }}>{{ trans('titles.yes') }}</option>
														<option value="0" {{ $configuration&&$configuration->enabled==0 ? 'selected' : '' }}>{{ trans('titles.no') }}</option>
													</select>
												</td>
											</tr>
										@endforeach
										</tbody>
									</table>
							@elseif($product->type()=="FIXED")
									<table class="table light">
										<thead>
											<tr>
												<th>{{ trans('titles.enabled') }}</th>
												@foreach($groups as $group)
													@php
														$configuration = $operator->configurations->where('group_id', $group->id)->first();
													@endphp
													<th>
														{{ $group->name }}<br>
														<select name="group[{{$group->id}}][enabled]" class="form-control form-control-sm form-control-dark is-visible">
															<option value="1" {{ $configuration&&$configuration->enabled==1 ? 'selected' : '' }}>{{ trans('titles.yes') }}</option>
															<option value="0" {{ $configuration&&$configuration->enabled==0 ? 'selected' : '' }}>{{ trans('titles.no') }}</option>
														</select>
													</th>
												@endforeach
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><strong>{{round($product->minimum->SendValue,3)}}&nbsp;€</strong><br><small>{{round($product->minimum->ReceiveValue,3)}} {{ $product->minimum->ReceiveCurrencyIso }}&nbsp;{{$product->destinationCurrencySymbol}}</td>
												@foreach($groups as $group)
													@php
														$configuration = $operator->configurations->where('group_id', $group->id)->first();
														if ($configuration) {
															$amount_configuration = $configuration->amounts->where('original_amount',$product->minimum->SendValue)->first();
														}
													@endphp
													<td>
														{{ trans('titles.amount') }} €
														<input name="group[{{$group->id}}][{{$product->minimum->SendValue}}][amount]" type="number" class="form-control form-control-sm form-control-dark" step="0.01" value="{{ isset($amount_configuration)&&$amount_configuration ? $amount_configuration->final_amount : 0 }}">
														{{ trans('titles.discount') }} %
														<input name="group[{{$group->id}}][{{$product->minimum->SendValue}}][discount]" type="number" class="form-control form-control-sm form-control-dark" step="0.01" value="{{ isset($amount_configuration)&&$amount_configuration ? $amount_configuration->discount : 0 }}">
														{{ trans('titles.visible') }}
														<select name="group[{{$group->id}}][{{$product->minimum->SendValue}}][visible]" class="form-control form-control-sm form-control-dark is-visible">
															<option value="1" {{ isset($amount_configuration)&&$amount_configuration&&$amount_configuration->visible==1 ? 'selected' : '' }}>{{ trans('titles.yes') }}</option>
															<option value="0" {{ isset($amount_configuration)&&$amount_configuration&&$amount_configuration->visible==0 ? 'selected' : '' }}>{{ trans('titles.no') }}</option>
														</select>
													</td>
												@endforeach
											</tr>
										</tbody>
									</table>
							@else
								- Error: denomination type "{{$product->type()}}" not recognized
							@endif

						@endforeach
								</div>
						@if($operator->products_type()=="FIXED")
								<div class="uk-width-1-1 uk-flex uk-flex-center uk-margin-top">
									<div>
										<a class="uk-button" id="all-visible">{{ trans('titles.all-visible') }}</a>
										<a class="uk-button" id="none-visible">{{ trans('titles.none-visible') }}</a>
									</div>
								</div>
						@endif
						@if($operator->products_type()=="RANGE"||$operator->products_type()=="FIXED")
							{!! Form::button(trans('forms.save-changes'), array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('modals.edit_user__modal_text_confirm_title'), 'data-message' => trans('modals.edit_user__modal_text_confirm_message'))) !!}
						@endif
						{!! Form::close() !!}

					@endif
				</div>
			</div>
		</div>
	</div>

@endsection

@section('javascript')
@endsection
