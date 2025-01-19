<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\ItemImage;

class SellController extends Controller
{
    public function sell()
    {
        return view("sell");
    }

    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'item_name'   => 'required|max:255',
            'description' => 'required|max:1000',
            'category'    => 'required|max:255',
            'condition'   => 'required|max:255',
            'price'       => 'required|numeric|min:1',
            'item_image'  => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB制限
        ]);

        // itemsテーブルにデータを保存
        $item = new Item();
        $item->item_name = $validated['item_name'];
        $item->description = $validated['description'];
        $item->category = $validated['category'];
        $item->condition = $validated['condition'];
        $item->price = $validated['price'];

        // ログイン中のユーザーの ID を設定
        $item->user_id = Auth::id();
        $item->save(); // IDが生成される

        // 画像を保存 (storage/app/public/images に保存)
        if ($request->hasFile('item_image')) {
            $imagePath = $request->file('item_image')->store('public/images');

            // item_imagesテーブルに画像データを保存
            $itemImage = new ItemImage();
            $itemImage->item_id = $item->id; // itemsテーブルのIDを紐付け
            $itemImage->image_url = basename($imagePath); // ファイル名のみ保存
            $itemImage->save();
        }

        // 成功メッセージ付きでリダイレクト
        return redirect()->route('mypage')->with('success', '商品を出品しました！');
    }
}
