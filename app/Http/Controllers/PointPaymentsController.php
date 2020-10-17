<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\User;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PaymentsExport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PointPaymentsController extends Controller
{

    public function index()
    {
		$payments = Payment::
						where('user_id',\Auth::user()->id)
						->get();
        return view('users/payments/list', compact('payments') );
    }

	public function export(Request $request)
    {
		$payments = Payment::select("payments.id","payments.date","payments.user_id","users.name","payments.amount","payments.details","payments.created_at","payments.updated_at")
			->join('users', 'users.id', '=', 'payments.user_id')
			->where('users.id',\Auth::user()->id)
			->get();
        return Excel::download(new PaymentsExport($payments), 'payments.xlsx');
    }

    public function create()
    {
        return view('users/payments/create' );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'date'		=> 'required',
                'amount'	=> 'required',
                'document'  => 'mimes:jpg,doc,docx,png,pdf'
            ],
            [
                'date.required'		=> 'Date required',
                'amount.required'	=> 'Amount required'
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
            'user_id'	=> \Auth::user()->id,
            'details'	=> $request->input('details'),
            'approved'	=> 0,
            'type'      => 1
        ]);
        $file = $request->file('document');

        if ($file) {
            $filename = 'user-created-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('users-added-payments', $filename);
            $payment->documents()->create([
                'label' => $payment->user->name.'-document-user',
                'filename' => $path
            ]);
        }

        return redirect()->route('users.payments.index')->with('success', 'Payment registered');
    }

    public function show($id)
	{

    }

    public function edit($id)
    {

    }

    public function update(Request $request,$id)
    {

    }

    public function destroy($id, Request $request)
    {

    }
}
