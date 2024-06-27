<?php

namespace App\Http\Controllers\Api\Auth;

use App\CentralLogics\helpers;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\ApiResponseTrait;
use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    use AuthenticatesUsers, ApiResponseTrait;

    protected string $redirectTo = RouteServiceProvider::USER_HOME;

    public function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('user');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required_without:phone_number',
            'phone_number' => 'required_without:email',
            'phone_code' => 'required_with:phone_number',
            'medium' => 'required|in:phone_number_otp,password',
            'password' => 'required_if:medium,password|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $email = $request['email'];
        $phone_number = $request['phone_number'];
        $phone_code = $request['phone_code'];
        if ($request['medium'] === 'phone_number_otp') {
            $user = User::where('phone_number', $phone_number)->first();
            if (!isset($user)) {
                $user = User::create([
                    'phone_number' => $phone_number,
                    'phone_code' => $phone_code,
                    'is_active' => 1,
                    'login_medium' => $request['medium'],
                    'is_phone_verified' => 1,
                    'is_email_verified' => 0,
                    'temporary_token' => Str::random(40)
                ]);
            } else {
                $user->temporary_token = Str::random(40);
                $user->save();
            }
        } elseif($request['medium'] === 'password') {
            if ($this->guard()->attempt($this->credentials($request), $request->boolean('remember'))) {

                if ($request->hasSession()) {
                    $request->session()->put('auth.password_confirmed_at', time());
                }
                $this->limiter()->clear($this->throttleKey($request));
                $token = $this->guard()->user()->createToken(Str::random(40))->accessToken;
                return response()->json([
                    'status' => 200,
                    'message' => 'Login successful',
                    'token' => $token,
                ], 200);
            }

            return response()->json([
                'status' => 401,
                'message' => 'Invalid email or password.'
            ], 401);
        }

        if (isset($user) && $user->is_active) {
            $status = 200;
            $token = self::login_process_passport($user);
            $message = "Login Successful";
        } else {
            $status = 404;
            $token = null;
            $message = "User not active or Account has been suspended";
        }
        return response()->json([
            'status' => $status,
            'token' => $token,
            'message'=> $message
        ]);
    }

    public static function login_process_passport($user)
    {
        Auth::loginUsingId($user->id);
        return $user->createToken('LaravelAuthApp')->accessToken;
    }

    protected function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());
    }

    protected function limiter()
    {
        return app(RateLimiter::class);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->successApiResponse('User Logout successfully');
    }

}
