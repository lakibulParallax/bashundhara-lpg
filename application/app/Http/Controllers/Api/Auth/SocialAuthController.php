<?php

namespace App\Http\Controllers\Api\Auth;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Models\User;
//use Firebase\JWT\JWT;
//use Firebase\JWT\Key;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use PeterPetrus\Auth\PassportToken;
use Laravel\Socialite\Two\User as OAuthTwoUser;
//use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function socialLogin(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required_if:medium,google,facebook,apple',
            'unique_id' => 'required_if:medium,facebook',
            'email' => '',  //required_without:phone_number
            'phone_number' => '', //required_without:email
            'phone_code' => 'required_with:phone_number',
            'medium' => 'required|in:google,facebook,apple,phone_number_otp,password',
            'password' => 'required_if:medium,password|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $client = new Client();
        $token = $request['token'];
        $email = $request['email'];
        $phone_number = $request['phone_number'];
        $phone_code = $request['phone_code'];
        $unique_id = $request['unique_id'];

        $data = array();
        if ($request['medium'] == 'google') {
            $res = $client->request('GET', 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $token);
            $data = json_decode($res->getBody()->getContents(), true);
        } elseif ($request['medium'] == 'facebook') {
            $res = $client->request('GET', 'https://graph.facebook.com/' . $unique_id . '?access_token=' . $token . '&&fields=name,email');
            $data = json_decode($res->getBody()->getContents(), true);
        } elseif ($request['medium'] == 'apple') {

            $curl = curl_init();
            $post_fields = "client_secret=" . env('APPLE_CLIENT_SECRET');
            $post_fields .= "&client_id=" . env('APPLE_CLIENT_ID');
            $post_fields .= "&code=" . $request->token;
            $post_fields .= "&grant_type=authorization_code";
            $post_fields .= "&redirect_uri=" . env('APP_URL') . '/redirect/apple';

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://appleid.apple.com/auth/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '', CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 0, CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $post_fields,
                CURLOPT_HTTPHEADER => array('content-type: application/x-www-form-urlencoded'),
            ));

            $response = curl_exec($curl);
            $responseData = json_decode($response, true);
            $socialData = Socialite::driver('apple')->userFromToken($responseData['id_token']);
            $data['id'] = $socialData->attributes['id'];
            $data['email'] = $socialData->user['email'];
            $data['name'] = "apple user";
        } elseif ($request['medium'] === 'phone_number_otp') {
            $user = User::where('phone_number', $phone_number)->first();
            if (isset($user) === false) {
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
        } elseif ($request['medium'] === 'password') {
            if ($this->guard()->attempt($this->credentials($request), $request->boolean('remember'))) {
                if ($request->hasSession()) {
                    $request->session()->put('auth.password_confirmed_at', time());
                }

                $this->limiter()->clear($this->throttleKey($request));

                $token = $this->guard()->user()->createToken(Str::random(40))->accessToken;

                return $this->successApiResponse($token);
            }

            return $this->validationErrorApiResponse([
                "email" => [
                    "Invalid email or password."
                ]
            ]);
        }

        if (($request['medium'] === 'google' || $request['medium'] === 'facebook' || $request['medium'] === 'apple')) {
            $name = @$data['name'];
            $email = @$data['email'];
            $user = User::where('email', $email)->first();
            if (!isset($user)) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'is_active' => 1,
                    'login_medium' => $request['medium'],
                    'social_id' => @$data['id'],
                    'is_phone_verified' => 0,
                    'is_email_verified' => 1,
                    'temporary_token' => Str::random(40)
                ]);
            } else {
                $user->temporary_token = Str::random(40);
                $user->save();
            }

        }

        if (isset($user) && $user->is_active) {
            $token = self::login_process_passport($user);
            $message = "Login Successful";
        } else {
            $token = null;
            $message = "User not active or Account has been suspended";
        }
        return response()->json(['token' => $token, 'message' => $message]);
    }

    public static function login_process_passport($user)
    {
        Auth::loginUsingId($user->id);
        return $user->createToken('LaravelAuthApp')->accessToken;
    }

    public function update_phone(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'temporary_token' => 'required',
            'phone' => 'required|min:11|max:14'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $user = User::where(['temporary_token' => $request->temporary_token])->first();
        $user->phone = $request->phone;
        $user->save();

        return response()->json([
            'token_type' => 'phone verification on',
            'temporary_token' => $request->temporary_token
        ]);
    }

    /**
     * @param  OAuthTwoUser  $socialUser
     * @return User|null
     */
    protected function getLocalUser(OAuthTwoUser $socialUser): ?User
    {
        $user = User::where('email', $socialUser->email)->first();

        return $user;
    }


    /**
     * @param  OAuthTwoUser  $socialUser
     * @return User|null
     */
    protected function registerAppleUser(OAuthTwoUser $socialUser): ?User
    {
        return User::create(
            [
                'full_name' => request()->fullName ? request()->fullName : 'Apple User',
                'email' => $socialUser->email,
                'password' => Str::random(30), // Social users are password-less

            ]
        );
    }

}
