<?php

namespace App\Http\Controllers;

use App\Models\AgentOperation;
use App\Models\ServiceOperation;

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
