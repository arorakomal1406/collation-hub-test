<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    function store(Request $request, $id)
    {
        $validated = $request->validate([
            'author_name' => 'required|string',
            'content' => 'required|string',
            'body' => 'required|string',
        ]);

        $comment = Comment::create([
            'author_name' => $validated['author_name'],
            'content' => $validated['content'],
            'post_id' => $id,
        ]);
        return response()->json($comment, 201);
    }

    function delete($commentId)
    {
        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $comment->delete();

        return response()->json(['message'=>"Comment Deleted"], 204);

    }


}
