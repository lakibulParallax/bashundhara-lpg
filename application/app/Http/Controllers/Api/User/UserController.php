<?php

namespace App\Http\Controllers\Api\User;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\FileManager;
use App\Models\User;
use App\Models\UserMeter;
use App\Traits\ApiResponseTrait;
use App\Traits\GeoCoderTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mockery\Exception;
use Carbon\Carbon;

class UserController extends Controller
{
    use ApiResponseTrait, GeoCoderTrait;

    public function details(Request $request)
    {
        $data = User::where('id', Auth::id())->first();
        $response['message'] = "Info fetched successfully";
        $response['user_info'] = $data;
        return $this->successApiResponse($response);
    }

    public function profile(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nid' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return $this->failureApiResponse($response);
        }

        $user = Auth::user();
        $user_new_data = [];

        if ($request->input('name')) {
            $user_new_data['name'] = $request->input('name');
        }
        if ($request->input('user_name')) {
            $user_new_data['user_name'] = $request->input('user_name');
        }
        if ($request->input('age')) {
            $user_new_data['age'] = $request->input('age');
        }
        if ($request->input('date_of_birth')) {
            $user_new_data['date_of_birth'] = $request->input('date_of_birth');
        }
        if ($request->input('gender')) {
            $user_new_data['gender'] = $request->input('gender');
        }
        if ($request->input('email')) {
            $emailExist = User::where('email', $request->email)->where('id', '!=', Auth::id())->first();
            if ($emailExist) {
                return response()->json(['message' => "Email already exist. Please try another email."], 422);
            }
            $user_new_data['email'] = $request->input('email');
        }
        if ($request->input('address')) {
            $user_new_data['address'] = $request->input('address');
        }
        if ($request->input('nid')) {
            $user_new_data['nid'] = $request->input('nid');
        }

        $user = User::where('id', $user->id)->update($user_new_data);

        $response['message'] = "User Info Updated Successfully";
        return $this->successApiResponse($response);
    }

    public function showProfile(Request $request): JsonResponse
    {
        if($request->input('id')){
            $checkUser = User::where('id', $request->input('id'))->first();
            if($checkUser){
                $userDetails = User::with(['user_meters.meter', 'user_meters.meter.meter_readers.reader', 'user_meters.meter.bills' => function ($query) {
                    $query->where('payment_status', 0)
                        ->orWhere(function ($subQuery) {
                            $subQuery->where('payment_status', 1)
                                ->orderBy('created_at', 'desc')
                                ->limit(1);
                        });
                }])
                ->where('id', $request->input('id'))
                ->first();

                $data = $userDetails;
                $message = "Specific User Details";
            }
        } else {
            $data = User::find(Auth::id());
            $message = "User details";
        }

        $response = [
            'message' => $message,
            'user_info' => $data,
        ];
        return $this->successApiResponse($response);
    }

    public function addedMeter(Request $request): JsonResponse
    {
        $data = UserMeter::where('user_id', Auth::id())
            ->where('status', 1)
            ->with(['meter', 'meter.meter_readers.reader', 'meter.bills' => function ($query) {
                $query->where('payment_status', 0)
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('payment_status', 1)
                            ->orderBy('created_at', 'desc')
                            ->limit(1);
                    });
            }])
            ->get();

        /* total due */
        $data->each(function ($userMeter) {
            $userMeter->meter->total_due = $userMeter->meter->total_due; // Access the total_due attribute
        });

        $response = [
            'message' => "Added Meter details",
            'added_meters' => $data,
        ];
        return $this->successApiResponse($response);
    }

    public function location(Request $request)
    {
        if (Auth::user()) {
            if ($request->input('latitude') && $request->input('longitude')) {
                $location = $this->getLocationByLatLong($request->input('latitude'), $request->input('longitude'));
                $message = 'Location Fetch Successfully';
            }
            $response = [
                'message' => $message,
                'location_info' => $location,
            ];
            return $this->successApiResponse($response);
        } else {
            $response['message'] = "Token Invalid";
            return response()->json($response, 401);
        }
    }
}
