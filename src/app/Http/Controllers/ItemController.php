<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

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

    public function toggle($id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($id);

        if ($user->favorites()->where('item_id', $id)->exists()) {
            // 既にお気に入りの場合、削除
            $user->favorites()->detach($id);
            return response()->json(['success' => true, 'favorited' => false]);
        } else {
            // お気に入りに追加
            $user->favorites()->attach($id);
            return response()->json(['success' => true, 'favorited' => true]);
        }
    }
}
