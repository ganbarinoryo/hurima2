<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function profile()
    {
        return view("mypage.profile");
    }

    // プロフィール情報の更新処理
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

        // 画像がアップロードされている場合の処理
        if ($request->hasFile('user_icon')) {
            $imagePath = $request->file('user_icon')->store('public/images'); // ストレージに保存
            $user->user_icon = basename($imagePath); // ファイル名を保存
        }

        // データベースに保存
        $user->save();

        // 更新後にリダイレクト
        return redirect()->route('profile');
    }

}
