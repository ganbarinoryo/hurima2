<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

use App\Models\User;

class AuthController extends Controller
{
    // ログインページ表示
    public function login()
    {
        return view('auth.login');
    }

    // ログインフォーム送信
    public function loginForm(Request $request)
    {
        // バリデーション
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // 認証処理
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // ログイン成功
            return redirect()->route('top');  // ログイン後、プロフィールページにリダイレクト
        }

        // ログイン失敗
        return back()->withErrors(['email' => 'メールアドレスまたはパスワードが無効です。']);
    }

    // 会員登録ページ表示
    public function register()
    {
        return view('auth.register');
    }

    // 会員登録フォーム送信
    public function registerForm(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        // ユーザーの作成
        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 登録後のリダイレクト
        return redirect()->route('login');
    }

    public function logout(Request $request)
{
    // ユーザーのログアウト
    Auth::logout();

    // ログアウト後、セッションを無効にする
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // ログインページへリダイレクト
    return redirect()->route('top');
}
}
