@extends('dashboard.base')

@section('content')

@php
$countryArray = array(
	'AD'=>array('name'=>'ANDORRA','code'=>'376'),
	'AE'=>array('name'=>'UNITED ARAB EMIRATES','code'=>'971'),
	'AF'=>array('name'=>'AFGHANISTAN','code'=>'93'),
	'AG'=>array('name'=>'ANTIGUA AND BARBUDA','code'=>'1268'),
	'AI'=>array('name'=>'ANGUILLA','code'=>'1264'),
	'AL'=>array('name'=>'ALBANIA','code'=>'355'),
	'AM'=>array('name'=>'ARMENIA','code'=>'374'),
	'AN'=>array('name'=>'NETHERLANDS ANTILLES','code'=>'599'),
	'AO'=>array('name'=>'ANGOLA','code'=>'244'),
	'AQ'=>array('name'=>'ANTARCTICA','code'=>'672'),
	'AR'=>array('name'=>'ARGENTINA','code'=>'54'),
	'AS'=>array('name'=>'AMERICAN SAMOA','code'=>'1684'),
	'AT'=>array('name'=>'AUSTRIA','code'=>'43'),
	'AU'=>array('name'=>'AUSTRALIA','code'=>'61'),
	'AW'=>array('name'=>'ARUBA','code'=>'297'),
	'AZ'=>array('name'=>'AZERBAIJAN','code'=>'994'),
	'BA'=>array('name'=>'BOSNIA AND HERZEGOVINA','code'=>'387'),
	'BB'=>array('name'=>'BARBADOS','code'=>'1246'),
	'BD'=>array('name'=>'BANGLADESH','code'=>'880'),
	'BE'=>array('name'=>'BELGIUM','code'=>'32'),
	'BF'=>array('name'=>'BURKINA FASO','code'=>'226'),
	'BG'=>array('name'=>'BULGARIA','code'=>'359'),
	'BH'=>array('name'=>'BAHRAIN','code'=>'973'),
	'BI'=>array('name'=>'BURUNDI','code'=>'257'),
	'BJ'=>array('name'=>'BENIN','code'=>'229'),
	'BL'=>array('name'=>'SAINT BARTHELEMY','code'=>'590'),
	'BM'=>array('name'=>'BERMUDA','code'=>'1441'),
	'BN'=>array('name'=>'BRUNEI DARUSSALAM','code'=>'673'),
	'BO'=>array('name'=>'BOLIVIA','code'=>'591'),
	'BR'=>array('name'=>'BRAZIL','code'=>'55'),
	'BS'=>array('name'=>'BAHAMAS','code'=>'1242'),
	'BT'=>array('name'=>'BHUTAN','code'=>'975'),
	'BW'=>array('name'=>'BOTSWANA','code'=>'267'),
	'BY'=>array('name'=>'BELARUS','code'=>'375'),
	'BZ'=>array('name'=>'BELIZE','code'=>'501'),
	'CA'=>array('name'=>'CANADA','code'=>'1'),
	'CC'=>array('name'=>'COCOS (KEELING) ISLANDS','code'=>'61'),
	'CD'=>array('name'=>'CONGO, THE DEMOCRATIC REPUBLIC OF THE','code'=>'243'),
	'CF'=>array('name'=>'CENTRAL AFRICAN REPUBLIC','code'=>'236'),
	'CG'=>array('name'=>'CONGO','code'=>'242'),
	'CH'=>array('name'=>'SWITZERLAND','code'=>'41'),
	'CI'=>array('name'=>'COTE D IVOIRE','code'=>'225'),
	'CK'=>array('name'=>'COOK ISLANDS','code'=>'682'),
	'CL'=>array('name'=>'CHILE','code'=>'56'),
	'CM'=>array('name'=>'CAMEROON','code'=>'237'),
	'CN'=>array('name'=>'CHINA','code'=>'86'),
	'CO'=>array('name'=>'COLOMBIA','code'=>'57'),
	'CR'=>array('name'=>'COSTA RICA','code'=>'506'),
	'CU'=>array('name'=>'CUBA','code'=>'53'),
	'CV'=>array('name'=>'CAPE VERDE','code'=>'238'),
	'CX'=>array('name'=>'CHRISTMAS ISLAND','code'=>'61'),
	'CY'=>array('name'=>'CYPRUS','code'=>'357'),
	'CZ'=>array('name'=>'CZECH REPUBLIC','code'=>'420'),
	'DE'=>array('name'=>'GERMANY','code'=>'49'),
	'DJ'=>array('name'=>'DJIBOUTI','code'=>'253'),
	'DK'=>array('name'=>'DENMARK','code'=>'45'),
	'DM'=>array('name'=>'DOMINICA','code'=>'1767'),
	'DO'=>array('name'=>'DOMINICAN REPUBLIC','code'=>'1809'),
	'DZ'=>array('name'=>'ALGERIA','code'=>'213'),
	'EC'=>array('name'=>'ECUADOR','code'=>'593'),
	'EE'=>array('name'=>'ESTONIA','code'=>'372'),
	'EG'=>array('name'=>'EGYPT','code'=>'20'),
	'ER'=>array('name'=>'ERITREA','code'=>'291'),
	'ES'=>array('name'=>'SPAIN','code'=>'34'),
	'ET'=>array('name'=>'ETHIOPIA','code'=>'251'),
	'FI'=>array('name'=>'FINLAND','code'=>'358'),
	'FJ'=>array('name'=>'FIJI','code'=>'679'),
	'FK'=>array('name'=>'FALKLAND ISLANDS (MALVINAS)','code'=>'500'),
	'FM'=>array('name'=>'MICRONESIA, FEDERATED STATES OF','code'=>'691'),
	'FO'=>array('name'=>'FAROE ISLANDS','code'=>'298'),
	'FR'=>array('name'=>'FRANCE','code'=>'33'),
	'GA'=>array('name'=>'GABON','code'=>'241'),
	'GB'=>array('name'=>'UNITED KINGDOM','code'=>'44'),
	'GD'=>array('name'=>'GRENADA','code'=>'1473'),
	'GE'=>array('name'=>'GEORGIA','code'=>'995'),
	'GH'=>array('name'=>'GHANA','code'=>'233'),
	'GI'=>array('name'=>'GIBRALTAR','code'=>'350'),
	'GL'=>array('name'=>'GREENLAND','code'=>'299'),
	'GM'=>array('name'=>'GAMBIA','code'=>'220'),
	'GN'=>array('name'=>'GUINEA','code'=>'224'),
	'GQ'=>array('name'=>'EQUATORIAL GUINEA','code'=>'240'),
	'GR'=>array('name'=>'GREECE','code'=>'30'),
	'GT'=>array('name'=>'GUATEMALA','code'=>'502'),
	'GU'=>array('name'=>'GUAM','code'=>'1671'),
	'GW'=>array('name'=>'GUINEA-BISSAU','code'=>'245'),
	'GY'=>array('name'=>'GUYANA','code'=>'592'),
	'HK'=>array('name'=>'HONG KONG','code'=>'852'),
	'HN'=>array('name'=>'HONDURAS','code'=>'504'),
	'HR'=>array('name'=>'CROATIA','code'=>'385'),
	'HT'=>array('name'=>'HAITI','code'=>'509'),
	'HU'=>array('name'=>'HUNGARY','code'=>'36'),
	'ID'=>array('name'=>'INDONESIA','code'=>'62'),
	'IE'=>array('name'=>'IRELAND','code'=>'353'),
	'IL'=>array('name'=>'ISRAEL','code'=>'972'),
	'IM'=>array('name'=>'ISLE OF MAN','code'=>'44'),
	'IN'=>array('name'=>'INDIA','code'=>'91'),
	'IQ'=>array('name'=>'IRAQ','code'=>'964'),
	'IR'=>array('name'=>'IRAN, ISLAMIC REPUBLIC OF','code'=>'98'),
	'IS'=>array('name'=>'ICELAND','code'=>'354'),
	'IT'=>array('name'=>'ITALY','code'=>'39'),
	'JM'=>array('name'=>'JAMAICA','code'=>'1876'),
	'JO'=>array('name'=>'JORDAN','code'=>'962'),
	'JP'=>array('name'=>'JAPAN','code'=>'81'),
	'KE'=>array('name'=>'KENYA','code'=>'254'),
	'KG'=>array('name'=>'KYRGYZSTAN','code'=>'996'),
	'KH'=>array('name'=>'CAMBODIA','code'=>'855'),
	'KI'=>array('name'=>'KIRIBATI','code'=>'686'),
	'KM'=>array('name'=>'COMOROS','code'=>'269'),
	'KN'=>array('name'=>'SAINT KITTS AND NEVIS','code'=>'1869'),
	'KP'=>array('name'=>'KOREA DEMOCRATIC PEOPLES REPUBLIC OF','code'=>'850'),
	'KR'=>array('name'=>'KOREA REPUBLIC OF','code'=>'82'),
	'KW'=>array('name'=>'KUWAIT','code'=>'965'),
	'KY'=>array('name'=>'CAYMAN ISLANDS','code'=>'1345'),
	'KZ'=>array('name'=>'KAZAKSTAN','code'=>'7'),
	'LA'=>array('name'=>'LAO PEOPLES DEMOCRATIC REPUBLIC','code'=>'856'),
	'LB'=>array('name'=>'LEBANON','code'=>'961'),
	'LC'=>array('name'=>'SAINT LUCIA','code'=>'1758'),
	'LI'=>array('name'=>'LIECHTENSTEIN','code'=>'423'),
	'LK'=>array('name'=>'SRI LANKA','code'=>'94'),
	'LR'=>array('name'=>'LIBERIA','code'=>'231'),
	'LS'=>array('name'=>'LESOTHO','code'=>'266'),
	'LT'=>array('name'=>'LITHUANIA','code'=>'370'),
	'LU'=>array('name'=>'LUXEMBOURG','code'=>'352'),
	'LV'=>array('name'=>'LATVIA','code'=>'371'),
	'LY'=>array('name'=>'LIBYAN ARAB JAMAHIRIYA','code'=>'218'),
	'MA'=>array('name'=>'MOROCCO','code'=>'212'),
	'MC'=>array('name'=>'MONACO','code'=>'377'),
	'MD'=>array('name'=>'MOLDOVA, REPUBLIC OF','code'=>'373'),
	'ME'=>array('name'=>'MONTENEGRO','code'=>'382'),
	'MF'=>array('name'=>'SAINT MARTIN','code'=>'1599'),
	'MG'=>array('name'=>'MADAGASCAR','code'=>'261'),
	'MH'=>array('name'=>'MARSHALL ISLANDS','code'=>'692'),
	'MK'=>array('name'=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF','code'=>'389'),
	'ML'=>array('name'=>'MALI','code'=>'223'),
	'MM'=>array('name'=>'MYANMAR','code'=>'95'),
	'MN'=>array('name'=>'MONGOLIA','code'=>'976'),
	'MO'=>array('name'=>'MACAU','code'=>'853'),
	'MP'=>array('name'=>'NORTHERN MARIANA ISLANDS','code'=>'1670'),
	'MR'=>array('name'=>'MAURITANIA','code'=>'222'),
	'MS'=>array('name'=>'MONTSERRAT','code'=>'1664'),
	'MT'=>array('name'=>'MALTA','code'=>'356'),
	'MU'=>array('name'=>'MAURITIUS','code'=>'230'),
	'MV'=>array('name'=>'MALDIVES','code'=>'960'),
	'MW'=>array('name'=>'MALAWI','code'=>'265'),
	'MX'=>array('name'=>'MEXICO','code'=>'52'),
	'MY'=>array('name'=>'MALAYSIA','code'=>'60'),
	'MZ'=>array('name'=>'MOZAMBIQUE','code'=>'258'),
	'NA'=>array('name'=>'NAMIBIA','code'=>'264'),
	'NC'=>array('name'=>'NEW CALEDONIA','code'=>'687'),
	'NE'=>array('name'=>'NIGER','code'=>'227'),
	'NG'=>array('name'=>'NIGERIA','code'=>'234'),
	'NI'=>array('name'=>'NICARAGUA','code'=>'505'),
	'NL'=>array('name'=>'NETHERLANDS','code'=>'31'),
	'NO'=>array('name'=>'NORWAY','code'=>'47'),
	'NP'=>array('name'=>'NEPAL','code'=>'977'),
	'NR'=>array('name'=>'NAURU','code'=>'674'),
	'NU'=>array('name'=>'NIUE','code'=>'683'),
	'NZ'=>array('name'=>'NEW ZEALAND','code'=>'64'),
	'OM'=>array('name'=>'OMAN','code'=>'968'),
	'PA'=>array('name'=>'PANAMA','code'=>'507'),
	'PE'=>array('name'=>'PERU','code'=>'51'),
	'PF'=>array('name'=>'FRENCH POLYNESIA','code'=>'689'),
	'PG'=>array('name'=>'PAPUA NEW GUINEA','code'=>'675'),
	'PH'=>array('name'=>'PHILIPPINES','code'=>'63'),
	'PK'=>array('name'=>'PAKISTAN','code'=>'92'),
	'PL'=>array('name'=>'POLAND','code'=>'48'),
	'PM'=>array('name'=>'SAINT PIERRE AND MIQUELON','code'=>'508'),
	'PN'=>array('name'=>'PITCAIRN','code'=>'870'),
	'PR'=>array('name'=>'PUERTO RICO','code'=>'1'),
	'PT'=>array('name'=>'PORTUGAL','code'=>'351'),
	'PW'=>array('name'=>'PALAU','code'=>'680'),
	'PY'=>array('name'=>'PARAGUAY','code'=>'595'),
	'QA'=>array('name'=>'QATAR','code'=>'974'),
	'RO'=>array('name'=>'ROMANIA','code'=>'40'),
	'RS'=>array('name'=>'SERBIA','code'=>'381'),
	'RU'=>array('name'=>'RUSSIAN FEDERATION','code'=>'7'),
	'RW'=>array('name'=>'RWANDA','code'=>'250'),
	'SA'=>array('name'=>'SAUDI ARABIA','code'=>'966'),
	'SB'=>array('name'=>'SOLOMON ISLANDS','code'=>'677'),
	'SC'=>array('name'=>'SEYCHELLES','code'=>'248'),
	'SD'=>array('name'=>'SUDAN','code'=>'249'),
	'SE'=>array('name'=>'SWEDEN','code'=>'46'),
	'SG'=>array('name'=>'SINGAPORE','code'=>'65'),
	'SH'=>array('name'=>'SAINT HELENA','code'=>'290'),
	'SI'=>array('name'=>'SLOVENIA','code'=>'386'),
	'SK'=>array('name'=>'SLOVAKIA','code'=>'421'),
	'SL'=>array('name'=>'SIERRA LEONE','code'=>'232'),
	'SM'=>array('name'=>'SAN MARINO','code'=>'378'),
	'SN'=>array('name'=>'SENEGAL','code'=>'221'),
	'SO'=>array('name'=>'SOMALIA','code'=>'252'),
	'SR'=>array('name'=>'SURINAME','code'=>'597'),
	'ST'=>array('name'=>'SAO TOME AND PRINCIPE','code'=>'239'),
	'SV'=>array('name'=>'EL SALVADOR','code'=>'503'),
	'SY'=>array('name'=>'SYRIAN ARAB REPUBLIC','code'=>'963'),
	'SZ'=>array('name'=>'SWAZILAND','code'=>'268'),
	'TC'=>array('name'=>'TURKS AND CAICOS ISLANDS','code'=>'1649'),
	'TD'=>array('name'=>'CHAD','code'=>'235'),
	'TG'=>array('name'=>'TOGO','code'=>'228'),
	'TH'=>array('name'=>'THAILAND','code'=>'66'),
	'TJ'=>array('name'=>'TAJIKISTAN','code'=>'992'),
	'TK'=>array('name'=>'TOKELAU','code'=>'690'),
	'TL'=>array('name'=>'TIMOR-LESTE','code'=>'670'),
	'TM'=>array('name'=>'TURKMENISTAN','code'=>'993'),
	'TN'=>array('name'=>'TUNISIA','code'=>'216'),
	'TO'=>array('name'=>'TONGA','code'=>'676'),
	'TR'=>array('name'=>'TURKEY','code'=>'90'),
	'TT'=>array('name'=>'TRINIDAD AND TOBAGO','code'=>'1868'),
	'TV'=>array('name'=>'TUVALU','code'=>'688'),
	'TW'=>array('name'=>'TAIWAN, PROVINCE OF CHINA','code'=>'886'),
	'TZ'=>array('name'=>'TANZANIA, UNITED REPUBLIC OF','code'=>'255'),
	'UA'=>array('name'=>'UKRAINE','code'=>'380'),
	'UG'=>array('name'=>'UGANDA','code'=>'256'),
	'US'=>array('name'=>'UNITED STATES','code'=>'1'),
	'UY'=>array('name'=>'URUGUAY','code'=>'598'),
	'UZ'=>array('name'=>'UZBEKISTAN','code'=>'998'),
	'VA'=>array('name'=>'HOLY SEE (VATICAN CITY STATE)','code'=>'39'),
	'VC'=>array('name'=>'SAINT VINCENT AND THE GRENADINES','code'=>'1784'),
	'VE'=>array('name'=>'VENEZUELA','code'=>'58'),
	'VG'=>array('name'=>'VIRGIN ISLANDS, BRITISH','code'=>'1284'),
	'VI'=>array('name'=>'VIRGIN ISLANDS, U.S.','code'=>'1340'),
	'VN'=>array('name'=>'VIET NAM','code'=>'84'),
	'VU'=>array('name'=>'VANUATU','code'=>'678'),
	'WF'=>array('name'=>'WALLIS AND FUTUNA','code'=>'681'),
	'WS'=>array('name'=>'SAMOA','code'=>'685'),
	'XK'=>array('name'=>'KOSOVO','code'=>'381'),
	'YE'=>array('name'=>'YEMEN','code'=>'967'),
	'YT'=>array('name'=>'MAYOTTE','code'=>'262'),
	'ZA'=>array('name'=>'SOUTH AFRICA','code'=>'27'),
	'ZM'=>array('name'=>'ZAMBIA','code'=>'260'),
	'ZW'=>array('name'=>'ZIMBABWE','code'=>'263')
);
@endphp

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3>Selected operator</h3>
                        </div>
                    </div>
                    <div class="card-body">
						@if(!Auth::user()->group_id||Auth::user()->group_id==0)
							
							Your account is not configured and therefore you cannot proceed to finalize operation, please contact administration to fix this issue.
						
						@elseif(isset($data['message']))
						
							{{ $data['message'] }}
							
						@elseif($operator && is_object($operator))
							
							<h2 class="text-white">{{ $operator->name }} <img src="{{ $operator->logoUrls->first()->url }}"></h2>
							
							{!! Form::open(array('route' => 'users.services.transaction', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation form-horizontal')) !!}
								{!! csrf_field() !!}
								@if(isset($phone_number))
								<h3 class="text-white">{{ $phone_number }}</h3>	
								<input type="hidden" name="recipient_phone" id="recipient_phone" value="{{ $phone_number }}">
								@else
									<div class="uk-margin-bottom">
										<label class="uk-form-label uk-dark">Phone n. <small>(without country code)</small> <small style="color:white;">*required</small></label>
										<div class="uk-form-controls">
											<input name="number" id="number" class="uk-input form-control" type="tel" required>
											<input type="hidden" name="recipient_phone" id="recipient_phone" value="">
										</div>
									</div>
								@endif
								@if($operator->denominationType=="FIXED")
									@php
										$configuration = $operator->configurations->where('group_id', Auth::user()->group_id)->first();
									@endphp
									<div class="form-group row uk-margin-top">
										<div class="col-md-3 col-form-label">
											Choose amount
										</div>
										<div class="col-md-9 col-form-label">
										@foreach($operator->fixedAmounts as $index => $element)
											@php
												$user_amount = round($element->amount,2);												
												if ($configuration&&$configuration->amounts){
													$amount_configuration = $configuration->amounts->where('original_amount',$element->amount)->first();
													if($amount_configuration && $amount_configuration->visible==0){
														continue;
													}
												}
												if(isset($amount_configuration)&&$amount_configuration&&$amount_configuration->final_amount != 0){
													$user_amount = round($amount_configuration->final_amount,2);
												}
												$fxrate = $operator->config_rate(Auth::user()->group_id);
											@endphp
											<div class="form-check">
												<input 
													class="form-check-input amounts" 
													id="radio{{$index}}" 
													type="radio" 
													value="{{$element->amount}}" 
													name="amount" 
													data-amount="{{ $user_amount }}"
													data-local="0"
													data-local-amount="{{ $element->amount * $fxrate}}"
													data-fxrate="{{ $fxrate }}"
													required >
												<label class="form-check-label" for="radio{{$index}}">{{ $user_amount }} €</label>
											</div>											
										@endforeach
										@if($configuration&&$operator->localFixedAmounts->count()>0&&$configuration->local_amounts)
											@foreach($operator->localFixedAmounts as $index => $element)
												@php
													$amount_configuration = $configuration->local_amounts->where('original_amount',$element->amount)->first();
													if(!isset($amount_configuration) || !$amount_configuration || $amount_configuration->visible==0 || $amount_configuration->final_amount == 0){
														continue;
													}
													$user_amount = round($amount_configuration->final_amount,2);
												@endphp
												<div class="form-check">
													<input 
														class="form-check-input amounts" 
														id="radio{{$index}}" 
														type="radio" 
														value="{{$element->amount}}" 
														name="amount" 
														data-local="1"
														data-amount="{{ $user_amount }}"
														data-fxrate="{{ $operator->config_rate(Auth::user()->group_id) }}"
														data-local-amount="{{ $element->amount }}"
														required >
													<label class="form-check-label" for="radio{{$index}}">{{ round($element->amount,2) }} {{ $operator->destinationCurrencySymbol }}</label>
												</div>											
											@endforeach
										@endif
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-form-label" for="text-input">Gain €</label>
										<div class="col-md-9">
											<input class="form-control" id="gain" type="number" name="gain" value="" step="0.01" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-form-label" for="text-input">Final €</label>
										<div class="col-md-9">
											<input class="form-control" id="final_amount" type="text" name="final_amount" value="" step="0.01" readonly>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-form-label" for="text-input">Expected charge {{ $operator->destinationCurrencySymbol }}</label>
										<div class="col-md-9">
											<input class="form-control" id="final_amount_destination" type="text" name="final_amount_destination" value="" step="0.01" readonly>
										</div>
									</div>
					
									{!! Form::button('Finalize', array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => 'Confirm submit', 'data-message' => 'Please confirm operation to continue')) !!}
												
								@elseif($operator->denominationType=="RANGE")
								
									<div class="form-group row">
										<label class="col-md-3 col-form-label" for="text-input">Amount €</label>
										<div class="col-md-9">
											<input 
												class="form-control" 
												id="amount" 
												type="number" 
												name="amount"
												value="" 
												step="0.01"
												{{ $operator->minAmount ? 'min="'.$operator->minAmount.'"' : '' }}
												{{ $operator->maxAmount ? 'max="'.$operator->maxAmount.'"' : '' }}
												data-fxrate="{{ round($operator->config_rate(Auth::user()->group_id),3) }}"
												data-local="0" 
												required >
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-form-label" for="text-input">Gain €</label>
										<div class="col-md-9">
											<input class="form-control" id="gain" type="number" name="gain" value="" step="0.01" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-form-label" for="text-input">Final €</label>
										<div class="col-md-9">
											<input class="form-control" id="final_amount" type="text" name="final_amount" value="" step="0.01" readonly>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 col-form-label" for="text-input">Expected charge {{ $operator->destinationCurrencySymbol }}</label>
										<div class="col-md-9">
											<input class="form-control" id="final_amount_destination" type="number" name="final_amount_destination" value="" step="0.01">
										</div>
									</div>
					
									{!! Form::button('Finalize', array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => 'Confirm submit', 'data-message' => 'Please confirm operation to continue')) !!}
							
								@else
									
									We are sorry, an error occurred in operator data.
									
								@endif
								
								<input type="hidden" name="operator_id" value="{{ $operator->operatorId }}">
								<input type="hidden" name="country_iso" value="{{ $operator->country->isoName }}">
								<input type="hidden" name="local" id="local" value="0">
								
							{!! Form::close() !!}
							
						@else
							
							We are sorry, an error occurred.
						
						@endif
                    </div>
					
					{{--
                    <div class="card-body">
						Log: {!! $log !!}
						<pre>{!! var_dump($data) !!}</pre>
						<pre>{!! var_dump($operator) !!}</pre>
                    </div>
					--}}
					
                </div>
            </div>
        </div>
    </div>
	
	@include('modals.modal-save')

@endsection

@section('javascript')
	@if($operator && is_object($operator))
		@include('scripts.save-modal-script')
		<script>
			var gain_percent = {{ Auth::user()->configuration ? Auth::user()->configuration->default_gain : 0 }};
			var amount = 0.00;
			var gain = 0.00;
			var final_amount = 0.00;
			var fxRate = 0.00;
			var final_amount_destination = 0.00;
			var local = 0;
			@if($operator->denominationType=="FIXED")
				$(".amounts").click(function(){
					local = $(this).data("local");
					if (local==1){
						final_amount_destination = parseFloat($(this).val());
					}
					$("#local").val(local);
					amount = parseFloat($(this).data("amount"));
					fxRate = parseFloat($(this).data("fxrate"));
					gain = (gain_percent/100) * amount;
					gain = gain;
					$("#gain").val(gain.toFixed(2));
					final_amount = amount + gain;
					final_amount_destination = parseFloat($(this).data("local-amount"));
					$("#final_amount").val(final_amount.toFixed(2));
					$("#final_amount_destination").val(final_amount_destination.toFixed(2));
				});
				$("#gain").change(function(){
					if( !$("#gain").val() ) {
						$("#gain").val() = 0;
						gain = 0;
					} else {
						gain = parseFloat($("#gain").val());
					}
					final_amount = amount + gain;
					$("#final_amount").val(final_amount.toFixed(2))
				});
			@else
				
				$("#amount").change(function(){
					amount = parseFloat($(this).val());
					gain = (gain_percent/100) * amount;
					$("#gain").val(gain.toFixed(2));
					fxRate = parseFloat($(this).data("fxrate"));
					calc_final();
				});
				$("#gain").change(function(){
					if(amount>0){
						calc_final();
					}
				});
				function calc_final () {
					if( !$("#gain").val() ) {
						$("#gain").val() = 0;
						gain = 0;
					}
					gain = parseFloat($("#gain").val());
					final_amount = amount + gain;
					if (local == 0){
						final_amount_destination = amount * fxRate ;				
					}
					$("#final_amount").val(final_amount.toFixed(2));
					$("#final_amount_destination").val(final_amount_destination.toFixed(2));
				}
				
				$("#final_amount_destination").change(function(){
					fxRate = parseFloat($("#amount").data("fxrate"));
					final_amount_destination = parseFloat($(this).val());
					amount = final_amount_destination / fxRate;
					$("#amount").val(amount.toFixed(2))		
					gain = (gain_percent/100) * amount;
					$("#gain").val(gain.toFixed(2));
					final_amount = amount + gain;
					$("#final_amount").val(final_amount.toFixed(2));
				});
			@endif
		</script>
		@if(!isset($phone_number))
			<script>
				$("#number").change(function(){
					if ($("#number").val()=='') {
						$("#recipient_phone").val('');
					} else {
						var fullNumber = "+{{$countryArray[$operator->country->isoName]['code']}}" + $("#number").val();
						$("#recipient_phone").val(fullNumber);
					}
					//console.log($("#recipient_phone").val());
				});
			</script>
		@endif
	@endif
@endsection