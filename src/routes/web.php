<?php

use App\Http\Controllers\TopController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;

// トップページ
Route::get('/', [TopController::class, 'top']);

// ログインページ表示
Route::get('/login', [AuthController::class, 'login'])->name('login');
// ログインフォーム送信
Route::post('/login', [AuthController::class, 'loginForm'])->name('login.submit');

// 会員登録ページ表示
Route::get('/register', [AuthController::class, 'register'])->name('register');
// 会員登録フォーム送信
Route::post('/register', [AuthController::class, 'registerForm'])->name('register.submit');

// 商品出品
Route::get('/sell', [SellController::class, 'sell']);

// 購入履歴
Route::get('/purchase', [PurchaseController::class, 'purchase']);

// 認証済みユーザーのみアクセス可能なルート
Route::middleware('auth')->group(function () {
    // プロフィール表示
    Route::get('/mypage/profile', [ProfileController::class, 'profile'])->name('profile');

    // プロフィール更新処理
    Route::put('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// マイページ
Route::get('/mypage', [MypageController::class, 'mypage']);

// アイテムページ
Route::get('/item', [ItemController::class, 'item']);

// 住所ページ
Route::get('/address', [AddressController::class, 'address']);
