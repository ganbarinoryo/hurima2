<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    // デフォルトで「出品した商品」を表示
    public function mypage()
    {
        return $this->selling(); // selling メソッドをそのまま呼び出す
    }

    // 出品した商品の表示
    public function selling()
    {
        $user = auth()->user(); // ログイン中のユーザーを取得
        $items = Item::where('user_id', $user->id)->get();

        return view('mypage.mypage', [
            'items' => $items,
            'user' => $user, // $user をビューに渡す
            'activeTab' => 'selling',
        ]);
    }

    // 購入した商品の表示
    public function purchased()
    {
        $user = auth()->user(); // ログイン中のユーザー
        $items = Item::whereHas('purchases', function ($query) use ($user) {
            $query->where('user_id', $user->id); // user_id を利用
        })->get();

        return view('mypage.mypage', [
            'items' => $items,
            'user' => $user, // $user をビューに渡す
            'activeTab' => 'purchased', //購入済みタブをデフォルトでアクティブ
        ]);
    }

}
