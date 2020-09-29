<?php

namespace App\Http\Controllers;

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
