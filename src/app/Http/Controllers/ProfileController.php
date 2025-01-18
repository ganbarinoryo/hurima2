<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // プロフィール表示
    public function profile()
    {
        // 現在ログイン中のユーザーを取得
        $user = Auth::user();

        // プロフィールページにユーザー情報を渡してビューを表示
        return view('mypage.profile', compact('user'));
    }


    // プロフィール更新
    public function update(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'user_name' => 'required|max:255',
            'postal_code' => 'required|regex:/\d{3}-\d{4}/',
            'address' => 'required|max:255',
            'building_name' => 'nullable|max:255',
            'user_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        // 現在ログイン中のユーザーを取得
        $user = Auth::user();
        $user->user_name = $validated['user_name'];
        $user->postal_code = $validated['postal_code'];
        $user->address = $validated['address'];
        $user->building_name = $validated['building_name'] ?? $user->building_name;

        // 画像がアップロードされている場合
        if ($request->hasFile('user_icon')) {
            // 画像をpublic/imagesディレクトリに保存
            $imagePath = $request->file('user_icon')->store('public/images');
            
            // 保存された画像のパスを取得（images/で始まるように設定）
            $imageUrl = 'images/' . basename($imagePath);

            // データベースに保存
            $user->user_icon = $imageUrl;
        }

        // 更新をデータベースに保存
        $user->save();

        // プロフィールページにリダイレクト
        return redirect()->route('profile')->with('success', 'プロフィールが更新されました。');
    }


}
