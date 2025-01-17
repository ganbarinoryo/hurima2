<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function getComments($itemId)
    {
        $comments = Comment::where('item_id', $itemId)
            ->with('user:id,user_name,user_icon')
            ->orderBy('created_at', 'asc')
            ->get();

        $data = $comments->map(function ($comment) {
            return [
                'comment' => $comment->comment,
                'user' => [
                    'name' => $comment->user->user_name,
                    'icon_url' => $comment->user->user_icon,
                ],
            ];
        });

        return response()->json($data);
    }

    public function storeComment(Request $request, $itemId)
    {
        $request->validate(['comment' => 'required|string|max:255']);

        $comment = Comment::create([
            'item_id' => $itemId,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        $comment->load('user:id,user_name,user_icon');

        return response()->json([
            'comment' => $comment->comment,
            'user' => [
                'name' => $comment->user->user_name,
                'icon_url' => $comment->user->user_icon,
            ],
        ]);
    }
}