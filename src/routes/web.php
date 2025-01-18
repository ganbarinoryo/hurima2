<?php

use App\Http\Controllers\TopController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

// トップページ
Route::get('/', [TopController::class, 'top']);

// ログイン関連
Route::get('/login', [AuthController::class, 'login'])->name('login'); // ログインページ表示
Route::post('/login', [AuthController::class, 'loginForm'])->name('login.submit'); // ログインフォーム送信
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout'); // ログアウト

// 会員登録関連
Route::get('/register', [AuthController::class, 'register'])->name('register'); // 会員登録ページ表示
Route::post('/register', [AuthController::class, 'registerForm'])->name('register.submit'); // 会員登録フォーム送信

// 認証済みユーザーのみアクセス可能なルート
Route::middleware('auth')->group(function () {

    // マイページ関連
    Route::get('/mypage', [MypageController::class, 'mypage'])->name('mypage');

    // プロフィール表示と更新ルート
    Route::get('/mypage/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');



    // 出品関連
    Route::get('/sell', [SellController::class, 'sell'])->name('sell.show'); // 出品フォーム
    Route::post('/sell', [SellController::class, 'store'])->name('sell.store'); // 出品処理

    // 購入履歴
    Route::get('/purchase/{id}', [PurchaseController::class, 'purchase'])->name('purchase.show'); // 購入履歴表示

    // コメント関連
    Route::get('/items/{id}/comments', [CommentController::class, 'getComments']); // コメント取得
    Route::post('/items/{id}/comments', [CommentController::class, 'storeComment'])->name('comments.store'); // コメント投稿

    // 住所ページ
    Route::get('/address', [AddressController::class, 'address'])->name('address.show'); // 住所ページ表示
});

// アイテム関連（認証なしでもアクセス可能）
Route::get('/item/{id}', [ItemController::class, 'item'])->name('item.show'); // アイテム詳細表示
Route::post('/favorite/toggle/{id}', [ItemController::class, 'toggle'])->name('favorite.toggle'); // お気に入り登録/解除
