<?php

namespace App\Http\Controllers\Admin\Bill;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Meter;
use App\Models\Settings\BillSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;

class BillController extends Controller
{
    public function index()
    {
        $data['bills'] = Bill::latest()->paginate(10);
        return view('admin.bill.list', $data);
    }

    public function add()
    {
        $data['meters'] = Meter::where('status', 1)->get();

        $billSettings = BillSetting::where('status', 1)->get();
        $unitPrice = $billSettings->where('title', 'unit_price')->first();
        $serviceCharge = $billSettings->where('title', 'service_charge')->first();
        $penaltyForLatePayment = $billSettings->where('title', 'penalty_for_late_payment')->first();

        $data['unit_price'] = $unitPrice ? $unitPrice->value : 0;
        $data['service_charge'] = $serviceCharge ? $serviceCharge->value : 0;
        $data['penalty_for_late_payment'] = $penaltyForLatePayment ? $penaltyForLatePayment->value : 0;

        return view('admin.bill.add', $data);
    }

    public function edit($id)
    {
        $data['bill'] = Bill::where('id', $id)->first();
        $data['meters'] = Meter::where('status', 1)->get();

        $billSettings = BillSetting::where('status', 1)->get();
        $unitPrice = $billSettings->where('title', 'unit_price')->first();
        $serviceCharge = $billSettings->where('title', 'service_charge')->first();
        $penaltyForLatePayment = $billSettings->where('title', 'penalty_for_late_payment')->first();

        $data['unit_price'] = $unitPrice ? $unitPrice->value : 0;
        $data['service_charge'] = $serviceCharge ? $serviceCharge->value : 0;
        $data['penalty_for_late_payment'] = $penaltyForLatePayment ? $penaltyForLatePayment->value : 0;

        return view('admin.bill.add', $data);
    }

    public function details($id)
    {
        $data['user'] = Meter::where('id', $id)->first();
        $data['stuffs'] = User::where('is_staff', 1)->where('status', 1)->get();
        return view('admin.meter.details', $data);
    }

    public function status(Request $request)
    {
        $item = Meter::find($request->id);
        $item->status = !$item->status;
        $item->save();
        return redirect()->back()->with('message', 'Meter Status Updated Successfully!');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meter_id' => 'required',
            'present_reading' => 'required',
            'previous_reading' => 'required',
            'consumption' => 'required',
            'unit_price' => 'required',
            'service_charge' => 'required',
            'amount' => 'required',
            'penalty_for_late_payment' => 'required',
            'total_after_final_payment_date' => 'required',
            'bill_month' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'meter_reading_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->input('id')) {
            $meterReadingDate = new \DateTime($request->meter_reading_date);
            $meterReadingDate->modify('+1 month');
            $finalPaymentDate = $meterReadingDate->format('Y-m-d');

            // Update existing bill info
            try {
                $bill = Bill::findOrFail($request->input('id'));
                $bill->meter_id = $request->meter_id;
                $bill->present_reading = $request->present_reading;
                $bill->previous_reading = $request->previous_reading;
                $bill->consumption = $request->consumption;
                $bill->unit_price = $request->unit_price;
                $bill->service_charge = $request->service_charge;
                $bill->amount = $request->amount;
                $bill->penalty_for_late_payment = $request->penalty_for_late_payment;
                $bill->total_after_final_payment_date = $request->total_after_final_payment_date;
                $bill->bill_month = $request->bill_month;
                $bill->start_date = $request->start_date;
                $bill->end_date = $request->end_date;
                $bill->meter_reading_date = $request->meter_reading_date;
                $bill->final_payment_date = $finalPaymentDate;
                $bill->save();
                return redirect('admin/bill/list')->with('message', 'Meter Info Updated Successfully!');

            } catch (Exception $e){
                Log::info($e->getMessage());
                return redirect()->back()->with('error', 'Something Went wrong!');
            }

        } else {
            $meterReadingDate = new \DateTime($request->meter_reading_date);
            $meterReadingDate->modify('+1 month');
            $finalPaymentDate = $meterReadingDate->format('Y-m-d');

            // Create a new bill
            try {
                $bill = new Bill();
                $bill->meter_id = $request->meter_id;
                $bill->present_reading = $request->present_reading;
                $bill->previous_reading = $request->previous_reading;
                $bill->consumption = $request->consumption;
                $bill->unit_price = $request->unit_price;
                $bill->service_charge = $request->service_charge;
                $bill->amount = $request->amount;
                $bill->penalty_for_late_payment = $request->penalty_for_late_payment;
                $bill->total_after_final_payment_date = $request->total_after_final_payment_date;
                $bill->bill_month = $request->bill_month;
                $bill->start_date = $request->start_date;
                $bill->end_date = $request->end_date;
                $bill->meter_reading_date = $request->meter_reading_date;
                $bill->final_payment_date = $finalPaymentDate;
                $bill->save();

                return redirect('admin/bill/list')->with('message', 'New Bill Added Successfully!');
            } catch (Exception $e){
                Log::info($e->getMessage());
                return redirect()->back()->with('error', 'Something Went wrong!');
            }
        }

    }

    public function destroy(Request $request)
    {
        if(!empty($request->input('id'))){
            //bill delete
            Bill::where('id', $request->input('id'))->delete();
        }
        return redirect('admin/bill/list')->with('message', 'Bill Deleted Successfully!');
    }
}
