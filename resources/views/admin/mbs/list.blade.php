@extends('dashboard.base')

@section('css')
@endsection

@section('content')
	
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
				<td>
					<div class="btn-group btn-group-xs">
						<button type="button" class="btn btn-table-action dropdown-toggle" data-toggle="dropdown">
							{{$product->Prodotto}}
							<i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
							<span class="sr-only">
								{{ trans('titles.actions') }}
							</span>
						</button>
						<div class="dropdown-menu dropdown-menu-right">
							<div class="uk-width-small">
								<a class="btn btn-info edit dropdown-item" href="#" onclick="edit({{ $product->id }})">
									<svg class="c-icon">
										<use
											xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-description">
										</use>
									</svg>
									<span>{{trans('titles.edit')}}<span>
								</a>
							</div>
						</div>
					</div>
				</td>			
				<td>{{$product->Operatore}}</td>
				<td>{{$product->Tipo}}</td>
				<td>{{$product->SottoTipo}}</td>
				<td>{{$product->Descrizione}}</td>
				<td>{{$product->PrezzoUtente}}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	
	<div id="edit-modal" uk-modal></div>
	
	<div class="modal fade modal-success modal-save" id="confirmSave" role="dialog" aria-labelledby="confirmSaveLabel" aria-hidden="true" tabindex="-1">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">
						{!! trans('modals.edit_user__modal_text_confirm_title') !!}
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">close</span>
					</button>
				</div>
				<div class="modal-body">
					<p>
						{!! trans('modals.confirm_modal_title_text') !!}
					</p>
				</div>
				<div class="modal-footer">
					{!! Form::button('<i class="fa fa-fw '.trans('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . trans('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-outline pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
					{!! Form::button('<i class="fa fa-fw '.trans('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> ' . trans('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-success pull-right btn-flat', 'type' => 'button', 'id' => 'confirm' )) !!}
				</div>
			</div>
		</div>
	</div>

@endsection

@section('javascript')
	<script type="text/javascript">
		// CONFIRMATION SAVE MODEL
		$('#confirmSave').on('show.coreui.modal', function (e) {
			var message = $(e.relatedTarget).attr('data-message');
			var title = $(e.relatedTarget).attr('data-title');
			var formData = $(e.relatedTarget).closest('form').serialize();			
			var formAction = $(e.relatedTarget).closest('form').attr('action');
			$(this).find('.modal-body p').text(message);
			$(this).find('.modal-title').text(title);
			$(this).find('.modal-footer #confirm').data('formData', formData);
			$(this).find('.modal-footer #confirm').data('formAction', formAction);
		});
		$('#confirmSave').find('.modal-footer #confirm').on('click', function(){
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				type: 'POST',
				url: $(this).data('formAction'),
				data: $(this).data('formData')
			}).done(function(response) {
				$("#modal-submit-response").html('<div class="alert alert-success" role="alert">Done!</div>');
				$('#confirmSave').modal('hide');
			});
		});

	</script>
	<script>	
		function edit(operatorID) {
			event.preventDefault();
			$('#edit-modal').load('/admin/service/mbs/'+operatorID+'/edit #content');
			UIkit.modal('#edit-modal').show();
		}
	</script>
@endsection