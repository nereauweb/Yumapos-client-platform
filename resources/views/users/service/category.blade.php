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
                            <h3>{{ $category->name }}</h3>
                            <h4>Input phone number</h4>
                        </div>
                    </div>
                    <div class="card-body">
						{!! Form::open(array('route' => ['users.services.preview.category',$category->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}

							{!! csrf_field() !!}
									<div class="">
										<div class="uk-form-controls uk-grid-collapse" uk-grid>
											<div class="uk-width-auto">
												<label class="uk-form-label">Filter <small> *optional</small></label>
												<input id="search" class="uk-input form-control" type="text" placeholder="Filter by country name">
											</div>
											<div class="uk-width-expand">
												<label class="uk-form-label">Phone n. <small>(select country code)</small> <small style="color:white;">*required</small></label>
												<input name="number" id="phone" class="uk-input form-control" type="tel" required>
												<input name="prefix" id="prefix" type="hidden" required>
												<input name="country" id="country" type="hidden" required>
											</div>
										</div>
									</div>
							{!! Form::button('Search', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
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
		separateDialCode: true,
		@if($category->country_list_type=='include')
			onlyCountries: [
				@foreach($category->countries as $country)
					"{{ $country->iso }}",
				@endforeach
			],
		@elseif(($category->country_list_type=='exclude')) 
			excludeCountries: [
				@foreach($category->countries as $country)
					"{{ $country->iso }}",
				@endforeach
			],
		@endif
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
	var country = iti.getSelectedCountryData();
	$("#country").val(country['iso2']);
	$("#prefix").val(country['dialCode']);
	function ucwords (str) {
		return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
			return $1.toUpperCase();
		});
	}
	$(".iti__selected-flag > .iti__flag").click();
});
</script>

@endsection
