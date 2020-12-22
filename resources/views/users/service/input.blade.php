@extends('dashboard.base')

@section('css')
	<link rel="stylesheet" href="/intltelinput/css/intlTelInput.min.css">
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>{{ trans('titles.i-phone-number') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
						{!! Form::open(array('route' => 'users.services.preview', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}

							{!! csrf_field() !!}
									<div class="">
										<div class="uk-form-controls uk-grid-collapse" uk-grid>
											<div class="uk-width-auto">
												<label class="uk-form-label uk-dark">{{ trans('titles.filter') }} <small> *{{ trans('titles.optional') }}</small></label>
												<input id="search" class="uk-input form-control" type="text" placeholder="Filter by country name">
											</div>
											<div class="uk-width-expand">
												<label class="uk-form-label uk-dark">{{trans('titles.p-n')}}. <small>({{ trans('titles.s-c-code') }})</small> <small style="color:white;">*{{ trans('titles.required') }}</small></label>
												<input name="number" id="phone" class="uk-input form-control" type="tel" required>
												<input name="prefix" id="prefix" type="hidden" required>
												<input name="country" id="country" type="hidden" required>
											</div>
										</div>
									</div>
							{!! Form::button(trans('titles.search'), array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
						{!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')

<script src="/intltelinput/js/intlTelInput.min.js"></script>
<script>
$(document).ready(function(){
	var input = document.querySelector("#phone");
	var iti = window.intlTelInput(input, {
		customContainer: "uk-width-1-1",
		separateDialCode: true
	});
	input.addEventListener("countrychange", function() {
		var country = iti.getSelectedCountryData();
		$("#country").val(country['iso2']);
		$("#prefix").val(country['dialCode']);
	});
	$("#search").keyup(function () {
		var data = this.value.split(" ");
		var first = true;
		$('#iti-0__country-listbox > li').hide().filter(function() {
			var $t = $(this);
			var $d = $t.find('.iti__country-name').first();
			for (var d = 0; d < data.length; ++d) {
				if ($t.is(":contains('" + ucwords(data[d]) + "')")) {
					if(first){
						iti.setCountry($t.data('country-code'));
					}
					first = false;
					return true;
				}
			}
			return false;
		})
		.show();
	}).focus(function () {
		this.value = "";
		$(this).css({
			"color": "black"
		});
		$(this).unbind('focus');
	}).css({
		"color": "#C0C0C0"
	});
	function ucwords (str) {
		return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
			return $1.toUpperCase();
		});
	}
	$(".iti__selected-flag > .iti__flag").click();
});
</script>

@endsection
