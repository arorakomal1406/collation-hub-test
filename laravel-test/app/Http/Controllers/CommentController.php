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
        $validated=Validator::make(['id' => $commentId], [
            'id' => 'required|exists:comments,id',
        ])->validate();

        if(!$validated){
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment = Comment::find($commentId);
        $comment->delete();

        return response()->json(['message'=>"Comment Deleted"], 204);
    }


}
