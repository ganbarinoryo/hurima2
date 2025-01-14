<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;

class PurchaseController extends Controller
{
    public function purchase($id)
    {
        // 商品情報を取得
        $item = Item::findOrFail($id);

        // 現在のユーザー情報を取得
        $user = Auth::user();

        // 購入ページを表示
        return view('purchase.purchase', compact('item', 'user'));
    }
}
