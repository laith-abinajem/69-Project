<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\InvoiceController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|14|eyFebBYiEpyl1Hp3aWZqDIIpekT7hKxME59eY2fa4f2f8fec
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum', 'verified'])->get('/user', [UserController::class, 'getUser']);
Route::middleware(['auth:sanctum', 'verified'])->get('/cars', [UserController::class, 'getCars']);
Route::middleware(['auth:sanctum', 'verified'])->post('/createInvoice', [InvoiceController::class, 'createInvoice']);

