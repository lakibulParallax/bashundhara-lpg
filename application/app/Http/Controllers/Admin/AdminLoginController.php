<?php

namespace App\Http\Controllers\Admin\Auth;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::ADMIN_HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function guard()
    {
        return Auth::guard('admin');
    }

    public function showLoginForm()
    {
        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
        }
        return view('admin.auth.login');
    }

//    public function login(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'email' => 'required_without:phone_number',
//            'phone_number' => 'required_without:email',
//            'password' => array(
//                'required',
//                'different:name',
//                'min:6',
//            ),
//        ], ['password.regex' => trans('messages.password_regex')]);
//
//        if ($validator->fails()) {
//            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
//        }
//
//        if (Auth::guard('admin-api')->attempt(['email' => request('email'), 'password' => request('password')])) {
//            return redirect()->to('/admin/home');
//        }
//        return back()->withInput($request->only('email', 'remember'))->withErrors($validator);
//    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->route('admin.login');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('admin');
    }

}
