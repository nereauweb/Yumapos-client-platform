<?php

namespace App\Http\Controllers;

use App\Exports\UserOperationsExport;
use App\Models\ServiceOperation;
use App\Models\ServiceOperator;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class PointReportController extends Controller
{
	public function operations(Request $request)
    {
		$date_begin = $request->input('date_begin') ? $request->input('date_begin') . ' 00:00:00' : date("Y-m-d") . ' 00:00:00';
		$date_end = $request->input('date_end') ? $request->input('date_end') . ' 23:59:59' : date("Y-m-d") . ' 23:59:59';
		$operations = ServiceOperation::where('created_at','>=',$date_begin)->where('created_at','<=',$date_end)->where('user_id',Auth::user()->id)->orderBy('id','DESC')->get();
        return view('users/report/operations',compact('operations','date_begin','date_end'));
    }

    public function export(Request $request)
    {
        $userOperations = auth()->user()->serviceOperations()->when(($request->from !== null && !empty($request->from)), function ($query) use ($request) {
            $query->where('created_at', '>=', $request->from);
        })->when(($request->to !== null && !empty($request->to)), function ($query) use ($request) {
            $query->where('created_at', '<=', $request->to);
        })->when($request->selectedCountry, function ($query) use ($request) {
            $query->where('request_country_iso', $request->selectedCountry);
        })->when($request->selectedOperator, function ($query) use ($request) {
            $selectedOperator = ServiceOperator::findOrFail($request->selectedOperator);
            if (is_null($selectedOperator->reloadly_operatorId) && !is_null($selectedOperator->ding_ProviderCode)) {
                $query->where('request_ProviderCode', $selectedOperator->ding_ProviderCode);
            } else if (is_null($selectedOperator->ding_ProviderCode) && !is_null($selectedOperator->reloadly_operatorId)) {
                $query->where('request_operatorId', $selectedOperator->reloadly_operatorId);
            } else {
                $query->where('request_operatorId', $selectedOperator->reloadly_operatorId)->orWhere('request_ProviderCode', $selectedOperator->ding_ProviderCode);
            }
        })->get();

        return Excel::download(new UserOperationsExport($userOperations), 'user_operations.xlsx');
    }
	
	public function operations_ticket(Request $request)
    {		
		$date_begin = $request->input('date_begin') ? $request->input('date_begin') . ' 00:00:00' : date("Y-m-d") . ' 00:00:00';
		$date_end = $request->input('date_end') ? $request->input('date_end') . ' 23:59:59' : date("Y-m-d") . ' 23:59:59';
		$operations = ServiceOperation::where('created_at','>=',$date_begin)->where('created_at','<=',$date_end);
		$operations->where('user_id',\Auth::user()->id);
		$operations = $operations->get();
		$operations = ServiceOperation::all();
        return view('users/report/tickets',compact('operations','date_begin','date_end'));
	}

}
