<?php

namespace App\Http\Controllers\Api\User;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Meter;
use App\Models\UserMeter;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MeterController extends Controller
{
    use ApiResponseTrait;

    public function get($id)
    {
        $meter = Meter::with(['meter_readers.reader', 'bills' => function ($query) {
            $query->where('payment_status', 0)
                ->orWhere(function ($subQuery) {
                    $subQuery->where('payment_status', 1)
                        ->orderBy('created_at', 'desc')
                        ->limit(1);
                });
            }])
            ->find($id);

        /* Calculate total due */
        $totalDue = 0;
        $currentDate = now();
        foreach ($meter->bills as $bill) {
            if ($bill->payment_status == 0) {
                $finalPaymentDate = Carbon::parse($bill->final_payment_date);
                if ($currentDate->greaterThan($finalPaymentDate)) {
                    $totalDue += $bill->total_after_final_payment_date;
                } else {
                    $totalDue += $bill->amount;
                }
            }
        }

        $data['meter'] = $meter;
        $data['meter']['total_due'] = (string)$totalDue;

        $data['message'] = 'Meter details';

        return $this->successApiResponse($data);
    }

    public function getPreview(Request $request)
    {
        $meter = Meter::with(['meter_readers.reader'])
            ->where('number', $request->input('number'))
            ->first();

        if (!empty($meter)){
            $data['meter'] = $meter;
            $data['message'] = 'Meter details';
            return $this->successApiResponse($data);
        } else {
            $data['message'] = 'Meter not found';
            return $this->notFoundApiResponse($data);
        }
    }

    public function addMeter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $exist_meter = Meter::where('number', $request->number)->first();
        if(!$exist_meter)
        {
            $data['message'] = 'Meter not found';
            return $this->notFoundApiResponse($data);
        }

        $exist_user_meter = UserMeter::where('meter_id', $exist_meter->id)->first();
        if($exist_user_meter)
        {
            $data['message'] = 'Meter is already added';
            return $this->successApiResponse($data);
        }

        $user_meter = new UserMeter();
        $user_meter->user_id = Auth::id();
        $user_meter->meter_id = $exist_meter->id;
        $user_meter->save();

        $data['message'] = 'Meter is added successfully';
        return $this->successApiResponse($data);
    }

    public function removeMeter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $exist_meter = Meter::where('number', $request->number)->first();
        if(!$exist_meter)
        {
            $data['message'] = 'Meter not found';
            return $this->notFoundApiResponse($data);
        }

        $exist_user_meter = UserMeter::where('meter_id', $exist_meter->id)->first();
        if(!$exist_user_meter)
        {
            $data['message'] = 'Meter is not added yet';
            return $this->failureApiResponse($data);
        }
        $exist_user_meter->delete();

        $data['message'] = 'Meter is removed successfully';
        return $this->successApiResponse($data);
    }
}
