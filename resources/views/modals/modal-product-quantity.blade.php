<div class="modal fade" id="quantityForm" role="dialog" aria-labelledby="confirmFormLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	{!! Form::open(array('route' => 'admin.shop.products.quantities.update', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
      <div class="modal-header">
        <h4 class="modal-title">
          {{ trans('modals.modify-qty') }}
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="form-group has-feedback row {{ $errors->has('quantity') ? ' has-error ' : '' }}">
			{!! Form::label('quantity', trans('modals.qty'), array('class' => 'col-md-3 control-label')); !!}
			<div class="col-md-9">
				<div class="input-group">
					{!! Form::number('quantity', NULL, array('id' => 'quantity-modal-qnt', 'class' => 'form-control', 'placeholder' => 'Prezzo', 'min' => 0, 'step' => '1')) !!}
					<input type="hidden" name="id" value="" id="quantity-modal-id">
				</div>
				@if ($errors->has('quantity'))
					<span class="help-block">
						<strong>{{ $errors->first('quantity') }}</strong>
					</span>
				@endif
			</div>
		</div>
      <div class="modal-footer">
        {!! Form::button('<i class="fa fa-fw fa-close" aria-hidden="true"></i> ' . trans('modals.form_modal_default_btn_cancel'), array('class' => 'btn btn-secondary', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
        {!! Form::button('<i class="fa fa-fw fa-check" aria-hidden="true"></i> ' . trans('modals.form_modal_default_btn_submit'), array('class' => 'btn btn-primary', 'type' => 'submit' )) !!}
      </div>
    </div>
	{!! Form::close() !!}
  </div>
</div>
</div>
