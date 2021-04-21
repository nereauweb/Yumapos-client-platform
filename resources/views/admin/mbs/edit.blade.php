@extends('dashboard.base')

@section('css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
				<div class="uk-modal-dialog uk-modal-body" id="content">
					<button class="uk-modal-close-default" type="button" uk-close></button>
					<h2>{{ $product->name }} | {{ trans('titles.configuration') }}</h2>
					<div class="uk-margin-small-top" id="modal-submit-response"></div>
					{!! Form::open(array('route' => ['admin.mbs.update', $product->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}

					{!! csrf_field() !!}

					
						<div uk-overflow-auto>
							<table class="table light">
								<thead>
									<tr>
										<th>{{ trans('titles.enabled') }}</th>
										@foreach($groups as $group)
											@php
												$configuration = $product->configurations->where('group_id', $group->id)->first();
											@endphp
											<th>
												{{ $group->name }}
											</th>
										@endforeach
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><strong>{{round($product->PrezzoUtente,3)}}&nbsp;€</strong></td>
										@foreach($groups as $group)
											@php
												$configuration = $product->configuration( $group->id);
											@endphp
											<td>
												{{ trans('titles.discount') }} %
												<input name="group[{{$group->id}}][percent]" type="number" class="form-control form-control-sm form-control-dark" step="0.01" value="{{ isset($configuration)&&$configuration ? $configuration->percent : 0 }}">
											</td>
										@endforeach
									</tr>
								</tbody>
							</table>
						</div>
						{!! Form::button(trans('forms.save-changes'), array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('modals.edit_user__modal_text_confirm_title'), 'data-message' => trans('modals.edit_user__modal_text_confirm_message'))) !!}

					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>

@endsection

@section('javascript')
@endsection
