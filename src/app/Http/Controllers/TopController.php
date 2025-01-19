<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;


class TopController extends Controller
{
    // デフォルトの「おすすめ」商品の表示
    public function top()
    {
        // ランダムでおすすめ商品を取得
        $items = Item::with('images')->inRandomOrder()->get();

        // ビューに渡す
        return view('top', [
            'items' => $items,
            'activeTab' => 'recommend', // 現在のタブを識別
        ]);
    }

    // 「マイリスト」の表示
    public function favorites()
    {
        $user = Auth::user();

        // ログインしている場合のみお気に入り商品を取得
        if ($user) {
            $items = $user->favorites()->with('images')->get();
        } else {
            $items = collect(); // 空のコレクション
        }

        // ビューに渡す
        return view('top', [
            'items' => $items,
            'activeTab' => 'favorites', // 現在のタブを識別
        ]);
    }
}
