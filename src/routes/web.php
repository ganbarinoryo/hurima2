<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AddressController;


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

Route::get('/', [TopController::class, 'top']);

Route::get('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'registerForm']);

Route::get('/sell', [SellController::class, 'sell']);

Route::get('/purchase', [PurchaseController::class, 'purchase']);

Route::get('/mypage/profile', [ProfileController::class, 'profile']);

Route::get('/mypage', [MypageController::class, 'mypage']);

Route::get('/item', [ItemController::class, 'item']);

Route::get('/address', [AddressController::class, 'address']);