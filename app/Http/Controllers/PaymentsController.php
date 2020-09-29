<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\User;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PaymentsExport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PaymentsController extends Controller
{
	
    public function index()
    {
		$payments = Payment::all();
        return view('admin/payments/list', compact('payments') );
    }
	
	public function export(Request $request)
    {
		$payments = Payment::select("payments.id","payments.date","payments.user_id","users.name","payments.amount","payments.details","payments.created_at","payments.updated_at")
			->join('users', 'users.id', '=', 'payments.user_id')
			->get();
        return Excel::download(new PaymentsExport($payments), 'payments.xlsx');
    }
	
    public function create()
    {
        $users = User::pluck('name','id');
        return view('admin/payments/create', compact('users') );
    }
	
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'date'		=> 'required',
                'amount'	=> 'required',
                'user_id'	=> 'required'
            ],
            [
                'date.required'		=> 'Date required',
                'amount.required'	=> 'Amount required',
                'user_id.required'	=> 'User required',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
		
		$date = \DateTime::createFromFormat("d/m/Y",$request->input('date'));
		
		if (!$date) {
            return back()->withErrors($validator)->withInput();
        }
		
        $payment = Payment::create([
            'date'		=> $date->format("Y-m-d H:i:s"),
            'amount'	=> $request->input('amount'),
            'user_id'	=> $request->input('user_id'),
            'details'	=> $request->input('details'),
            'approved'	=> 1,
        ]);
		
		$user = $payment->user;
		
		$user->plafond = $user->plafond + $request->input('amount');
		$user->save();

        return redirect()->route('admin.payments.index')->with('success', 'Payment added, user balance updated');
    }
    
    public function show($id)
	{
		
    }
	
    public function edit($id)
    {
		
    }
	
    public function update(Request $request,$id) // approve
    {
		$payment = Payment::find($id);
		$payment->approved = 1;
		$user = $payment->user;		
		$user->plafond = $user->plafond + $request->input('amount');
		$user->save();
		$payment->save();
		return redirect()->route('admin.payments.index')->with('success', 'Payment approved, user balance updated');
    }
	
    public function destroy($id, Request $request)
    {
		
    }
}
