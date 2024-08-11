<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\Auth\LoginController as UserLoginController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\User\MeterController;
use App\Http\Controllers\Api\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('user')->group(function () {
    Route::post('login', [UserLoginController::class, 'login']);
    Route::post('otp-verify', [UserLoginController::class, 'check_otp']);
    Route::post('otp-resend', [UserLoginController::class, 'resend_otp']);
    Route::post('register', [UserLoginController::class, 'register']);
    Route::post('password-reset', [UserLoginController::class, 'changePassword']);

    // After Login and Email Verified
    Route::middleware(['auth:user-api'])->group(function () {
        /*Auth Apis*/
        Route::post('password-change-auth', [UserController::class, 'changePasswordAuth']);
        Route::post('logout', [UserController::class, 'logout']);
        /* Profile */
        Route::put('/', [UserController::class, 'profile']);
        Route::get('/', [UserController::class, 'showProfile']);
        Route::get('/added-meters', [UserController::class, 'addedMeter']);
        Route::get('/dashboard', [UserController::class, 'dashboard']);
        Route::get('/location', [UserController::class, 'location']);

        /* Meter */
        Route::post('/add-meter', [MeterController::class, 'addMeter']);
        Route::post('/remove-meter', [MeterController::class, 'removeMeter']);
        Route::get('/meter/{id}', [MeterController::class, 'get']);
        Route::get('/meter-preview', [MeterController::class, 'getPreview']);

        /* Tanker */
        Route::post('/add-meter', [MeterController::class, 'addMeter']);
        Route::post('/remove-meter', [MeterController::class, 'removeMeter']);
        Route::get('/meter/{id}', [MeterController::class, 'get']);
        Route::get('/meter-preview', [MeterController::class, 'getPreview']);

        /* payment */
        Route::group(['prefix' => 'payment'], function () {
            Route::post('/pay', [PaymentController::class, 'pay']);
            Route::get('/get-otp', [PaymentController::class, 'getOtp']);
            Route::get('/history', [PaymentController::class, 'getHistory']);
        });
    });
});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
