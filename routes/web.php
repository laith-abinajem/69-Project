<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

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
Route::get('/', function () {
    return redirect()->route('dashboard.home.index');
});

Route::prefix('auth')->middleware('checkLogin')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login','login')->name('submitLogin');
});

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function(){
    Route::get('/home',[HomeController::class,'index'])->name('home.index');
// inside middle ware
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
});