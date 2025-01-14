<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class MypageController extends Controller
{
    public function mypage()
    {
        // itemsテーブルからランダムで複数件取得
        $items = Item::with('images')->inRandomOrder()->get();

        // ビューに渡す
        return view('mypage.mypage', compact('items'));
    }
}
