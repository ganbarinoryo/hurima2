<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\User;

class ItemController extends Controller
{
    public function item($id)
    {
        $item = Item::with('images')->find($id);
        if (!$item) {
            return abort(404, '商品が見つかりません');
        }

        // お気に入り数を取得
        $favoriteCount = $item->favoriteCount();

        // コメント数を取得
        $commentCount = Comment::where('item_id', $id)->count();

        // ログインユーザーがその商品をお気に入り登録しているか判定
        $item->is_favorited = $item->favoritedBy->contains(auth()->user());

        return view('item', compact('item', 'favoriteCount', 'commentCount'));
    }

    public function toggle($id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($id);

        if ($user->favorites()->where('item_id', $id)->exists()) {
            $user->favorites()->detach($id);
            return response()->json(['success' => true, 'favorited' => false]);
        } else {
            $user->favorites()->attach($id);
            return response()->json(['success' => true, 'favorited' => true]);
        }
    }
}