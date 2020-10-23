<?php

namespace App\Http\Controllers;

use App\Models\AgentOperation;
use App\Models\ServiceOperation;

use App\Models\ApiDingCountry;
use App\Models\ApiDingCountryInternationalDialingInformation;
use App\Http\Ding\Model\InternationalDialingInfo;
use App\Models\ApiDingCountryRegionCode;
use App\Models\ApiDingCurrency;
use App\Models\ApiDingOperator;
use App\Models\ApiDingOperatorPaymentType;
use App\Models\ApiDingOperatorRegionCode;
use App\Models\ApiDingOperatorState;
use App\Models\ApiDingProduct;
use App\Models\ApiDingProductBenefit;
use App\Models\ApiDingProductMaximum;
use App\Models\ApiDingProductMinimum;
use App\Models\ApiDingPaymentType;
use App\Models\ApiDingSettingDefinition;
use App\Models\ApiDingRegion;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ApiDingController extends Controller
{
	
	private $token = '';
	
	public $log = '';	
	public $call_id = 0;
	
	private $ding = null;
	
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|user|sales');
		
        $this->ding = new \App\Http\Ding\Api\V1Api();
    }
	
	public function index(Request $request)
	{
		return view('admin/api/ding/command-list');	
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
			$result = $this->ding->GetProducts();
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));	
	}
	
	public function products_list(Request $request)
	{
		$request_description = 'Products';
		try{
			$result = $this->ding->GetProducts();
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/products', compact('request_description','result'));	
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
		} catch (Exception $ex){
			$result = $ex->getMessage();
		}
		return view('admin/api/ding/test', compact('request_description','result'));	
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
			$result = $this->ding->GetPromotionDescriptions();
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
    
}
