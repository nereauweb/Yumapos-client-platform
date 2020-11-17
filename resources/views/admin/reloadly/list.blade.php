@extends('dashboard.base')

@section('css')
@endsection

@section('content')

	@livewireStyles()
	@livewire('reloadly-operators')
	@livewireScripts()
    	
	<div id="details-modal" uk-modal></div>
	<div id="edit-modal" uk-modal></div>
	<div id="edit-local-modal" uk-modal></div>
	
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
		function details(operatorID) {
			event.preventDefault();
			$('#details-modal').load('/admin/service/reloadly/'+operatorID+' #content');
			UIkit.modal('#details-modal').show();
		}
		function edit(operatorID) {
			event.preventDefault();
			$('#edit-modal').load('/admin/service/reloadly/'+operatorID+'/edit #content');
			UIkit.modal('#edit-modal').show();
		}
		function editLocal(operatorID) {
			event.preventDefault();
			$('#edit-modal').load('/admin/service/reloadly/'+operatorID+'/edit/local #content');
			UIkit.modal('#edit-local-modal').show();
		}		
	</script>
	<script>
		$(document).ready(function(){
			$(document).on('change','.range_rate_input',function(e){
				var groupId = $(this).data("group-id");
				var originalRate = $(this).data("original-rate");
				var percentDelta = $(this).val();
				var finalRate = originalRate - (originalRate * percentDelta / 100)
				$("#ranged_rate_"+groupId+"_final").val(finalRate);
			});
		});
	</script>
	<script>
		$(document).on('click','#all-visible',function(){
			$('.is-visible').val(1);
		});
		$(document).on('click','#none-visible',function(){
			$('.is-visible').val(0);
		});
	</script>
@endsection