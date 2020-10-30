@extends('dashboard.base')

@section('css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
				<div class="uk-modal-dialog uk-modal-body" id="content">
					<button class="uk-modal-close-default" type="button" uk-close></button>
					<h2>{{ $operator->name }} | Configuration</h2>					
					<div class="uk-margin-small-top" id="modal-submit-response"></div>
					{!! Form::open(array('route' => ['admin.services.update.local', $operator->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}

					{!! csrf_field() !!}
					
					@if($operator->denominationType=="FIXED"&&$operator->localFixedAmounts->count()>0)	
						<div  uk-overflow-auto>				
							<table class="table light">
								<thead>
									<tr>
										<th>Enabled</th>
										@foreach($groups as $group)
											@php
												$configuration = $operator->configurations->where('group_id', $group->id)->first();	
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
								@foreach($operator->localFixedAmounts as $element)
									<tr>
										<td>
											<strong>{{round($element->amount,3)}}&nbsp;{{$operator->destinationCurrencySymbol}}</strong><br>
											<small>FX rate {{ $operator->fx->rate }}</small><br>
											<small>Calculated amount {{ round($element->amount / $operator->fx->rate,3) }} &nbsp;&euro;</small>
										</td>
										@foreach($groups as $group)									
											@php
												$configuration = $operator->configurations->where('group_id', $group->id)->first();
												if ($configuration) {
													$amount_configuration = $configuration->local_amounts->where('original_amount',$element->amount)->first();
												}
											@endphp
											<td>
												Amount €
												<input name="group[{{$group->id}}][{{$element->amount}}][amount]" type="number" class="form-control form-control-sm form-control-dark" step="0.01" value="{{ isset($amount_configuration)&&$amount_configuration ? $amount_configuration->final_amount : 0 }}">
												Discount %
												<input name="group[{{$group->id}}][{{$element->amount}}][discount]" type="number" class="form-control form-control-sm form-control-dark" step="0.01" value="{{ isset($amount_configuration)&&$amount_configuration ? $amount_configuration->discount : 0 }}">
												Visible
												<select name="group[{{$group->id}}][{{$element->amount}}][visible]" class="form-control form-control-sm form-control-dark is-visible">
													<option value="0" {{ isset($amount_configuration)&&$amount_configuration&&$amount_configuration->visible==0 ? 'selected' : '' }}>No</option>
													<option value="1" {{ isset($amount_configuration)&&$amount_configuration&&$amount_configuration->visible==1 ? 'selected' : '' }}>Yes</option>
												</select>
											</td>
										@endforeach
									</tr>
								@endforeach
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
						- Error: denomination type "{{$operator->denominationType}}" not recognized, or no local fixed amount present. Please reload.
					@endif
					
					{!! Form::close() !!}
				</div>	
			</div>
		</div>
	</div>

@endsection

@section('javascript')
@endsection