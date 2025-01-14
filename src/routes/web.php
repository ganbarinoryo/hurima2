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
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');

// 会員登録ページ表示
Route::get('/register', [AuthController::class, 'register'])->name('register');
// 会員登録フォーム送信
Route::post('/register', [AuthController::class, 'registerForm'])->name('register.submit');

// 出品フォーム
Route::middleware(['auth'])->group(function () {
    Route::get('/sell', [SellController::class, 'sell']);
    Route::post('/sell', [SellController::class, 'store'])->name('sell.store');
});

// 購入履歴
Route::get('/purchase/{id}', [PurchaseController::class, 'purchase'])->name('purchase.show');



// 認証済みユーザーのみアクセス可能なルート
Route::middleware('auth')->group(function () {
    // プロフィール表示
    Route::get('/mypage', [MypageController::class, 'mypage'])->name('mypage');

    Route::get('/mypage/profile', [ProfileController::class, 'profile'])->name('profile');


    // プロフィール更新処理
    Route::put('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// アイテムページ
Route::get('/item/{id}', [ItemController::class, 'item'])->name('item.show');
// アイテムお気に入り
Route::post('/favorite/toggle/{id}', [ItemController::class, 'toggle'])->name('favorite.toggle');


// 住所ページ
Route::get('/address', [AddressController::class, 'address']);
