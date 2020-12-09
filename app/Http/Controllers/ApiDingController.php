<?php

namespace App\Http\Controllers;

use App\Http\Ding\Model\InternationalDialingInfo;
use App\Models\AgentOperation;
use App\Models\ApiDingCall;
use App\Models\ApiDingCountry;
use App\Models\ApiDingCountryInternationalDialingInformation;
use App\Models\ApiDingCountryRegionCode;
use App\Models\ApiDingCurrency;
use App\Models\ApiDingOperation;
use App\Models\ApiDingOperator;
use App\Models\ApiDingOperatorPaymentType;
use App\Models\ApiDingOperatorRegionCode;
use App\Models\ApiDingOperatorState;
use App\Models\ApiDingPaymentType;
use App\Models\ApiDingProduct;
use App\Models\ApiDingProductBenefit;
use App\Models\ApiDingProductMaximum;
use App\Models\ApiDingProductMinimum;
use App\Models\ApiDingRegion;
use App\Models\ApiDingSettingDefinition;
use App\Models\ServiceOperation;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiDingController extends Controller
{
	private $token = '';
	private $test = false;

	public $log = '';
	public $call_id = 0;

	private $ding = null;

	private static $dingStatic = null;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|user|sales');

        $this->ding = new \App\Http\Ding\Api\V1Api();
        self::$dingStatic = $this->ding;
    }

	public function index(Request $request)
	{
		return view('admin/api/ding/command-list');
	}

    public static function get_cache_balance_static(){
        try{
            $result = self::$dingStatic->getBalance();
            if (isset($result['balance'])){
                $ding_balance_cache = Cache::get('ding_cache_balance');
                $ding_balance_cache[date('w')] = $result['balance'];
                Cache::forever('ding_cache_balance', $ding_balance_cache);
                return response()->json($result['balance'], 200);
            }
            return 'error';
        } catch (Exception $ex){
            $result = $ex->getMessage();
            return 'error';
        }
    }

	public function ErrorCodeDescriptions(Request $request)
	{
		$request_description = 'Error code descriptions';
		try{
			$result = $this->ding->GetErrorCodeDescriptions();
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	public function Currencies(Request $request)
	{
		$request_description = 'Currencies';
		try{
			$result = $this->ding->GetCurrencies();
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	public function Currencies_save(Request $request)
	{
		$request_description = 'Currencies save';
		$result = "Currencies saved:<br><ol>";
		try{
			$data = $this->ding->GetCurrencies();
			$index = 0;
			foreach ($data->getItems() as $item){
				$index ++;
				$currency_data = $item->getData();
				$currency = ApiDingCurrency::updateOrCreate(
					[
						'CurrencyIso' 			=> $currency_data['currency_iso'],
					],
					[
						'CurrencyName' 			=> $currency_data['currency_name'],
					]
				);
				$result.= "<li> $currency_data[currency_iso] $currency_data[currency_name]</li>";
			}
			$result.= "</ol><br>Total: " . $index;
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	public function Regions(Request $request)
	{
		$request_description = 'Regions';
		try{
			$result = $this->ding->GetRegions();
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	public function Regions_save(Request $request)
	{
		$request_description = 'Regions save';
		$result = "Regions saved:<br><ol>";
		try{
			$data = $this->ding->GetRegions();
			$index = 0;
			foreach ($data->getItems() as $item){
				$index ++;
				$region_data = $item->getData();

				$region = ApiDingRegion::updateOrCreate(
					[
						'RegionCode' 			=> $region_data['region_code'],
					],
					[
						'RegionName' 			=> $region_data['region_name'],
						'CountryIso' 			=> $region_data['country_iso'],
					]
				);
				$result.= "<li> $region_data[region_code] $region_data[region_name]</li>";
			}
			$result.= "</ol><br>Total: " . $index;
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	public function Countries(Request $request)
	{
		$request_description = 'Countries';
		try{
			$result = $this->ding->GetCountries();
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	public function Countries_save(Request $request)
	{
		$request_description = 'Countries save';
		$result = "Countries saved:<br><ol>";
		try{
			$data = $this->ding->GetCountries();
			$index = 0;
			foreach ($data->getItems() as $item){
				$index ++;
				$country_data = $item->getData();
				$country = ApiDingCountry::updateOrCreate(
					[
						'CountryIso' 			=> $country_data['country_iso'],
					],
					[
						'CountryName' 			=> $country_data['country_name'],
					]
				);
				$country->region_codes()->delete();
				if (!empty($country_data['region_codes'])){
					foreach ($country_data['region_codes'] as $region_code) {
						$country->region_codes()->create(['RegionCode' => $region_code]);
					}
				}
				$country->int_dial_infos()->delete();
				if (!empty($country_data['international_dialing_information'])){
					foreach ($country_data['international_dialing_information'] as $int_dial_info) {
						$int_dial_info_data = $int_dial_info->getData();
						$country->int_dial_infos()->create([
							'Prefix' => $int_dial_info_data['prefix'],
							'MinimumLength' => $int_dial_info_data['minimum_length'],
							'MaximumLength' => $int_dial_info_data['maximum_length'],
						]);
					}
				}
				$result.= "<li> $country_data[country_iso] $country_data[country_name]</li>";
			}
			$result.= "</ol><br>Total: " . $index;
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	protected $fillable = [
		'CountryIso',
		'CountryName',
		];

	public function int_dial_infos(){
		return $this->hasMany('App\Models\ApiDingCountryInternationalDialingInformation','CountryIso','CountryIso');
	}

	public function region_codes(){ return $this->hasMany('App\Models\ApiDingCountryRegionCode','CountryIso','CountryIso'); }

	public function Providers(Request $request)
	{
		$request_description = 'Providers';
		try{
			$result = $this->ding->GetProviders();
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	public function Providers_save(Request $request)
	{
		$request_description = 'Providers save';
		$result = "Providers saved:<br><ol>";
		try{
			$data = $this->ding->GetProviders();
			$index = 0;
			foreach ($data->getItems() as $item){
				$index ++;
				$provider_data = $item->getData();
				$provider = ApiDingOperator::updateOrCreate(
					[
						'ProviderCode' 			=> $provider_data['provider_code'],
					],
					[
						'CountryIso' 			=> $provider_data['country_iso'],
						'Name' 					=> $provider_data['name'],
						'ShortName' 			=> $provider_data['short_name'],
						'ValidationRegex' 		=> $provider_data['validation_regex'],
						'CustomerCareNumber'	=> $provider_data['customer_care_number'],
						'LogoUrl' 				=> $provider_data['logo_url'],
					]
				);
				$provider->region_codes()->delete();
				if (!empty($provider_data['region_codes'])){
					foreach ($provider_data['region_codes'] as $region_code) {
						$provider->region_codes()->create(['RegionCode' => $region_code]);
					}
				}
				$provider->payment_types()->delete();
				if (!empty($provider_data['payment_types'])){
					foreach ($provider_data['payment_types'] as $payment_type) {
						$provider->payment_types()->create(['payment_type' => $payment_type]);
					}
				}
				$result.= "<li> $provider_data[provider_code] $provider_data[name]</li>";
			}
			$result.= "</ol><br>Total: " . $index;
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	public function ProviderStatus(Request $request)
	{
		$request_description = 'Providers status';
		try{
			$result = $this->ding->GetProviderStatus();
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	public function Products(Request $request)
	{
		$request_description = 'Products';
		try{
			$result = $this->ding->GetProducts(null,'ORSN');
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	public function Products_save(Request $request)
	{
		$request_description = 'Providers save';
		$result = "Products saved:<br><ol>";
		ApiDingProduct::truncate();
		try{
			$data = $this->ding->GetProducts();
			$index = 0;
			foreach ($data->getItems() as $item){
				$index ++;
				$product_data = $item->getData();
				$product = ApiDingProduct::updateOrCreate(
					[
						'SkuCode'	 			=> $product_data['sku_code'],
					],
					[
						'ProviderCode' 			=> $product_data['provider_code'],
						'LocalizationKey' 		=> $product_data['localization_key'],
						'CommissionRate' 		=> $product_data['commission_rate'],
						'ProcessingMode' 		=> $product_data['processing_mode'],
						'RedemptionMechanism'	=> $product_data['redemption_mechanism'],
						'ValidityPeriodIso' 	=> $product_data['validity_period_iso'],
						'UatNumber' 			=> $product_data['uat_number'],
						'AdditionalInformation' => $product_data['additional_information'],
						'DefaultDisplayText' 	=> $product_data['default_display_text'],
						'RegionCode' 			=> $product_data['region_code'],
						'LookupBillsRequired' 	=> $product_data['lookup_bills_required'],
					]
				);
				$product->setting_definitions()->delete();
				if (!empty($product_data['setting_definitions'])){
					foreach ($product_data['setting_definitions'] as $setting_definition) {
						$product->setting_definitions()->create([
							'Name' => $setting_definition['name'],
							'Description' => $setting_definition['description'],
							'IsMandatory' => $setting_definition['is_mandatory'],
						]);
					}
				}
				$product->maximum()->delete();
				if (!empty($product_data['maximum'])){
						$product->maximum()->create([
							'CustomerFee' 				=> $product_data['maximum']['customer_fee'],
							'DistributorFee' 			=> $product_data['maximum']['distributor_fee'],
							'ReceiveValue' 				=> $product_data['maximum']['receive_value'],
							'ReceiveCurrencyIso' 		=> $product_data['maximum']['receive_currency_iso'],
							'ReceiveValueExcludingTax' 	=> $product_data['maximum']['receive_value_excluding_tax'],
							'TaxRate' 					=> $product_data['maximum']['tax_rate'],
							'TaxName' 					=> $product_data['maximum']['tax_name'],
							'TaxCalculation' 			=> $product_data['maximum']['tax_calculation'],
							'SendValue' 				=> $product_data['maximum']['send_value'],
							'SendCurrencyIso' 			=> $product_data['maximum']['send_currency_iso'],
						]);
				}
				$product->minimum()->delete();
				if (!empty($product_data['minimum'])){
						$product->minimum()->create([
							'CustomerFee' 				=> $product_data['minimum']['customer_fee'],
							'DistributorFee' 			=> $product_data['minimum']['distributor_fee'],
							'ReceiveValue' 				=> $product_data['minimum']['receive_value'],
							'ReceiveCurrencyIso' 		=> $product_data['minimum']['receive_currency_iso'],
							'ReceiveValueExcludingTax' 	=> $product_data['minimum']['receive_value_excluding_tax'],
							'TaxRate' 					=> $product_data['minimum']['tax_rate'],
							'TaxName' 					=> $product_data['minimum']['tax_name'],
							'TaxCalculation' 			=> $product_data['minimum']['tax_calculation'],
							'SendValue' 				=> $product_data['minimum']['send_value'],
							'SendCurrencyIso' 			=> $product_data['minimum']['send_currency_iso'],
						]);
				}
				$product->benefits()->delete();
				if (!empty($product_data['benefits'])){
					foreach ($product_data['benefits'] as $benefit) {
						$product->benefits()->create(['benefit' => $benefit]);
					}
				}
				$product->payment_types()->delete();
				if (!empty($product_data['payment_types'])){
					foreach ($product_data['payment_types'] as $payment_type) {
						$product->payment_types()->create(['payment_type' => $payment_type]);
					}
				}
				$result.= "<li> $product_data[sku_code]  $product_data[default_display_text] Provider $product_data[provider_code]";
				$result.= "</li>";
			}
			$result.= "</ol><br>Total: " . $index;
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	public function ProductDescriptions(Request $request)
	{
		$request_description = 'Products descriptions';
		try{
			$result = $this->ding->GetProductDescriptions(['en']);
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	public function Balance(Request $request)
	{
		$request_description = 'Balance';
		try{
			$result = $this->ding->getBalance();
			if (isset($result['balance'])){
				if (Cache::has('ding_cache_balance_'.date('w'))) {
					Cache::forget('ding_cache_balance_'.date('w'));
				}
				Cache::forever('ding_cache_balance_'.date('w'), $result['balance']);
			}
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	public function get_cache_balance(){
        try{
			$result = $this->ding->getBalance();
			if (isset($result['balance'])){
				$ding_balance_cache = Cache::get('ding_cache_balance');
				$ding_balance_cache[date('w')] = $result['balance'];
				Cache::forever('ding_cache_balance', $ding_balance_cache);

				return response()->json($result['balance'], 200);
			}
			return 'error';
		} catch (Exception $ex){
			$result = $ex->getMessage();
			return 'error';
		}
	}

	public function Promotions(Request $request)
	{
		$request_description = 'Promotions';
		try{
			$result = $this->ding->GetPromotions();
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	public function PromotionDescriptions(Request $request)
	{
		$request_description = 'Promotion descriptions';
		try{
			$result = $this->ding->GetPromotionDescriptions(['en']);
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	public function AccountLookup(Request $request)
	{
		$request_description = 'Account lookup';
		try{
			$result = $this->ding->GetAccountLookup($request->input("number"));
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	public function SendTransfer(Request $request)
	{
		$data = $request->input('data');
		$request_description = 'Send Transfer';
		try{
			$result = $this->ding->SendTransfer([
				'SkuCode' => $data['sku_code'],
				'SendValue' => $data['sku_code'],
				'SendCurrencyIso' => $data['send_currency_iso'],
				'AccountNumber' => $data['account_number'],
				'DistributorRef' => $data['distributor_ref'],
				'Settings' => [
					'Name' => $data['name'],
					'Value' => $data['value'],
				],
				'ValidateOnly' => $this->test ? 'true' : 'false',
				'BillRef' => $data['bill_ref'],
			]);
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));
	}

	public function user_recharge(Request $request)
	{
		$request_data = $request->session()->get('request_data');

		if (empty($request_data)) { return redirect()->route('users.reports.operations'); }

		$request_product_sku 				= $request_data['request_product_sku'];
		$request_local 						= $request_data['request_local'];
		$request_send_currency_iso			= 'EUR';
		$request_operator_ProviderCode 		= $request_data['request_operator_ProviderCode'];
		$request_amount 					= $request_data['request_amount'];
		$request_country_iso 				= $request_data['request_country_iso'];
		$request_recipient_phone 			= $request_data['request_recipient_phone'];
		$user_gain 							= $request_data['user_gain'];
		$final_amount 						= $request_data['final_amount'];
		$final_expected_destination_amount 	= $request_data['final_expected_destination_amount'];
		$internalRef						= Auth::user()->id .'.'. time();
		$category_id 						= $request_data['category_id'];

		$operator = ApiDingOperator::where('ProviderCode',$request_operator_ProviderCode)->first();
		//$original_expected_destination_amount = $request_amount * $operator->fx->rate;

		$configuration = $operator->configuration(Auth::user()->group_id);

		$user_amount = $final_amount - $user_gain;

		if ($operator->products_type()=="FIXED"){
			if($request_local==1){
				$sent_amount = $user_amount; // temporary, to be overwritten before saving
				if ($configuration) {
					$config_amount = $configuration->local_amount($request_amount);
					$user_discount = $config_amount && $config_amount->discount > 0 ? round(($config_amount->discount/100)*$config_amount->final_amount,2) : 0;
					$platform_gain = 0;
				} else {
					$user_discount = 0;
					$platform_gain = 0;
				}
			} else {
				$sent_amount = $request_amount;
				if ($configuration) {
					$config_amount = $configuration->amount($request_amount);
					$user_discount = $config_amount && $config_amount->discount > 0 ? round(($config_amount->discount/100)*$request_amount,2) : 0;
					$platform_gain = $config_amount && $config_amount->final_amount > 0 ? $config_amount->final_amount - $config_amount->original_amount : 0;
				} else {
					$user_discount = 0;
					$platform_gain = 0;
				}
			}
		}
		if ($operator->products_type()=="RANGE"){
			$product = ApiDingProduct::where("SkuCode", $request_data['request_product_sku'])->first();
			if (!$product){
				$response['result'] = -1;
				$response['message'] = 'Processing error, could not find related product data.';
				return view('users/service/result', ['response' => $response]);
			}
			$user_discount = $configuration ? round(($configuration->discount_percent/100) * $request_amount,3) : 0;
			$sent_amount = round($final_expected_destination_amount / $product->fx_rate(),3);
			$platform_gain = $request_amount - $sent_amount;
		}

		$user_total_gain = $user_discount + $user_gain;

		$response = [
			'provider' => 'ding',
			'user_id' => Auth::user()->id,
			'request_product_sku' => $request_product_sku,
			'request_ProviderCode' => $request_operator_ProviderCode,
			'request_amount' => $request_amount,
			'request_local' => $request_local,
			'request_country_iso' => $request_country_iso,
			'request_recipient_phone' => $request_recipient_phone,
			//'original_expected_destination_amount' => $original_expected_destination_amount,
			'final_expected_destination_amount' => $final_expected_destination_amount,
			'user_discount' => $user_discount,
			'user_amount' => $user_amount,
			'sent_amount' => $sent_amount,
			'platform_gain' => $platform_gain,
			'user_gain' => $user_gain,
			'final_amount' => $final_amount,
			'user_total_gain' => $user_total_gain,
		];

		if(Auth::user()->plafond - $user_amount < Auth::user()->debt_limit){
			$response['result'] = -1;
			$response['message'] = 'Insufficient balance, please add credit to your balance to finalize operation or contact administration.';
			return view('users/service/result', ['response' => $response]);
		}

		$call = ApiDingCall::create([
			'user_id' 		=> Auth::user()->id,
			'type' 			=> 'POST',
			'path' 			=> '/api/V1/SendTransfer',
			'parameters' 	=> "'SkuCode' => $request_product_sku,
				'SendValue' => $sent_amount,
				'SendCurrencyIso' => $request_send_currency_iso,
				'AccountNumber' => ".str_replace('+','',$request_recipient_phone).",
				'DistributorRef' => $internalRef,
				'ValidateOnly' => ". $this->test ? 'true' : 'false'
		]);

		$response['api_ding_call_id'] = $call->id;

		try{
			$data = $this->ding->SendTransfer([
				'SkuCode' => $request_product_sku,
				'SendValue' => $sent_amount,
				'SendCurrencyIso' => $request_send_currency_iso,
				'AccountNumber' => str_replace('+','',$request_recipient_phone),
				'DistributorRef' => $internalRef,
				'ValidateOnly' => $this->test ? 'true' : 'false',
				/*
				'Settings' => [
					'Name' => $data['name'],
					'Value' => $data['value'],
				],
				*/
			]);
		} catch (\App\Http\Ding\ApiException $ex){
			$data['request'] = [
				'SkuCode' => $request_product_sku,
				'SendValue' => $request_amount,
				'SendCurrencyIso' => $request_send_currency_iso,
				'AccountNumber' => $request_recipient_phone,
				'DistributorRef' => Auth::user()->id .'.'. time(),
				'ValidateOnly' => $this->test ? 'true' : 'false',
				];
			$call->raw_answer = $ex->getResponseBody();
			$call->save();
			$data['response'] = $ex->getResponseBody();
			return view('users/service/result', ['log' => $this->log, 'data' => $data, 'response' => -1, 'operator' => $operator] );
		} catch (Exception $ex){
			$data['request'] = [
				'SkuCode' => $request_product_sku,
				'SendValue' => $request_amount,
				'SendCurrencyIso' => $request_send_currency_iso,
				'AccountNumber' => $request_recipient_phone,
				'DistributorRef' => Auth::user()->id .'.'. time(),
				'ValidateOnly' => $this->test ? 'true' : 'false',
				];
			$call->raw_answer = $ex->getMessage();
			$call->save();
			$data['response'] = $ex->getMessage();
			return view('users/service/result', ['log' => $this->log, 'data' => $data, 'response' => -1, 'operator' => $operator] );
		}


		if ($data->getResultCode()==1){
			$record = $data->getTransferRecord()->getData();
			$data_builder['transfer_record'] = $record;
			$data_builder['price'] = $record['price']->getData();
			$data_builder['transfer_id'] = $record['transfer_id']->getData();
			$data = $data_builder;
			$call->raw_answer = json_encode($data_builder);
			$call->save();
		} else {
			$call->raw_answer = json_encode($data);
			$call->save();
			return view('users/service/result', ['log' => $this->log, 'data' => $data, 'response' => -1, 'operator' => $operator] );
		}

		$dingOperation = ApiDingOperation::create([
			'SkuCode' 					=> $data['transfer_record']['sku_code'],
			'CommissionApplied' 		=> $data['transfer_record']['commission_applied'],
			'StartedUtc' 				=> $data['transfer_record']['started_utc'],
			'CompletedUtc' 				=> $data['transfer_record']['completed_utc'],
			'ProcessingState' 			=> $data['transfer_record']['processing_state'],
			'ReceiptText' 				=> $data['transfer_record']['receipt_text'],
			'ReceiptParams' 			=> is_array($data['transfer_record']['receipt_params']) ? implode(',',$data['transfer_record']['receipt_params']) : $data['transfer_record']['receipt_params'],
			'AccountNumber' 			=> $data['transfer_record']['account_number'],
			'DistributorRef' 			=> $data['transfer_id']['distributor_ref'],
			'TransferRef' 				=> $data['transfer_id']['transfer_ref'],
			'SendCurrencyIso' 			=> $data['price']['send_currency_iso'],
			'CustomerFee' 				=> $data['price']['customer_fee'],
			'DistributorFee' 			=> $data['price']['distributor_fee'],
			'ReceiveValue' 				=> $data['price']['receive_value'],
			'ReceiveCurrencyIso' 		=> $data['price']['receive_currency_iso'],
			'ReceiveValueExcludingTax' 	=> $data['price']['receive_value_excluding_tax'],
			'TaxRate' 					=> $data['price']['tax_rate'],
			'TaxName' 					=> $data['price']['tax_name'],
			'TaxCalculation' 			=> $data['price']['tax_calculation'],
			'SendValue' 				=> $data['price']['send_value'],
		]);
		$response['api_ding_operation_id'] = $dingOperation->id;
		$response['ding_TransferRef'] = $dingOperation->TransferRef;

		$response['platform_commission'] = $dingOperation->CommissionApplied;
		if($request_local==1){
			$response['sent_amount'] = $dingOperation->SendValue;
			$response['platform_gain'] = $user_amount - $response['sent_amount'];
		}
		$response['platform_total_gain'] = $response['platform_gain'] + $response['platform_commission'];

		$user = Auth::user();
		$response['user_old_plafond'] = $user->plafond;
		$user_cost = $user_amount - $user_discount;
		$user->plafond = Auth::user()->plafond - $user_cost;
		$user->save();
		$response['user_new_plafond'] = $user->plafond;
		$response['result'] = 1;
		$operation = ServiceOperation::create($response);
		$response['operation_id'] = $operation->id;
		if ($user->parent_id && $user->parent_id != 0){
			$agent = User::find($user->parent_id);
			if ($agent){
				$commission = $agent->agent_commission($user->group_id,$category_id);
				if ($commission){
					if ($commission->type=='percent'){
						$agent_amount = round(($user_cost * ( $commission->amount / 100 )),2);
					} else {
						$agent_amount = $commission->amount;
					}
					AgentOperation::create([
						'user_id'				=> $agent->id,
						'service_operation_id'	=> $operation->id,
						'original_amount'		=> $user_cost,
						'applied_commission_id'	=> $commission->id,
						'commission'			=> $agent_amount,
					]);
					$operation->agent_commission = $agent_amount;
					$operation->platform_total_gain = $response['platform_total_gain'] - $agent_amount;
					$operation->save();
					$agent->credit += $agent->amount();
					$agent->save();
				}
			}
		}

		return view('users/service/result', ['log' => $this->log, 'data' => $data, 'response' => $response, 'operator' => $operator] );
	}

    public function graph_data()
    {
        $ding_balance_cache = Cache::get('ding_cache_balance');

		if (!isset($ding_balance_cache[date('w')])) {
			$ding_balance_cache[date('w')] = 0;
		}
		if (!isset($ding_balance_cache[date('w',strtotime("-1 day"))])) {
			$ding_balance_cache[date('w',strtotime("-1 day"))] = 0;
		}
		if (!isset($ding_balance_cache[date('w',strtotime("-2 day"))])) {
			$ding_balance_cache[date('w',strtotime("-2 day"))] = 0;
		}
		if (!isset($ding_balance_cache[date('w',strtotime("-3 day"))])) {
			$ding_balance_cache[date('w',strtotime("-3 day"))] = 0;
		}
		if (!isset($ding_balance_cache[date('w',strtotime("-4 day"))])) {
			$ding_balance_cache[date('w',strtotime("-4 day"))] = 0;
		}
		if (!isset($ding_balance_cache[date('w',strtotime("-5 day"))])) {
			$ding_balance_cache[date('w',strtotime("-5 day"))] = 0;
		}
		if (!isset($ding_balance_cache[date('w',strtotime("-6 day"))])) {
			$ding_balance_cache[date('w',strtotime("-6 day"))] = 0;
		}

        $return = [
            'Six days ago' => $ding_balance_cache[date('w',strtotime("-6 days"))],
            'Five days ago' => $ding_balance_cache[date('w',strtotime("-5 days"))],
            'Four days ago' => $ding_balance_cache[date('w',strtotime("-4 days"))],
            'Three days ago' => $ding_balance_cache[date('w',strtotime("-3 days"))],
            'Two days ago' => $ding_balance_cache[date('w',strtotime("-2 days"))],
            'Yesterday' => $ding_balance_cache[date('w',strtotime("-1 day"))],
            'Today' => $ding_balance_cache[date('w')],
        ];

        return response()->json(['graph_data' => $return], 200);
    }

}
