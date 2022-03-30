<?php
namespace App\Http\Controllers;

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
		return redirect('/backend')->withError('Under development (API connect)');
		return view('users/service/preview', compact('data', 'operator', 'phone_number', 'operators'));
    }

	public function preview_category(Request $request, $id)
    {
		$category = ServiceCategory::findOrFail($id);

		return redirect('/backend')->withError('Under development (API connect)');
		
		return view('users/service/preview', compact('data', 'category', 'operator', 'phone_number', 'operators'));
    }

	public function user_recharge_request(Request $request){

		return redirect('/backend')->withError('Under development (API connect)');

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
