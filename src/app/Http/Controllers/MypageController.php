<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function mypage()
    {
        // itemsテーブルからランダムで複数件取得
        $items = Item::with('images')->inRandomOrder()->get();

        // 現在ログイン中のユーザーを取得
        $user = Auth::user();

        // ビューに渡す
        return view('mypage.mypage', compact('items', 'user'));
    }
}
