<?php

namespace App\Http\Controllers;


use App\Models\ApiMbsProduct;

use App\Models\ServiceCategory;
use App\Models\ServiceOperator;
use App\Models\ServiceOperation;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Http\Ding\ApiException;


class PointServiceController extends Controller
{
    public function input()
    {
        return view('users/service/input' );
    }

    public function category(Request $request, $id)
    {
		if ($id==1){
			$products = ApiMbsProduct::orderBy('Operatore')->orderBy('Tipo')->orderBy('PrezzoUtente')->get();			
			$providers_ricarica = [
				"DigiMobile",
				"FastWeb",
				"Ho",
				"Iliad",
				"Kena",
				"Linkem",
				"Lyca",
				"PosteMobile",
				"Tim",
				"UnoMobile",
				"VeryMobile",
				"Vodafone",
				"Wind",
			];
			return view('users/service/mbs', compact('products','providers_ricarica'));
		}
		
		$category = ServiceCategory::findOrFail($id);
        return view('users/service/category', compact('category'));
    }

	public function user_operator_selected(Request $request, $category_id, $operator_id, $phone_number){
		$data = [];
		try
		{
			$category = ServiceCategory::findOrFail($category_id);
			$operator = ServiceOperator::findOrFail($operator_id);
			$operators = ServiceOperator::where('country_id',$operator->country->id)->get();
		}
		catch (Exception $ex)
		{
			$data['message'] = $ex->getMessage();
		}
		return view('users/service/preview', compact('data', 'category', 'operator', 'phone_number', 'operators'));
	}

    public function preview(Request $request)
    {
		$dingService = new \App\Http\Ding\Api\V1Api();
		$phone_number = '+'.$request->input('prefix').str_replace(' ', '', $request->input('number'));
		try{
			$result = $dingService->GetAccountLookup($phone_number);
		} catch (ApiException $ex){
			return redirect('/backend')->withError($ex->getMessage());
		}
		if (!is_object($result)){
			return redirect('/backend')->withError('We are sorry, an error occurred while reading the search result data.');
		}
		try{
			$data = $result->getItems()[0]->getData();
		} catch (Exception $ex){
			return redirect('/backend')->withError($ex->getMessage());
		}
		$operator = ServiceOperator::where('ding_ProviderCode',$data['provider_code'])->first();
		if (!$operator){
			return redirect('/backend')->withError('No operator found for number '.$phone_number.' ('.$data['provider_code'].')');
		}
		$operators = $operator->country->operators;
		return view('users/service/preview', compact('data', 'operator', 'phone_number', 'operators'));
    }

	public function preview_category(Request $request, $id)
    {
		$category = ServiceCategory::findOrFail($id);

		$dingService = new \App\Http\Ding\Api\V1Api();
		$phone_number = $request->input('prefix').str_replace(' ', '', $request->input('number'));
		try{
			$result = $dingService->GetAccountLookup($phone_number);
		} catch (ApiException $ex){
			// return redirect()->route('users.services.category',[$category->id])->withError($ex->getMessage());
			//return redirect()->route('users.services.category',[$category->id])->withError('We are sorry, an error occurred while reading the search result data.');
		}
		if (!isset($result)||!is_object($result)){
			//return redirect()->route('users.services.category',[$category->id])->withError('We are sorry, an error occurred while reading the search result data.');
			try{				
				$reloadly_operator = app('App\Http\Controllers\ApiReloadlyController')->get_operator_by_number('+'.$phone_number,strtoupper($request->input('country')));
				$operator = $reloadly_operator ? ServiceOperator::where('reloadly_operatorId',$reloadly_operator->operatorId)->first() : false;
				$data = [];
				if (!isset($operator)||!$operator){
					return redirect()->route('users.services.category',[$category->id])->withError('No operator found for number '.$phone_number.' ('.$data['provider_code'].')');
				}
			} catch (\App\Http\Ding\ApiException $ex){
				return redirect()->route('users.services.category',[$category->id])->withError($ex->getResponseBody());
			} catch (Exception $ex){
				return redirect()->route('users.services.category',[$category->id])->withError($ex->getMessage());
			}
		} else {
			try{
				$items_array = $result->getItems();			
				if (isset($items_array)&&$items_array&&is_array($items_array)){			
					$data = $items_array[0]->getData();
					$operator = ServiceOperator::where('ding_ProviderCode',$data['provider_code'])->whereIn('id',$category->allowed_operators_ids())->first();
					if (!$operator&&isset($items_array[1])){
						$data = $items_array[1]->getData();
						$operator = ServiceOperator::where('ding_ProviderCode',$data['provider_code'])->whereIn('id',$category->allowed_operators_ids())->first();
					}
				} else {
					$reloadly_operator = app('App\Http\Controllers\ApiReloadlyController')->get_operator_by_number('+'.$phone_number,strtoupper($request->input('country')));
					$operator = $reloadly_operator ? ServiceOperator::where('reloadly_operatorId',$reloadly_operator->operatorId)->first() : false;
					$data = [];
				}
				if (!isset($operator)||!$operator){
					return redirect()->route('users.services.category',[$category->id])->withError('No operator found for number '.$phone_number.' ('.$data['provider_code'].')');
				}
			} catch (\App\Http\Ding\ApiException $ex){
				return redirect()->route('users.services.category',[$category->id])->withError($ex->getResponseBody());
			} catch (Exception $ex){
				return redirect()->route('users.services.category',[$category->id])->withError($ex->getMessage());
			}
		}
		$operators = ServiceOperator::where('country_id',$operator->country->id)->whereIn('id',$category->allowed_operators_ids())->get();
		return view('users/service/preview', compact('data', 'category', 'operator', 'phone_number', 'operators'));
    }

