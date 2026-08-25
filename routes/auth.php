<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginOwnerController;
use App\Http\Controllers\Auth\RegisteredCustomerController;
use App\Http\Controllers\Auth\LoginCustomerController;
use App\Http\Controllers\Auth\PasswordResetController;

use Illuminate\Support\Facades\Route;

// Route::group(['prefix' => 'admin', 'as' => 'admin.' ], function () {
//     Route::get('/login', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
//     Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');
//     Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');
// });


// Route::group(['prefix' => 'owner', 'as' => 'owner.' ], function () {
//     Route::get('login', [LoginOwnerController::class, 'create'])->name('login');
//     Route::post('login', [LoginOwnerController::class, 'store']);
// });

    // Route::get('/',function(){
    //   return view('auth.login');
    // })->name('login');

    // Route::middleware('guest:customer')->group(function () {
    //     Route::get('login', [LoginCustomerController::class, 'customer_login'])->name('login');
    //     Route::post('store', [LoginCustomerController::class, 'customer_store'])->name('customer_store');
    //     Route::get('register', action: [RegisteredCustomerController::class, 'create'])->name('customer_register');
    //     Route::post('register', [RegisteredCustomerController::class, 'store'])->name('customer_register_store');


    //     Route::get('/user/forgot-password', function () {
    //         return view('auth.forgot-password');
    //     })->name('user.forgot_password');
    //     Route::get('/user/code-verify-password', function () {
    //         return view('auth.code-verify-password');
    //     })->name('user.code_verify_password');
    //     Route::post('/user/reset', [PasswordResetController::class, 'handlePasswordForm'])->name('user.reset');
    //     Route::post('/user/send-code', [PasswordResetController::class, 'sendCode'])->name('user.sendCode');
    //     Route::post('/user/check-code', [PasswordResetController::class, 'checkCode'])->name('user.checkCode');

    //     Route::get('/user/forgot-password', function () {
    //         return view('auth.forgot-password');
    //     })->name('user.forgot_password');
    //     Route::get('/user/code-verify-password', function () {
    //         return view('auth.code-verify-password');
    //     })->name('user.code_verify_password');
    //     Route::post('/user/reset', [PasswordResetController::class, 'handlePasswordForm'])->name('user.reset');
    //     Route::post('/user/send-code', [PasswordResetController::class, 'sendCode'])->name('user.sendCode');
    //     Route::post('/user/check-code', [PasswordResetController::class, 'checkCode'])->name('user.checkCode');


    // });
