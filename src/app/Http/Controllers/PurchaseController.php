<?php

namespace App\Http\Controllers;
use App\Models\Item;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function purchase($id)
    {
        // 商品情報を取得
        $item = Item::findOrFail($id);

        // 購入ページを表示
        return view('purchase.purchase', compact('item'));
    }
}
