<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Provider;
use App\User;

use Illuminate\Database\QueryException;
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
        $date_begin = ($request->from && !is_null($request->from)) ? $request->from . ' 00:00:00' : date("Y") . '-01-01 00:00:00';
        $date_end = ($request->to && !is_null($request->to)) ? $request->to . ' 23:59:59' : date("Y") . '-12-31 23:59:59';
        $payments = Payment::leftJoin('users as u', 'u.id', '=', 'payments.user_id')->where('payments.date', '>=', $date_begin)->where('payments.date', '<=', $date_end)
            ->leftJoin('providers as p', 'p.id' ,'=', 'payments.provider_id')
            ->when($request->userSelected, function ($query) use ($request) {
                $query->where('u.id', $request->userSelected);
            })->when($request->typeSelected, function ($query) use ($request) {
                $query->where('payments.type', $request->typeSelected);
            })->when(!is_null($request->stateSelected), function ($query) use ($request) {
                $query->where('payments.approved', $request->stateSelected);
        })->select("payments.id","payments.date","payments.user_id","u.name","p.company_name","payments.amount","payments.details","payments.created_at","payments.updated_at")->get();
        return Excel::download(new PaymentsExport($payments), 'payments.xlsx');
    }

    public function create()
    {
        $users = User::pluck('name','id');
        return view('admin/payments/create', compact('users') );
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'user_id' => 'required',
            'amount' => 'required|gt:0',
            'details' => '',
            'document' => 'mimes:jpg,jpeg,jpeg,doc,docx,png,pdf',
        ]);

        $date = \DateTime::createFromFormat('d/m/Y', $request->date);

        if (!$date) {
            return back()->withInput($request->only('date'));
        }

        $user = User::findOrFail($request->user_id);

        try {
            DB::beginTransaction();
//            update plafond
            $user->update(['plafond' => (float)$user->plafond + $request->amount]);
//                create payment for this user, type 1: user to admin
            $payment = $user->payments()->create([
                'date' => $date->format('Y-m-d H:i:s'),
                'type' => 1,
                'amount' => $request->amount,
                'details' => $request->details,
                'approved' => 1,
                'update_balance' => 1,
                'update_credit' => 0,
            ]);
//                checks if file exists
            if ($request->hasFile('document')) {
                $filename = 'payment-' . time() . '.' . $request->file('document')->getClientOriginalExtension();
                $path = $request->file('document')->storeAs('payments', $filename);
                $payment->documents()->create([
                    'label' => 'payment-'.time(),
                    'filename' => $path
                ]);
            }
            DB::commit();
            return back()->with(['status' => 'success', 'message' => 'payment for [ '. ucwords($user->name) . ' ] registered successfully, plafond updated!']);
        } catch (\ErrorException $e) {
            DB::rollBack();
            return back()->with(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
//    ####old function#####
//    public function store(Request $request)
//    {
//        $validator = $this->validateData($request->all());
//
//        if ($validator->fails()) {
//            return back()->withErrors($validator)->withInput();
//        }
//
//		$date = \DateTime::createFromFormat("d/m/Y",$request->input('date'));
//
//		if (!$date) {
//            return back()->withErrors($validator)->withInput();
//        }
//        try {
//            DB::beginTransaction();
//            $payment = Payment::create([
//                'date'		=> $date->format("Y-m-d H:i:s"),
//                'amount'	=> $request->input('amount'),
//                'user_id'	=> $request->input('user_id'),
//                'details'	=> $request->input('details'),
//                'approved'	=> 1,
//                'type'      => 1,
//                'update_balance' => 1
//            ]);
//
//            $file = $request->file('document');
//            if ($file) {
//                $filename = 'payment-'.$payment->user->name.'-' . time() . '.' . $file->getClientOriginalExtension();
//                $path = $file->storeAs('payments', $filename);
//                $payment->documents()->create([
//                    'label' => $payment->user->name.'-document-'.time(),
//                    'filename' => $path
//                ]);
//            }
//
//            $payment->user()->update([
//                'plafond' => $payment->user->plafond + $request->input('amount')
//            ]);
//            DB::commit();
//            return redirect()->route('admin.payments.index')->with(['status' => 'success', 'message' => 'Payment added, user balance updated']);
//        } catch (\Exception $e) {
//		    DB::rollBack();
//            return redirect()->route('admin.payments.index')->with(['status' => 'error', 'message' => $e->getMessage()]);
//        }
//    }

    public function show($id)
	{

    }

    public function edit(Request $request, $id)
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
            'document'  => 'mimes:jpg,jpeg,doc,docx,png,pdf'
        ],
        [
            'date.required'		=> 'Date required',
            'amount.required'	=> 'Amount required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

		$date = \DateTime::createFromFormat("d/m/Y",$request->input('date'));

		if (!$date) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $payment->update([
                'date' => $date->format("Y-m-d H:i:s"),
                'amount' => $request->input('amount'),
                'details' => $request->input('details'),
                'type' => 1,
                'update_balance' => 1
            ]);

            if ($request->hasFile('document')) {
                $file = $request->file('document');
                if (isset($file)) {
                    $filename = 'document-' . $payment->user->name . '-' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('payments', $filename);
                    $payment->documents()->create([
                        'label' => $payment->user->name . '-document',
                        'filename' => $path
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.payments.index')->with(['status' => 'success', 'message' => 'Payment saved, user balance updated']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.payments.index')->with(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        if ($payment) {
            try {
                DB::beginTransaction();
                $payment->update([
                    'approved' => 1
                ]);

                $payment->user()->update([
                    'plafond' => $payment->user->plafond + $payment->amount
                ]);
                DB::commit();
                return back()->with(['status' => 'success', 'message' => 'payment approved successfully, user balance updated']);
            } catch (QueryException $q) {
                DB::rollBack();
                return back()->with(['status' => 'error', 'message' => $q->getMessage()]);
            }
        }
        return back()->with(['status' => 'warning', 'message' => 'payment not found']);
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
        return view('admin/payments/pay-user');
    }

    public function payProvider()
    {
        $providers = Provider::all();
        return view('admin/payments/pay-provider', compact('providers'));
    }

    public function payProviderStore(Request $request)
    {
        // type = 3 (stores payments made from admin to provider, and it reduces the total sum of payments (inside the view))
        $data = $request->validate([
            'date' => '',
            'provider_id' => 'required',
            'amount' => 'required|gt:0',
            'details' => '',
            'document' => '',
            'approved' => '',
            'type' => '',
            'update_balance' => ''
        ]);
        $date = \DateTime::createFromFormat("d/m/Y",$request->date);
        $date->format("Y-m-d H:i:s");

        if (!$date) {
            return back()->withErrors($data)->withInput();
        }

        $data['date'] = $date;

        try {
            DB::beginTransaction();
            $payment = Payment::create($data);
            $this->fileAdd($payment, $data);
            DB::commit();
            return back()->with(['status' => 'success', 'message' => 'Payment added to provider successfully!']);
        } catch (\Exception $e) {
            return back()->with(['status' => 'error', 'message' => $e->getMessage()]);
        }

    }

    public function payUserStore(Request $request)
    {
        $request->validate([
           'date' => 'required',
            'user_id' => 'required',
            'amount' => 'required|gt:0',
            'document' => 'mimes:jpg,jpeg,doc,docx,png,pdf',
        ]);

        $date = \DateTime::createFromFormat('d/m/Y', $request->date);

        if (!$date) {
            return back()->withInput($request->only('date'));
        }

        $user = User::findOrFail($request->user_id);

        if ($request->updateUserBalance && $request->updateAgentCredit) {
//            updating agent credit/plafond update_balance = 1, update_credit = 1, type 2,
            try {
                DB::beginTransaction();
                $user->update([
                    'plafond' => (float)$user->plafond + (float)$request->amount,
                    'credit' => (float)$user->credit - (float)$request->amount
                ]);
                $payment = $user->payments()->create([
                    'date' => $date->format('Y-m-d H:i:s'),
                    'type' => 2,
                    'amount' => $request->amount,
                    'details' => $request->details,
                    'approved' => 1,
                    'update_balance' => 1,
                    'update_credit' => 1,
                ]);
                //                checks if file exists
                if ($request->hasFile('document')) {
                    $filename = 'payment-agent-' . time() . '.' . $request->file('document')->getClientOriginalExtension();
                    $path = $request->file('document')->storeAs('payments', $filename);
                    $payment->documents()->create([
                        'label' => 'payment-agent-'.time(),
                        'filename' => $path
                    ]);
                }
                DB::commit();
                return back()->with(['status' => 'success', 'message' => 'Agent credit/plafond got updated, payment Platform => user created!']);
            } catch (\ErrorException $e) {
                DB::rollBack();
                return back()->with(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else if ($request->updateUserBalance && !$request->updateAgentCredit) {
            try {
                DB::beginTransaction();
                $user->update(['plafond' => (float)$user->plafond + (float)$request->amount]);
                $payment = $user->payments()->create([
                    'date' => $date->format('Y-m-d H:i:s'),
                    'type' => 2,
                    'amount' => $request->amount,
                    'details' => $request->details,
                    'approved' => 1,
                    'update_balance' => 1,
                    'update_credit' => 0,
                ]);
                //                checks if file exists
                if ($request->hasFile('document')) {
                    $filename = 'payment-user-' . time() . '.' . $request->file('document')->getClientOriginalExtension();
                    $path = $request->file('document')->storeAs('payments', $filename);
                    $payment->documents()->create([
                        'label' => 'payment-agent-' . time(),
                        'filename' => $path
                    ]);
                }
                DB::commit();
                return back()->with(['status' => 'success', 'message' => 'User plafond got updated, payment Platform => user created!']);
            } catch (\ErrorException $e) {
                DB::rollBack();
                return back()->with(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else if (!$request->updateUserBalance && $request->updateAgentCredit) {
                try {
                    DB::beginTransaction();
                    $user->update(['credit' => (float)$user->credit - (float)$request->amount]);
                    $payment = $user->payments()->create([
                        'date' => $date->format('Y-m-d H:i:s'),
                        'type' => 2,
                        'amount' => $request->amount,
                        'details' => $request->details,
                        'approved' => 1,
                        'update_balance' => 0,
                        'update_credit' => 1,
                    ]);
                    //                checks if file exists
                    if ($request->hasFile('document')) {
                        $filename = 'payment-agent-' . time() . '.' . $request->file('document')->getClientOriginalExtension();
                        $path = $request->file('document')->storeAs('payments', $filename);
                        $payment->documents()->create([
                            'label' => 'payment-agent-' . time(),
                            'filename' => $path
                        ]);
                    }
                    DB::commit();
                    return back()->with(['status' => 'success', 'message' => 'Agent credit got updated, payment Platform => user created!']);
                } catch (\ErrorException $e) {
                    DB::rollBack();
                    return back()->with(['status' => 'error', 'message' => $e->getMessage()]);
                }
        } else {
            try {
                DB::beginTransaction();
                $payment = $user->payments()->create([
                    'date' => $date->format('Y-m-d H:i:s'),
                    'type' => 2,
                    'amount' => $request->amount,
                    'details' => $request->details,
                    'approved' => 1,
                    'update_balance' => 0,
                    'update_credit' => 0,
                ]);
                //                checks if file exists
                if ($request->hasFile('document')) {
                    $filename = 'payment-user-' . time() . '.' . $request->file('document')->getClientOriginalExtension();
                    $path = $request->file('document')->storeAs('payments', $filename);
                    $payment->documents()->create([
                        'label' => 'payment-user-' . time(),
                        'filename' => $path
                    ]);
                }
                DB::commit();
                return back()->with(['status' => 'success', 'message' => 'Payment got stored, no further action has been taken!']);
            } catch (\ErrorException $e) {
                DB::rollBack();
                return back()->with(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
//    ####OLD CODE####
//    public function payUserStore(Request $request)
//    {
//        if ($request->updateUserBalance) {
//            $this->storePayment($request->all(), true);
//            return redirect()->route('admin.payments.index')->with(['status' => 'success', 'message' => 'Payment added, user balance updated']);
//        } else {
//            $this->storePayment($request->all(), false);
//            return redirect()->route('admin.payments.index')->with(['status' => 'success', 'message' => 'Payment added, user balance remains the same']);
//        }
//    }

    public function cancel(Payment $payment)
    {
        try {
            switch ($payment->type) {
                case 1:
                    try {
                        DB::beginTransaction();
                        $payment->update(['approved' => '-1']);
                        $payment->user()->update(['plafond' => (float)$payment->user->plafond - (float)$payment->amount]);
                        DB::commit();
                        return back()->with(['status' => 'info', 'message' => 'payment of [ '.ucwords($payment->user->name).' ] got canceled!']);
                    } catch (\ErrorException $e) {
                        DB::rollBack();
                        return back()->with(['status' => 'error', 'message' => $e->getMessage()]);
                    }
                    break;
                case 2:
                    if ($payment->update_balance == 1 && $payment->update_credit == 1) {
//                        do agent things
                        try {
                            DB::beginTransaction();
                            $payment->update(['approved' => '-1']);
                            $payment->user()->update(['plafond' => (float)$payment->user->plafond - (float)$payment->amount, 'credit' => (float)$payment->user->credit + (float)$payment->amount]);
                            DB::commit();
                            return back()->with(['status' => 'info', 'message' => 'payment and credit of [ '.ucwords($payment->user->name).' ] got canceled!']);
                        } catch (\ErrorException $e) {
                            DB::rollBack();
                            return back()->with(['status' => 'error', 'message' => $e->getMessage()]);
                        }

                    } else if ($payment->update_balance == 0 && $payment->update_credit ==1) {
//                        again do agent things
                        try {
                            DB::beginTransaction();
                            $payment->update(['approved' => '-1']);
                            $payment->user()->update(['credit' => (float)$payment->user->credit + (float)$payment->amount]);
                            DB::commit();
                            return back()->with(['status' => 'info', 'message' => 'Credit of [ '.ucwords($payment->user->name).' ] got canceled!']);
                        } catch (\ErrorException $e) {
                            DB::rollBack();
                            return back()->with(['status' => 'error', 'message' => $e->getMessage()]);
                        }

                    } else if ($payment->update_balance == 1 && $payment->update_credit == 0) {
//                        do user/agent things
                        try {
                            DB::beginTransaction();
                            $payment->update(['approved' => '-1']);
                            $payment->user()->update(['plafond' => (float)$payment->user->plafond - (float)$payment->amount]);
                            DB::commit();
                            return back()->with(['status' => 'info', 'message' => 'payment of [ '.ucwords($payment->user->name).' ] got canceled!']);
                        } catch (\ErrorException $e) {
                            DB::rollBack();
                            return back()->with(['status' => 'error', 'message' => $e->getMessage()]);
                        }
                    } else {
//                        we assume none of checkboxes has been checked, meaning you just store the payment with type 2 (platform to user, but without increasing/decreasing either credit or plafond)!
                        $payment->update(['approved' => '-1']);
                        return back()->with(['status' => 'info', 'message' => 'payment of [ '.ucwords($payment->user->name).' ] has been canceled, without any effect to other tables']);
                    }
                    break;
                case 3:
                    $payment->update(['approved' => '-1']);
                    return back()->with(['status' => 'info', 'message' => 'payment of [ \'PLATFORM\' ] has been canceled, without any effect to other tables']);
                    break;
                default:
                    return back()->with(['status' => 'warning', 'message' => 'Payment type is unknown']);
            }
        } catch (\ErrorException $e) {
            DB::rollBack();
            return back()->with(['status' => 'error', 'message' => $e->getMessage()]);
        }
//        ####OLD CODE#####
//        $payment = Payment::findOrFail($payment);
//        $amountToBeRemoved = $payment->amount;
//        try {
//            if ($payment->update_balance == 0 && $payment->update_credit == 0) {
//                $payment->update([
//                    'approved' => '-1'
//                ]);
//                $updatedRelation = $payment->type == 3 ? 'Provider' : 'User';
//                return back()->with(['status' => 'success', 'message' => 'payment canceled successfully,'.$updatedRelation.' balance remains the same!']);
//            } else if($payment->update_credit == 1) {
//                DB::beginTransaction();
//                $payment->update([
//                    'approved' => '-1'
//                ]);
//                $payment->user()->update([
//                    'credit' => (float)$payment->user->credit + (float)$amountToBeRemoved
//                ]);
//                DB::commit();
//                return back()->with(['status' => 'success', 'message' => 'credit canceled successfully, agent credit restored']);
//            } else {
//                try {
//                    DB::beginTransaction();
//                    $payment->update([
//                        'approved' => '-1'
//                    ]);
//                    $payment->user()->update([
//                        'plafond' => (float)$payment->user->plafond - (float)$amountToBeRemoved
//                    ]);
//                    DB::commit();
//                    return back()->with(['status' => 'success', 'message' => 'payment canceled successfully, user balance updated!']);
//                } catch (QueryException $q) {
//                    DB::rollBack();
//                    return back()->with(['status' => 'error', 'message' => $q->getMessage()]);
//                }
//            }
//        } catch (\Exception $e) {
//            dd($e->getMessage());
//        }
    }

    public function recover(Payment $payment)
    {
        try {
            switch ($payment->type) {
                case 1:
                    try {
                        DB::beginTransaction();
                        $payment->update(['approved' => '1']);
                        $payment->user()->update(['plafond' => (float)$payment->user->plafond + (float)$payment->amount]);
                        DB::commit();
                        return back()->with(['status' => 'success', 'message' => 'payment of [ '.ucwords($payment->user->name).' ] got recovered!']);
                    } catch (\ErrorException $e) {
                        DB::rollBack();
                        return back()->with(['status' => 'error', 'message' => $e->getMessage()]);
                    }
                    break;
                case 2:
                    if ($payment->update_balance == 1 && $payment->update_credit == 1) {
//                        do agent things
                        try {
                            DB::beginTransaction();
                            $payment->update(['approved' => '1']);
                            $payment->user()->update(['plafond' => (float)$payment->user->plafond + (float)$payment->amount, 'credit' => (float)$payment->user->credit - (float)$payment->amount]);
                            DB::commit();
                            return back()->with(['status' => 'success', 'message' => 'payment and credit of [ '.ucwords($payment->user->name).' ] got recovered!']);
                        } catch (\ErrorException $e) {
                            DB::rollBack();
                            return back()->with(['status' => 'error', 'message' => $e->getMessage()]);
                        }

                    } else if ($payment->update_balance == 0 && $payment->update_credit == 1) {
//                        again do agent things
                        try {
                            DB::beginTransaction();
                            $payment->update(['approved' => '1']);
                            $payment->user()->update(['credit' => (float)$payment->user->credit - (float)$payment->amount]);
                            DB::commit();
                            return back()->with(['status' => 'success', 'message' => 'Credit of [ '.ucwords($payment->user->name).' ] got recovered!']);
                        } catch (\ErrorException $e) {
                            DB::rollBack();
                            return back()->with(['status' => 'error', 'message' => $e->getMessage()]);
                        }

                    } else if ($payment->update_balance == 1 && $payment->update_credit == 0) {
//                        do user/agent things
                        try {
                            DB::beginTransaction();
                            $payment->update(['approved' => '1']);
                            $payment->user()->update(['plafond' => (float)$payment->user->plafond + (float)$payment->amount]);
                            DB::commit();
                            return back()->with(['status' => 'success', 'message' => 'payment of [ '.ucwords($payment->user->name).' ] got recovered!']);
                        } catch (\ErrorException $e) {
                            DB::rollBack();
                            return back()->with(['status' => 'error', 'message' => $e->getMessage()]);
                        }
                    } else {
//                        we assume none of checkboxes has been checked, meaning you just store the payment with type 2 (platform to user, but without increasing/decreasing either credit or plafond)!
                        $payment->update(['approved' => '1']);
                        return back()->with(['status' => 'info', 'message' => 'payment of [ '.ucwords($payment->user->name).' ] has been canceled, without any effect to other tables']);
                    }
                    break;
                case 3:
                    $payment->update(['approved' => '1']);
                    return back()->with(['status' => 'success', 'message' => 'payment of [ \'PLATFORM\' ] has been recovered, without any effect to other tables']);
                    break;
                default:
                    return back()->with(['status' => 'warning', 'message' => 'Payment type is unknown']);
            }
        } catch (\ErrorException $e) {
            DB::rollBack();
            return back()->with(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    //  ###OLD CODE####
//    public function recover($payment)
//    {
//        $payment = Payment::findOrFail($payment);
//        if ($payment->update_balance === 0 && $payment->update_credit == 0) {
//            $payment->update([
//                'approved' => 1
//            ]);
//            $updatedRelation = $payment->type == 3 ? 'Provider' : 'User';
//            return back()->with(['status' => 'success', 'message' => 'payment recovered, '.$updatedRelation.' balance remains the same!']);
//        } else if ($payment->update_credit == 1) {
//            $payment->update([
//                'approved' => 1,
//            ]);
//            $payment->user()->update([
//               'credit' => (float)$payment->user->credit - (float)$payment->amount
//            ]);
//            return back()->with(['status' => 'success', 'message' => 'agent credit recovered']);
//        } else if ($payment->update_balance === 1) {
//            try {
//                DB::beginTransaction();
//                $payment->update([
//                    'approved' => 1
//                ]);
//                $payment->user()->update([
//                   'plafond' => $payment->user->plafond + $payment->amount
//                ]);
//                DB::commit();
//                return back()->with(['status' => 'success', 'message' => 'payment recovered, user balance updated!']);
//            } catch (\Exception $e) {
//                DB::rollBack();
//            }
//        }
//        return back()->with(['status' => 'warning', 'message' => 'payment not found!']);
//    }

    public function trashed()
    {
        $trashed = Payment::onlyTrashed()->paginate(10);
        return view('admin.payments.trashed', compact('trashed'));
    }

//    HELPERS
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
                DB::beginTransaction();
                $payment = Payment::create($dataToCreate);
                if ($payment) {
                    $user = $payment->user;
                    $user->plafond = $user->plafond + $payment->amount;
                    $user->save();
                    $this->fileAdd($payment, $data);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }
        } else {
            try {
                $dataToCreate['update_balance'] = 0;
                DB::beginTransaction();
                $payment = Payment::create($dataToCreate);
                $this->fileAdd($payment, $data);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }
        }
    }

    public function reduceCreditView()
    {
        $users = User::role('sales')->pluck('name','id');
        return view('admin.payments.reduce-credit', compact('users'));
    }

    public function reduceCredit(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'amount' => 'required|gt:0',
            'user_id' => 'required',
            'document'  => 'mimes:jpg,jpeg,doc,docx,png,pdf'
        ]);

        $date = \DateTime::createFromFormat("d/m/Y", $request->date);
        if (!$date) {
            return back()->withErrors(['date' => 'date is required'])->withInput();
        }
        try {
            DB::beginTransaction();
            $user = User::findOrFail($request->user_id);
            $user->update(['credit' => (float)$user->credit - (float)$request->amount]);
            $payment = $user->payments()->create([
                'update_credit' => 1,
                'update_amount' => 0,
                'approved' => 1,
                'type' => 4,
                'amount' => $request->amount,
                'document' => $request->document,
            ]);
            if ($request->hasFile('document')) {
                $filename = 'admin-reduced-credit-' . time() . '.' . $request->document->getClientOriginalExtension();
                $path = $request->document->storeAs('credits', $filename);
                $payment->documents()->create([
                    'label' => $payment->provider->company_data.'-credit-document',
                    'filename' => $path
                ]);
            }
            DB::commit();
            return redirect()->route('admin.payments.index')->with(['status' => 'success', 'message' => 'Successfully reduced credit from agent!']);
        } catch (\Error $error) {
            DB::rollBack();
            dd($error);
        }
    }

    private function validateData(array $data) {
        return Validator::make($data,
            [
                'date'		=> 'required',
                'amount'	=> 'required|gt:0',
                'user_id'	=> 'required',
                'document'  => 'mimes:jpg,jpeg,doc,docx,png,pdf'
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
                'label' => $payment->provider->company_data.'-provider-document',
                'filename' => $path
            ]);
        }
    }
}
