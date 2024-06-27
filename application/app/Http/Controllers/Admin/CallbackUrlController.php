<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Order;
use App\Models\PaymentTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CallbackUrlController extends Controller
{
    public function success(Request $request)
    {
        $payment_transaction = PaymentTransaction::where('bill_no', $request->input('bill_no'))->first();
        $bills = Bill::where('payment_transaction_id', $payment_transaction->id)->get();
        if (!empty($bills)) {
            $payment_transaction->transaction_id = $request->input('transaction_id');
            $payment_transaction->merchant_code = $request->input('merchant_code');
            $payment_transaction->status = $request->input('status');
            $payment_transaction->session_id = $request->input('session_id');
            $payment_transaction->transaction_ref = $request->input('transaction_ref');
            $payment_transaction->save();

            //change bill status
            foreach ($bills as $bill){
                if($bill->payment_status == 0) {
                    $bill->payment_status = 1;
                    $bill->payment_time = Carbon::now('Asia/Dhaka');
                    $bill->save();
                }
            }
        }
        return view('payment.success');
    }
    public function cancel(Request $request)
    {
        $payment_transaction = PaymentTransaction::where('bill_no', $request->input('bill_no'))->first();
        $bills = Bill::where('payment_transaction_id', $payment_transaction->id)->get();
        if (!empty($bills)) {
            $payment_transaction->transaction_id = $request->input('transaction_id');
            $payment_transaction->merchant_code = $request->input('merchant_code');
            $payment_transaction->status = $request->input('status');
            $payment_transaction->session_id = $request->input('session_id');
            $payment_transaction->transaction_ref = $request->input('transaction_ref');
            $payment_transaction->save();
        }
        return view('payment.cancel');
    }
    public function decline(Request $request)
    {
        $payment_transaction = PaymentTransaction::where('bill_no', $request->input('bill_no'))->first();
        $bills = Bill::where('payment_transaction_id', $payment_transaction->id)->get();
        if ($bills) {
            $payment_transaction->transaction_id = $request->input('transaction_id');
            $payment_transaction->merchant_code = $request->input('merchant_code');
            $payment_transaction->status = $request->input('status');
            $payment_transaction->session_id = $request->input('session_id');
            $payment_transaction->transaction_ref = $request->input('transaction_ref');
            $payment_transaction->save();
        }
        return view('payment.decline');
    }
}
