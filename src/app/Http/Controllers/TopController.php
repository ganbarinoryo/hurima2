<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;


class TopController extends Controller
{
    public function top()
    {
        // itemsテーブルからランダムで1件取得
        $item = Item::with('images')->inRandomOrder()->first();

        // ビューに渡す
        return view('top', compact('item'));
    }
}
