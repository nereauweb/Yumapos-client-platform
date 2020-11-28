@extends('dashboard.base')

@section('css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
				<div class="uk-modal-dialog uk-modal-body" id="content">
					<button class="uk-modal-close-default" type="button" uk-close></button>
					<h2 class="uk-text-secondary">{{ $operation->id }} | Details</h2>
					<dl class="row light">
					
						<dt class="col-sm-5">Provider</dt>
						<dd class="col-sm-7">{{ $operation->provider }}</dd>
					
						<dt class="col-sm-5">Service operation ID</dt>
						<dd class="col-sm-7">{{ $operation->id }}</dd>
					
						<dt class="col-sm-5">Provider operation ID</dt>
						<dd class="col-sm-7">{{ $operation->api_ding_operation_id }}</dd>
					
						<dt class="col-sm-5">System call ID</dt>
						<dd class="col-sm-7"></dd>
						
					</dl>
				</div>	
			</div>
		</div>
	</div>

@endsection

@section('javascript')
@endsection