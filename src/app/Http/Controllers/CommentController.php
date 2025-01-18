<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function getComments($itemId)
    {
        // コメントを取得し、ユーザー情報と一緒に取得
        $comments = Comment::where('item_id', $itemId)
            ->with('user:id,user_name,user_icon') // ユーザー情報を取得
            ->orderBy('created_at', 'asc') // コメントの順序を作成日順に
            ->get();

        // コメントとユーザー情報を整形
        $data = $comments->map(function ($comment) {
            return [
                'comment' => $comment->comment,
                'user' => [
                    'name' => $comment->user->user_name,
                    'icon_url' => asset('storage/' . $comment->user->user_icon), // アイコンURLを生成
                ],
            ];
        });

        return response()->json($data); // 整形されたデータを返す
    }

    public function storeComment(Request $request, $itemId)
    {
        // バリデーション
        $request->validate([
            'comment' => 'required|string|max:255', // コメントの最大文字数を設定
        ]);

        // コメントを保存
        $comment = Comment::create([
            'item_id' => $itemId,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        // 保存したコメントに関連するユーザー情報をロード
        $comment->load('user:id,user_name,user_icon');

        // アイコンURLを生成
        $commentData = [
            'comment' => $comment->comment,
            'user' => [
                'name' => $comment->user->user_name,
                'icon_url' => asset('storage/' . $comment->user->user_icon), // アイコンURLを生成
            ],
        ];

        return response()->json($commentData); // コメントとユーザー情報を返す
    }
}