	public function user_recharge_request(Request $request){

		if(!$request->input('final_amount')){
			$response['result'] = -1;
			$response['message'] = 'Request incomplete. Please reload page and repeat request.';
			return view('users/service/result', ['response' => $response]);
		}

		if(\Auth::user()->plafond - ($request->input('final_amount')-$request->input('gain')) < \Auth::user()->debt_limit){
			$response['result'] = -1;
			$response['message'] = 'Insufficient balance, please add credit to your balance to finalize operation or contact administration.';
			return view('users/service/result', ['response' => $response]);
		}

		$service_operator = ServiceOperator::findOrFail($request->input('operator_id'));

		if($service_operator->master == 'reloadly'){
			$request_data = [
				'request_local' 					=> $request->input('local') ? $request->input('local') : 0,
				'request_operator_id' 				=> $service_operator->reloadly->operatorId,
				'request_amount' 					=> $request->input('amount'),
				'request_country_iso' 				=> $request->input('country_iso'),
				'request_recipient_phone' 			=> $request->input('recipient_phone'),
				'user_gain' 						=> $request->input('gain'),
				'final_amount' 						=> $request->input('final_amount'),
				'final_expected_destination_amount' => $request->input('final_amount_destination'),
				'category_id' 						=> $request->category_id,
			];
			$request->session()->flash('request_data', $request_data);
			return redirect()->route('users.services.reloadly.transaction.result');
		}

		if($service_operator->master == 'ding'){
			$request_data = [
				'request_local' 					=> $request->input('local') ? $request->input('local') : 0,
				'request_operator_ProviderCode' 	=> $service_operator->ding->ProviderCode,
				'request_product_sku' 				=> $request->input('product_sku'),
				'request_amount' 					=> $request->input('amount'),
				'request_country_iso' 				=> $request->input('country_iso'),
				'request_recipient_phone' 			=> $request->input('recipient_phone'),
				'user_gain' 						=> $request->input('gain'),
				'final_amount' 						=> $request->input('final_amount'),
				'final_expected_destination_amount' => $request->input('final_amount_destination'),
				'category_id' 						=> $request->category_id,
			];
			$request->session()->flash('request_data', $request_data);
			return redirect()->route('users.services.ding.transaction.result');
		}

		return redirect('/backend')->with('error','We are sorry, a problem occurred in selecting operator provider. Request aborted.');
	}
	
	public function user_mbs_recharge_request(Request $request){
		
		$request_data = [
			'Prodotto'	=> $request->Prodotto,
			'Numero'	=> $request->Numero,
		];
		$request->session()->flash('request_data', $request_data);
		return redirect()->route('users.services.mbs.ricarica_telefonica.bridged');
		

		return redirect('/backend')->with('error','We are sorry, a problem occurred in selecting operator provider. Request aborted.');
	}
	
	public function user_mbs_pin_request(Request $request){
		
		$request_data = [
			'Prodotto'	=> $request->Prodotto,
			'Numero'	=> null,
			'CodiceUtente'	=> null,
			'ImportoPinLibero'	=> null,
		];
		
		$request->session()->flash('request_data', $request_data);
		return redirect()->route('users.services.mbs.ricarica_pin.bridged');		

		return redirect('/backend')->with('error','We are sorry, a problem occurred in selecting operator provider. Request aborted.');
	}

	public function print($id)
    {
		$operation = ServiceOperation::find($id);
        return view('users/service/print',compact('operation'));
    }

	public function print_small($id)
    {
		$operation = ServiceOperation::find($id);
        return view('users/service/print_small',compact('operation'));
    }

}
