<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\User;

use Illuminate\Database\QueryException;
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
        $payments = auth()->user()->payments()->when(($request->from !== null && !empty($request->from)), function ($query) use ($request) {
            $query->where('date', '>=', $request->from);
        })->when(($request->to !== null && !empty($request->to)), function ($query) use ($request) {
            $query->where('date', '<=', $request->to);
        })->when($request->state, function ($query) use ($request) {
            if ($request->state == '00') $request->state = 0;
            $query->where('approved', '=', $request->state);
        })->select('id', 'date', 'amount', 'type', 'details', 'approved', 'created_at', 'updated_at')->get();

        return Excel::download(new PaymentsExport($payments, 'user'), 'payments.xlsx');
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
                'document'  => 'mimes:jpg,jpeg,doc,docx,png,pdf'
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

        try {
            DB::beginTransaction();
            $payment = Payment::create([
                'date'		=> $date->format("Y-m-d H:i:s"),
                'amount'	=> $request->input('amount'),
                'user_id'	=> \Auth::user()->id,
                'details'	=> $request->input('details'),
                'approved'	=> 0,
                'type'      => 1,
                'update_balance' => 1
            ]);
            $file = $request->file('document');

            if ($file) {
                $filename = 'document-'.auth()->user()->name.'-'. time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('payments', $filename);
                $payment->documents()->create([
                    'label' => $payment->user->name.'-document-user-'.time(),
                    'filename' => $path
                ]);
            }
            DB::commit();
            return redirect()->route('users.payments.index')->with(['status' => 'success', 'message' => 'Payment registered']);
        } catch (QueryException $q) {
		    DB::rollBack();
            return redirect()->route('users.payments.index')->with(['status' => 'error', 'message' => $q->getMessage()]);
        }
    }
}
