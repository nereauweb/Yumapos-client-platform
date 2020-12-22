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
                            <h4>{{ trans('titles.i-phone-number') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
						{!! Form::open(array('route' => ['users.services.preview.category',$category->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}

							{!! csrf_field() !!}
									<div class="">
										<div class="uk-form-controls uk-grid-collapse" uk-grid>
											<div class="uk-width-auto">
												<label class="uk-form-label">{{ trans('titles.filter') }} <small> *{{ trans('titles.optional') }}</small></label>
												<input id="search" class="uk-input form-control" type="text" placeholder="Filter by country name">
											</div>
											<div class="uk-width-expand">
												<label class="uk-form-label">{{trans('titles.p-n')}}. <small>({{ trans('titles.s-c-code') }})</small> <small style="color:white;">*{{ trans('titles.required') }}</small></label>
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

<script src="/intltelinput/js/intlTelInput.js"></script>
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
	iti._bindDropdownListeners = function() {
                    var _this9 = this;
                    // when mouse over a list item, just highlight that one
                    // we add the class "highlight", so if they hit "enter" we know which one to select
                    this._handleMouseoverCountryList = function(e) {
                        // handle event delegation, as we're listening for this event on the countryList
                        var listItem = _this9._getClosestListItem(e.target);
                        if (listItem) _this9._highlightListItem(listItem, false);
                    };
                    this.countryList.addEventListener("mouseover", this._handleMouseoverCountryList);
                    // listen for country selection
                    this._handleClickCountryList = function(e) {
                        var listItem = _this9._getClosestListItem(e.target);
                        if (listItem) _this9._selectListItem(listItem);
                    };
                    this.countryList.addEventListener("click", this._handleClickCountryList);
                    // click off to close
                    // (except when this initial opening click is bubbling up)
                    // we cannot just stopPropagation as it may be needed to close another instance
                    var isOpening = true;
					/*
                    this._handleClickOffToClose = function() {
                        if (!isOpening) _this9._closeDropdown();
                        isOpening = false;
                    };
                    document.documentElement.addEventListener("click", this._handleClickOffToClose);
					*/
                    // listen for up/down scrolling, enter to select, or letters to jump to country name.
                    // use keydown as keypress doesn't fire for non-char keys and we want to catch if they
                    // just hit down and hold it to scroll down (no keyup event).
                    // listen on the document because that's where key events are triggered if no input has focus
                    var query = "";
                    var queryTimer = null;
                    this._handleKeydownOnDropdown = function(e) {
                        // prevent down key from scrolling the whole page,
                        // and enter key from submitting a form etc
                        e.preventDefault();
                        // up and down to navigate
                        if (e.key === "ArrowUp" || e.key === "Up" || e.key === "ArrowDown" || e.key === "Down") _this9._handleUpDownKey(e.key); else if (e.key === "Enter") _this9._handleEnterKey(); else if (e.key === "Escape") _this9._closeDropdown(); else if (/^[a-zA-ZÀ-ÿа-яА-Я ]$/.test(e.key)) {
                            // jump to countries that start with the query string
                            if (queryTimer) clearTimeout(queryTimer);
                            query += e.key.toLowerCase();
                            _this9._searchForCountry(query);
                            // if the timer hits 1 second, reset the query
                            queryTimer = setTimeout(function() {
                                query = "";
                            }, 1e3);
                        }
                    };
                    document.addEventListener("keydown", this._handleKeydownOnDropdown);
                };
	iti._showDropdown();
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
	//$(".iti__selected-flag > .iti__flag").click();
});
</script>

@endsection
