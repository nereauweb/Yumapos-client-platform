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
						->orWhere('target_id',\Auth::user()->id)
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
		$active = true;
		$last_payment = Payment::where('user_id',\Auth::user()->id)->orderBy('created_at', 'desc')->first();
		if($last_payment){
			if (strtotime($last_payment->created_at) > strtotime("-5 minutes")){
				$active = false;
			}
		}
        return view('users/payments/create', compact('active') );
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
		
		$last_payment = Payment::where('user_id',\Auth::user()->id)->orderBy('created_at', 'desc')->first();
		if($last_payment){
			if (strtotime($last_payment->created_at) > strtotime("-5 minutes")){
				return back()->with(['status' => 'error', 'message' => 'Invio non registrato: è già presente un\'operazione recente. Attendi 5 minuti prima di effettuare un nuovo invio, se necessario.']);
			}
		}

		$date = \DateTime::createFromFormat("d/m/Y",$request->input('date'));

		if (!$date) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
			if ($request->input('type')==1){
				$payment = Payment::create([
					'date'		=> $date->format("Y-m-d H:i:s"),
					'amount'	=> $request->input('amount'),
					'user_id'	=> \Auth::user()->id,
					'details'	=> $request->input('details'),
					'approved'	=> 0,
					'type'      => 1,
					'update_balance' => 1
				]);
			} else {
				$payment = Payment::create([
					'date'		=> $date->format("Y-m-d H:i:s"),
					'amount'	=> $request->input('amount'),
					'user_id'	=> \Auth::user()->id,
					'details'	=> $request->input('details'),
					'approved'	=> 0,
					'type'      => 4,
					'target_id' => $request->input('target_id'),
					'update_balance' => 0
				]);
			}
			
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
	
	public function create_transfer(Request $request, $id)
    {
		$user = User::find($id);
        return view('users/payments/transfer-balance', compact('user') );
    }
	
	public function transfer(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'amount'	=> 'required',
            ],
            [
                'amount.required'	=> 'Amount required'
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
		
		if (\Auth::user()->plafond < $request->input('amount')){
			return back()->withError('Insufficient plafond to transfer the requested amount');
		}
		
		$user = \Auth::user();
		$target_user = User::find($request->input('target_id'));
		
		if (!$target_user){
			return back()->withError('Target user not found');
		}

        try {
			$user->plafond = $user->plafond - $request->input('amount');
			$target_user->plafond = $target_user->plafond + $request->input('amount');
            DB::beginTransaction();
            $payment = Payment::create([
                'date'		=> date("Y-m-d H:i:s"),
                'amount'	=> $request->input('amount'),
                'user_id'	=> $user->id,
                'target_id'	=> $target_user->id,
                'details'	=> $request->input('details'),
                'approved'	=> 1,
                'type'      => 4,
                'update_balance' => 1
            ]);
            DB::commit();
			$user->save();
			$target_user->save();			
            return back()->with(['status' => 'success', 'message' => 'Transfer completed']);
        } catch (QueryException $q_ex) {
		    DB::rollBack();
            return back()->withError($q_ex->getMessage());
        }
    }
	
}
