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
		$payments = Payment::paginate(10);
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
                'user_id'	=> 'required',
                'document'  => 'mimes:jpg,doc,docx,png,pdf'
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
            'type'      => 2
        ]);

        $file = $request->file('document');
        $filename = 'admin-created-' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('payments', $filename);
        $payment->document()->create([
            'label' => $payment->user->name.'-document',
            'filename' => $path
        ]);

		$user = $payment->user;

		$user->plafond = $user->plafond + $request->input('amount');
		$user->save();

        return redirect()->route('admin.payments.index')->with(['status' => 'success', 'message' => 'Payment added, user balance updated']);
    }

    public function show($id)
	{

    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return view('admin.payments.edit', compact('payment'));
    }

    public function update(Request $request,$id) // approve
    {
		$payment = Payment::findOrFail($id);

        $validator = Validator::make($request->all(),
            [
                'date'		=> 'required',
                'amount'	=> 'required',
                'document'  => 'mimes:jpg,doc,docx,png,pdf'
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

        try {
            $payment->update([
                'date'		=> $date->format("Y-m-d H:i:s"),
                'amount'	=> $request->input('amount'),
                'details'	=> $request->input('details'),
                'approved'	=> 1,
                'type'      => 2
            ]);

            $file = $request->file('document');
            if (isset($file)) {
                if (isset($payment->documents)) {
                    $filename = 'admin-added-' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('payments', $filename);
                    $payment->documents()->create([
                        'label' => $payment->user->name.'-document',
                        'filename' => $path
                    ]);
                } else {
                    $filename = 'admin-added-' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('payments', $filename);
                    $payment->documents()->create([
                        'label' => $payment->user->name.'-document',
                        'filename' => $path
                    ]);
                }
            }

            $payment->user()->update([
                'plafond' => $payment->user->plafond + $request->amount
            ]);
        } catch (\Exception $e) {
            $e->getMessage();
        }

        return redirect()->route('admin.payments.index')->with(['status' => 'success', 'message' => 'Payment updated, user balance updated']);
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        if ($payment) {
            $payment->update([
                'approved' => 1
            ]);
        }

        return back()->with(['status' => 'success', 'message' => 'payment approved successfully']);
    }

    public function destroy($id, Request $request)
    {
        $payment = Payment::findOrFail($id);
        if ($payment) {
            if (count($payment->documents) > 0) {
                foreach ($payment->documents as $doc) {
                    if (\Storage::exists($doc->filename)) {
                        \Storage::move($doc->filename, 'archived/'.$doc->filename);
                    }
                    $doc->delete();
                }
            }
            $payment->delete();
            return back()->with(['status' => 'success', 'message' => 'file successfully deleted!']);
        } else {
            return back();
        }
    }
}
