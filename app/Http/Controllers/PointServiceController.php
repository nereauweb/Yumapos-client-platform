<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\ServiceOperator;
use App\Models\ServiceOperation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PointServiceController extends Controller
{    
    public function input()
    {
        return view('users/service/input' );
    }
	
    public function category(Request $request, $id)
    {
		$category = ServiceCategory::findOrFail($id);
        return view('users/service/category', compact('category'));
    }
	
    public function preview(Request $request)
    {
		$dingService = new \App\Http\Ding\Api\V1Api();
		$full_number = '+'.$request->input('prefix').str_replace(' ', '', $request->input('number'));
		try{
			$result = $dingService->GetAccountLookup($full_number);
		} catch (Exception $ex){
			return back()->withError($ex->getMessage());	
		}
		if (!is_object($result)){			
			return back()->withError('We are sorry, an error occurred while reading the search result data.');
		}
		try{
			$data = $result->getItems()[0]->getData();
		} catch (Exception $ex){
			return back()->withError($ex->getMessage());	
		}	
		$operator = ServiceOperator::where('ding_ProviderCode',$data['provider_code'])->first();		
		if (!$operator){			
			return back()->withError('No operator found for number '.$full_number.' ('.$data['provider_code'].')');
		}
		return view('users/service/preview', ['data' => $data, 'operator' => $operator, 'phone_number' => $full_number] );
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
