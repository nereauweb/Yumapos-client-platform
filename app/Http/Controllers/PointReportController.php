<?php

namespace App\Http\Controllers;

use App\Models\ServiceOperation;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PointReportController extends Controller
{	
	public function operations(Request $request)
    {
		$date_begin = $request->input('date_begin') ? $request->input('date_begin') . ' 00:00:00' : date("Y-m-d") . ' 00:00:00';
		$date_end = $request->input('date_end') ? $request->input('date_end') . ' 23:59:59' : date("Y-m-d") . ' 23:59:59';
		$operations = ServiceOperation::where('created_at','>=',$date_begin)->where('created_at','<=',$date_end)->where('user_id',Auth::user()->id)->orderBy('id','DESC')->get();
        return view('users/report/operations',compact('operations','date_begin','date_end'));
    }
	
	
}
