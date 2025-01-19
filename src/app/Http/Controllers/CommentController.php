<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function storeComment(Request $request, $itemId)
    {
        try {
            // バリデーション
            $request->validate([
                'comment' => 'required|string|max:255',
            ]);

            // コメントを保存
            $comment = Comment::create([
                'item_id' => $itemId,
                'user_id' => Auth::id(),
                'comment' => $request->comment,
            ]);

            // 関連するユーザー情報をロード
            $comment->load('user:id,user_name,user_icon');

            return response()->json([
                'success' => true,
                'data' => [
                    'comment' => $comment->comment,
                    'user' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->user_name,
                        'icon_url' => $comment->user->user_icon
                            ? asset('storage/' . $comment->user->user_icon)
                            : asset('storage/default-icon.png'),
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'コメントの保存に失敗しました。',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getComments($itemId)
    {
        try {
            $comments = Comment::where('item_id', $itemId)
                ->with('user:id,user_name,user_icon') // ユーザー情報を含める
                ->orderBy('created_at', 'asc')
                ->get();

            $currentUserId = auth()->id();

            return response()->json([
                'success' => true,
                'comments' => $comments->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'user_id' => $comment->user_id,
                        'comment' => $comment->comment,
                        'user' => [
                            'id' => $comment->user->id,
                            'name' => $comment->user->user_name,
                            'icon_url' => $comment->user->user_icon
                                ? asset('storage/' . $comment->user->user_icon)
                                : asset('storage/default-icon.png'),
                        ],
                    ];
                }),
                'currentUserId' => $currentUserId,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'コメントの取得に失敗しました。',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
