<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Meter\MeterController;
use App\Http\Controllers\Admin\Bill\BillController;
use App\Http\Controllers\Admin\Setting\BillSettingsController;
use App\Http\Controllers\Admin\CallbackUrlController;
use App\Http\Controllers\Admin\Setting\RoleManagementController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/admin');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::group(['middleware' =>  ['auth:admin', 'verified']], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::get('/home', [DashboardController::class, 'index'])->name('home');
        Route::post('store', [UserController::class, 'storeAdmin'])->name('store');
        //user list
        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
            Route::get('list', [UserController::class, 'index'])->name('list');
            Route::get('add', [UserController::class, 'add'])->name('add');
            Route::get('status/{id}', [UserController::class, 'status'])->name('status');
            Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::post('store', [UserController::class, 'store'])->name('store');
            Route::get('details/{id}', [UserController::class, 'details'])->name('details');
            Route::get('delete', [UserController::class, 'destroy'])->name('delete');
        });
        //meter
        Route::group(['prefix' => 'meter', 'as' => 'meter.'], function () {
            Route::get('list', [MeterController::class, 'index'])->name('list');
            Route::get('add', [MeterController::class, 'add'])->name('add');
            Route::get('status/{id}', [MeterController::class, 'status'])->name('status');
            Route::get('edit/{id}', [MeterController::class, 'edit'])->name('edit');
            Route::post('store', [MeterController::class, 'store'])->name('store');
            Route::get('details/{id}', [MeterController::class, 'details'])->name('details');
            Route::get('delete', [MeterController::class, 'destroy'])->name('delete');
        });
        //bill
        Route::group(['prefix' => 'bill', 'as' => 'bill.'], function () {
            Route::get('list', [BillController::class, 'index'])->name('list');
            Route::get('add', [BillController::class, 'add'])->name('add');
            Route::get('status/{id}', [BillController::class, 'status'])->name('status');
            Route::get('edit/{id}', [BillController::class, 'edit'])->name('edit');
            Route::post('store', [BillController::class, 'store'])->name('store');
            Route::get('details/{id}', [BillController::class, 'details'])->name('details');
            Route::get('delete', [BillController::class, 'destroy'])->name('delete');
        });
        Route::group(['prefix' => 'bill-settings', 'as' => 'bill-settings.'], function () {
            Route::get('list', [BillSettingsController::class, 'list'])->name('list');
            Route::post('store', [BillSettingsController::class, 'store'])->name('store');
            Route::post('update', [BillSettingsController::class, 'update'])->name('update');
        });
        Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
            Route::get('list', [RoleManagementController::class, 'index'])->name('list');
            Route::post('add', [RoleManagementController::class, 'add'])->name('add');
            Route::post('store', [RoleManagementController::class, 'store'])->name('store');
            Route::post('update', [RoleManagementController::class, 'update'])->name('update');
        });
    });
});

Route::get('payment/success', [CallbackUrlController::class, 'success'])->name('payment.success');
Route::get('payment/cancel', [CallbackUrlController::class, 'cancel'])->name('payment.cancel');
Route::get('payment/decline', [CallbackUrlController::class, 'decline'])->name('payment.decline');
