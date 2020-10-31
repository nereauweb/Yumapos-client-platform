@extends('dashboard.base')

@section('css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
				<div class="uk-modal-dialog uk-modal-body" id="content">
					<button class="uk-modal-close-default" type="button" uk-close></button>
					<h2>{{ $product->operator->Name }} | {{ $product->SkuCode }} | Configuration</h2>					
					<div class="uk-margin-small-top" id="modal-submit-response"></div>
					{!! Form::open(array('route' => ['admin.ding.update', $product->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}

					{!! csrf_field() !!}
					
					@if($product->type()=="RANGE")
						<div  uk-overflow-auto>
							<table class="table light">
								<thead>
									<tr>
										<th>User group</th>
										<th>% FX variation</th>
										<th>% Discount</th>
										<th>Enabled</th>
									</tr>
								</thead>
								<tbody>
								@foreach($groups as $group)
									@php
										$configuration = $product->configurations->where('group_id', $group->id)->first();
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
												<option value="1" {{ $configuration&&$configuration->enabled==1 ? 'selected' : '' }}>Yes</option>
												<option value="0" {{ $configuration&&$configuration->enabled==0 ? 'selected' : '' }}>No</option>
											</select>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
						{!! Form::button(trans('forms.save-changes'), array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('modals.edit_user__modal_text_confirm_title'), 'data-message' => trans('modals.edit_user__modal_text_confirm_message'))) !!}
					@elseif($product->type()=="FIXED")
						<div uk-overflow-auto>				
							<table class="table light">
								<thead>
									<tr>
										<th>Enabled</th>
										@foreach($groups as $group)
											@php
												$configuration = $product->configurations->where('group_id', $group->id)->first();	
											@endphp
											<th>
												{{ $group->name }}<br>
												<select name="group[{{$group->id}}][enabled]" class="form-control form-control-sm form-control-dark is-visible">
													<option value="1" {{ $configuration&&$configuration->enabled==1 ? 'selected' : '' }}>Yes</option>
													<option value="0" {{ $configuration&&$configuration->enabled==0 ? 'selected' : '' }}>No</option>
												</select>												
											</th>
										@endforeach
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><strong>{{round($product->minimum->SendValue,3)}}&nbsp;€</strong><br><small>{{round($product->minimum->SendValue * $product->fx_rate(),3)}}&nbsp;{{$product->destinationCurrencySymbol}}</td>
										@foreach($groups as $group)									
											@php
												$configuration = $product->configurations->where('group_id', $group->id)->first();	
												if ($configuration) {
													$amount_configuration = $configuration->amounts->where('original_amount',$product->minimum->SendValue)->first();
												}
											@endphp
											<td>
												Amount €
												<input name="group[{{$group->id}}][{{$product->minimum->SendValue}}][amount]" type="number" class="form-control form-control-sm form-control-dark" step="0.01" value="{{ isset($amount_configuration)&&$amount_configuration ? $amount_configuration->final_amount : 0 }}">
												Discount %
												<input name="group[{{$group->id}}][{{$product->minimum->SendValue}}][discount]" type="number" class="form-control form-control-sm form-control-dark" step="0.01" value="{{ isset($amount_configuration)&&$amount_configuration ? $amount_configuration->discount : 0 }}">
												Visible
												<select name="group[{{$group->id}}][{{$product->minimum->SendValue}}][visible]" class="form-control form-control-sm form-control-dark is-visible">
													<option value="1" {{ isset($amount_configuration)&&$amount_configuration&&$amount_configuration->visible==1 ? 'selected' : '' }}>Yes</option>
													<option value="0" {{ isset($amount_configuration)&&$amount_configuration&&$amount_configuration->visible==0 ? 'selected' : '' }}>No</option>
												</select>
											</td>
										@endforeach
									</tr>
								</tbody>
							</table>
						</div>
						<div class="uk-width-1-1 uk-flex uk-flex-center uk-margin-top">
							<div>
								<a class="uk-button" id="all-visible">All visibile</a>
								<a class="uk-button" id="none-visible">None visible</a>
							</div>
						</div>
						{!! Form::button(trans('forms.save-changes'), array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('modals.edit_user__modal_text_confirm_title'), 'data-message' => trans('modals.edit_user__modal_text_confirm_message'))) !!}
					@else
						- Error: denomination type "{{$product->denominationType}}" not recognized
					@endif
					
					{!! Form::close() !!}
				</div>	
			</div>
		</div>
	</div>

@endsection

@section('javascript')
@endsection