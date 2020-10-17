<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentFile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create($id)
    {
        $payment = Payment::findOrFail($id);
        return view('admin.paymentfiles.create', compact('payment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($payment, Request $request)
    {
        $payment = Payment::findOrFail($payment);
        $file = $request->file('document');
        if (isset($file)) {
            $filename = 'admin-added-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('payments', $filename);
            $bool = $payment->documents()->create([
                'label' => $payment->user->name.'-document-'.time(),
                'filename' => $path
            ]);

            if ($bool) {
                return back()->with(['status' => 'success', 'message' => 'File uploaded successfully!']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentFile  $paymentFile
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentFile $paymentFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentFile  $paymentFile
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentFile $paymentFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentFile  $paymentFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentFile $paymentFile)
    {
        //
    }


    public function destroy($paymentFile)
    {
        $paymentFile = PaymentFile::findOrFail($paymentFile);
        try {
            $paymentFile->delete();
            return back()->with(['status' => 'success','message' => 'file succesfully deleted!']);
        } catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }
}
