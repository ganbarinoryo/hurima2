<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;

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

    public function store(Request $request, $id)
    {
        // 商品情報を取得
        $item = Item::findOrFail($id);

        // 商品がすでに売却済みの場合、購入できない
        if ($item->status === '売却済') {
            return redirect()->back()->withErrors('この商品はすでに売却されています。');
        }

        // 購入データを保存
        $purchase = new Purchase();
        $purchase->user_id = Auth::id(); // ログイン中のユーザー
        $purchase->item_id = $item->id;
        $purchase->save();

        // 商品のステータスを「売却済」に変更
        $item->status = '売却済';
        $item->save();

        // マイページにリダイレクト（購入済みタブをデフォルトに表示）
        return redirect()->route('mypage.purchased');
    }

}
