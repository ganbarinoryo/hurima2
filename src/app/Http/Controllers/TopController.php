<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;


class TopController extends Controller
{
    public function top()
    {
        // itemsテーブルからランダムで複数件取得
        $items = Item::with('images')->inRandomOrder()->get();

        // ビューに渡す
        return view('top', compact('items'));
    }
}
