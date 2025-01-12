<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function item($id)
    {
        // 商品を取得
        $item = Item::with('images')->find($id);

        // 商品が存在しない場合
        if (!$item) {
            return abort(404, '商品が見つかりません');
        }

        // ビューを返す
        return view('item', compact('item'));
    }
}
