<?php

namespace App\Http\Controllers\Api;

use App\CentralLogics\AesEncryption;
use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\PaymentTransaction;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    use ApiResponseTrait;

    public function pay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bill_ids' => 'required|array',
            'amount' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        // Check if all bills exist
        $billIds = $request->input('bill_ids');
        $bills = Bill::whereIn('id', $billIds)->get();

        if (count($bills) !== count($billIds)) {
            $data['message'] = 'One or more bills not found';
            return $this->notFoundApiResponse($data);
        }

        // Create payment transaction
        $bill_no = Helpers::generateUniqueInvoiceNumber();
        $create = new PaymentTransaction();
        $create->amount = $request->input('amount');
        $create->bill_no = $bill_no;
        $create->status = 'pending';
        $create->save();

        // Update bill info
        foreach ($bills as $bill) {
            $bill->payment_transaction_id = $create->id;
            $bill->save();
        }

        $approvedUrl = route('payment.success');
        $cancelUrl = route('payment.cancel');
        $declineUrl = route('payment.decline');

        $amount = $request->input('amount');

        $payload = array(
            "merchantCode"=>"Merchant003",
            "username"=>"merchant_01633557700",
            "password"=>"Pocket@12345",
            "amount"=>$amount,
            "billOrInvoiceNo"=>$bill_no,
            "approvedUrl"=>$approvedUrl,
            "cancelUrl"=>$cancelUrl,
            "declineUrl"=>$declineUrl,
            "description"=>"item descriptions"
        );
        $encrypted_data = AesEncryption::encrypt(json_encode($payload), env('AES_ENCRYPTION_KEY'));

        $result = $this->validate_payment_request($encrypted_data);
        return response()->json($result);
    }

    public function getOtp()
    {
        $url = 'http://test-api.abgpocket.com/api/v1/two/factor/on-demand-service/customer/get/otp';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $data = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($data, true);
        return response()->json($json);
    }

    protected function validate_payment_request($data)
    {
        $url = 'http://test-api.abgpocket.com/api/v1/merchant/external-payment/validate-request';
        $data = array(
            'data' => $data
        );
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Disable SSL verification for testing, remove in production
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'x-api-token: be5987c46270c295da0ae4754dac187d'
        ));

        $response = curl_exec($ch);
        if ($response === false) {
            $errorMessage = curl_error($ch);
            curl_close($ch);
            return ['error' => $errorMessage];
        } else {
            curl_close($ch);
            return json_decode($response, true);
        }
    }

    public function getHistory()
    {
        $user = Auth::user();

        $get_payment_history = User::with(['user_meters.meter.bills.payment_transaction'])
            ->where('id', $user->id)
            ->get();

        $userPaymentHistory = $get_payment_history->map(function ($user) {
            return $user->user_meters->map(function ($userMeter) {
                return $userMeter->meter->bills->filter(function ($bill) {
                    return $bill->payment_status == 1; // where payment_status is 1
                })->map(function ($bill) {
                    return [
                        'bill_id' => $bill->id,
                        'amount' => $bill->amount,
                        'payment_status' => $bill->payment_status,
                        'final_payment_date' => $bill->final_payment_date,
                        'payment_transaction' => $bill->payment_transaction,
                    ];
                });
            })->collapse();
        })->collapse();

        $response['message'] = "User Payment History";
        $response['data'] = $userPaymentHistory;
        return $this->successApiResponse($response);
    }

}
