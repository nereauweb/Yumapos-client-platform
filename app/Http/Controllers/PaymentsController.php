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
            'type'      => 1
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
                'type'      => 1
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
                    $doc->delete();
                }
            }
            $payment->delete();

            return back()->with(['status' => 'success', 'message' => 'file successfully deleted!']);
        } else {
            return back();
        }
    }

    public function payUser()
    {
        $users = User::where('id', '!=', auth()->id())->pluck('name','id');
        return view('admin/payments/pay-user', compact('users'));
    }

    public function payUserStore(Request $request)
    {
        if ($request->updateUserBalance) {
            if ($this->storePayment($request->all(), true)) {
                return redirect()->route('admin.payments.index')->with(['status' => 'success', 'message' => 'Payment added, user balance updated']);
            };
        } else {
            if ($this->storePayment($request->all(), false)) {
                return redirect()->route('admin.payments.index')->with(['status' => 'success', 'message' => 'Payment added']);
            }
        }
    }

    private function storePayment(array $data, bool $boolean)
    {
        $validator = $this->validateData($data);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $date = \DateTime::createFromFormat("d/m/Y",$data['date']);

        if (!$date) {
            return back()->withErrors($validator)->withInput();
        }

        $dataToCreate = [
            'date'		=> $date->format("Y-m-d H:i:s"),
            'amount'	=> $data['amount'],
            'user_id'	=> $data['user_id'],
            'details'	=> $data['details'],
            'approved'	=> 1,
            'type'      => $data['type']
        ];

        if ($boolean) {
            try {
                $dataToCreate['update_balance'] = 1;
                $payment = Payment::create($dataToCreate);
                if ($payment) {
                    $user = $payment->user;
                    $user->plafond = $user->plafond + $payment->amount;
                    $user->save();
                    $this->fileAdd($payment, $data);
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            try {
                $dataToCreate['update_balance'] = 2;
                $payment = Payment::create($dataToCreate);
                $this->fileAdd($payment, $data);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
        return $payment;
        }


    private function validateData(array $data) {
        return Validator::make($data,
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
            ]);
    }

    private function fileAdd(Payment $payment, array $data) {
        $file = $data['document'];
        if (is_file($file)) {
            $filename = 'admin-created-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('payments', $filename);
            $payment->documents()->create([
                'label' => $payment->user->name.'-document',
                'filename' => $path
            ]);
        }
    }


    public function cancel($payment)
    {
        $payment = Payment::findOrFail($payment);
        $amountToBeRemoved = $payment->amount;
        try {
            if ($payment->update_balance == 2) {
                $payment->update([
                    'approved' => '-1'
                ]);
            } else {
                $payment->update([
                    'approved' => '-1'
                ]);
                $payment->user()->update([
                    'plafond' => (float)$payment->user->plafond - (float)$amountToBeRemoved
                ]);
            }

            return back()->with(['status' => 'success', 'message' => 'payment canceled successfully, user balance updated!']);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
