<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TintBrandController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/////////////////////////////

Route::get('/', function () {
    return redirect()->route('dashboard.home.index');
});
//Laith change this route

Route::get('/checkout', function () {
    return view('dashboard.checkout');
});

// Route::post('/dashboard.process-payment', [PaymentController::class, 'createPayment'])->name('dashboard.process-payment');
Route::post('/processPayment', [PaymentController::class, 'processPayment'])->name('processPayment');


Route::prefix('auth')->middleware('checkLogin')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login','login')->name('submitLogin');
    Route::get('/forget-password','forgetPassword')->name('forget-password');
    Route::get('/send-code','SendCode')->name('SendCode');
    Route::get('/check','check')->name('check');
    Route::get('/checkCode','checkCode')->name('checkCode');
    Route::get('/resetPassword','resetPassword')->name('resetPassword');
    Route::get('/checkPassword', 'checkPassword')->middleware('checkResetStep')->name('checkPassword');
});

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function(){
    Route::get('/check-payment', [PaymentController::class, 'checkPayment'])->name('check-payment');
    Route::get('/create-package-square', [PaymentController::class, 'createSubscriptionPlans']);
    Route::get('/get-packages-square', [PaymentController::class, 'listSubscriptionPlans']);
    // Route::get('/create-payment-2', [PaymentController::class, 'createPayment2']);
    Route::post('/process-payment', [PaymentController::class, 'createPayment2'])->name('process-payment');

    //////////////////////////////////
    Route::get('/home',[HomeController::class,'index'])->name('home.index');
    Route::get('/payment-success', function () {
        return view('dashboard.success');
    })->name('payment-success');
    Route::get('/payment-failed', function () {
        return view('dashboard.failed');
    })->name('payment-failed');
    Route::post('/upload',[UserController::class,'uploadLargeFiles'])->name('upload');

    Route::prefix('user')->name('user.')->group(function(){
        Route::get('/',[UserController::class,'index'])->name('index');
        Route::get('/edit/{id}',[UserController::class,'edit'])->name('edit');
        Route::post('/update/{id}',[UserController::class,'update'])->name('update');
    });

    Route::prefix('user')->name('user.')->middleware('role:Super Admin')->group(function () {
        Route::get('/create',[UserController::class,'create'])->name('create');
        Route::post('/delete/{id}',[UserController::class,'delete'])->name('delete');
        Route::post('/store',[UserController::class,'store'])->name('store');
        Route::post('/updateStatus',[UserController::class,'updateStatus'])->name('updateStatus');
    });
    Route::prefix('tint')->name('tint.')->group(function(){
        Route::get('/',[TintBrandController::class,'index'])->name('index');
        Route::get('/filter',[TintBrandController::class,'filter'])->name('filter');
        Route::get('/create',[TintBrandController::class,'create'])->name('create');
        Route::get('/edit/{id}',[TintBrandController::class,'edit'])->name('edit');
        Route::put('/update/{id}',[TintBrandController::class,'update'])->name('update');
        Route::post('/delete/{id}',[TintBrandController::class,'delete'])->name('delete');
        Route::post('/store',[TintBrandController::class,'store'])->name('store');
    });
    // Route::prefix('subscription')->name('subscription.')->middleware('role:Super Admin')->group(function () {
        Route::prefix('subscription')->name('subscription.')->group(function(){
        Route::get('/',[SubscriptionController::class,'index'])->name('index');
        Route::get('/create',[SubscriptionController::class,'create'])->name('create');
        Route::get('/edit/{id}',[SubscriptionController::class,'edit'])->name('edit');
        Route::post('/update/{id}',[SubscriptionController::class,'update'])->name('update');
        Route::post('/delete/{id}',[SubscriptionController::class,'delete'])->name('delete');
        Route::post('/store',[SubscriptionController::class,'store'])->name('store');
    });
    Route::prefix('package')->name('package.')->middleware('role:Super Admin')->group(function () {
        Route::get('/',[PackageController::class,'index'])->name('index');
        Route::get('/create',[PackageController::class,'create'])->name('create');
        Route::get('/edit/{id}',[PackageController::class,'edit'])->name('edit');
        Route::post('/update/{id}',[PackageController::class,'update'])->name('update');
        Route::post('/delete/{id}',[PackageController::class,'delete'])->name('delete');
        Route::post('/store',[PackageController::class,'store'])->name('store');
    });
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');
});